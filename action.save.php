<?php

define('_JS_ACTION_',TRUE);
$has_error = false;

//Common initialization
include_once('inc.initialization.php');

if($has_error){return;}

/* Variables available :
 *
 * $errors & $messages
 * $smarty
 * $titleParam & $langParam
 * $lang
 * $prefix from preferences prefix
 * $prefix_lang with preferences show_prefix_lang
 * $engine
 * $all_langs_by_code && $all_langs_by_id
 * $isDefaultLang
 *
 **/

$textParam = '';
if(!empty($params['wtext'])){
	$textParam = $this->js_urldecode($params['wtext']);
}
$titleParam = '';
if(!empty($params['wtitle'])){
	$titleParam = $this->js_urldecode($params['wtitle']);
}
$pageParam = null;
if(!empty($params['page_id'])){
	$pageParam = $params['page_id'];
}
//In case of creation of a new version/page
if(!empty($params['create_page_title'])){
	$new_page_title = $params['create_page_title'];
} 
if($titleParam == null){
	$errors[] = 'title_mandatory';
} 
if($textParam == null){
	$errors[] = 'text_mandatory';
}


if(!empty($errors)) {
	$additionnalParameters = array();
	if($titleParam != null){
		$additionnalParameters['wtitle'] = urlencode($titleParam);
	}
	if($textParam != null){
		$additionnalParameters['wtext'] = urlencode($textParam);
	}
	$url = RouteMaker::getEditRoute($id, $returnid, $this->_getDefaultLang(), $this->_getDefaultTitle(), $additionnalParameters);

	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Creation of new page+version
if(isset($new_page_title)){
	//Try to find the page if it's already exist, just in case
	$page = PagesService::getOneByTitle($new_page_title);
	if($page != null){
		$pageParam = $page->get('page_id');
	}
}

if(empty($pageParam) && isset($new_page_title)){
	$page = new Page();
	$page->set('title',$new_page_title);
	$page->set('prefix', '');
	$page = $page->save();
	//Modification or Creation of new version
} else if(!empty($pageParam)){
	
	$page = PagesService::getOneById($pageParam);

	if($page == null){
		throw new Exception("Id of page not found :  ".$pageParam, 1);	
	}

	//Update all the old versions in "last version"
	$version = new Version();
	$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang={$lang->get('lang_id')} AND page={$page->get("page_id")}";
	OrmDb::execute($query);
} else {
	throw new Exception("I can't find id of page or title of new page", 1);		
}

/*
//get Page
$page = null;
if($pageParam != null){
	$page = PagesService::getOneById($pageParam);
} else {
	$title_of_the_page = $titleParam;
	if(isset($new_page_title)){
		$title_of_the_page = $new_page_title;
	}
	//Avoid conflict with existing version with same lang / same title
	$page = PagesService::getOneByTitle($title_of_the_page);
	if
	$example = new OrmExample();
	$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
	$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($lang->get('lang_id')));
	$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
	$versions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,1));
	if(empty($versions)){
		$page = new Page();
		$page->set('prefix', '');
		$page->set('title', $titleParam);
		$page = $page->save();
	} else {
		$version = $versions[0];
		$page = $version->get('page');
	}
	
}*/

//Avoid edit title of version "en_US/home"
/*
if($page->get('title') == $this->_getDefaultTitle() && $titleParam != $this->_getDefaultTitle() && $lang->get('code') == $this->_getDefaultLang()){
	$errors[] = 'default_page_with_new_title';
	$url = RouteMaker::getEditRoute($id, $returnid, $this->_getDefaultLang(), $this->_getDefaultTitle());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}*/


//Always create new Version
$version = new Version();

list($currentUS, $currentTS) = explode(" ", microtime());
$version->set('engine',Engines::$MARKDOWN);
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page',$page->get('page_id'));
$version->set('lang',$lang->get('lang_id'));
$version->set('status',$version::$STATUS_CURRENT);
$version->set('title',$titleParam);
$version->set('text',$textParam);
$version = $version->save();

//$url = RouteMaker::getViewRoute($id, $returnid, $lang->get('code'), $titleParam);
$url = RouteMaker::getViewRoute($id, $returnid, $lang->get('code'), $page->get('title'));
$url = str_replace('&amp;', '&', $url);
header("Location: {$url}");
return;



?>