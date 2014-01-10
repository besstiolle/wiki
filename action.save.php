<?php

//Common initialization
include_once('inc.initialization.php');

/*******************************************/


if(!empty($params['page_id'])){
	$pageParam = $params['page_id'];
}
if(!empty($params['lang_id'])){
	$langParam = $params['lang_id'];
}
if(!empty($params['wtitle'])){
	$params['wtitle'] = $this->clean_title($this->js_urldecode($params['wtitle']));
	//$params['wtitle'] = preg_replace('`[^\p{L}0-9\-:_]*`u','', html_entity_decode($params['wtitle']));
	$titleParam = $params['wtitle'];
}
if(!empty($params['wtext'])){
	$params['wtext'] = $this->js_urldecode($params['wtext']);
	$textParam = $params['wtext'];
}
if($langParam == null){
	$errors[] = 'lang_id_mandatory';
	$url = RouteMaker::getViewRoute($this->_getDefaultLang(), $this->_getDefaultTitle());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Get Lang
$lang = OrmCore::findById(new Lang(),$langParam);

if($lang == null){
	$errors[] = 'lang_mandatory';
}
if($titleParam == null){
	$errors[] = 'title_mandatory';
} 

//$titleParam = preg_replace('`[^\p{L}0-9\-:_]*`u','', html_entity_decode($titleParam));

if($textParam == null){
	$errors[] = 'text_mandatory';
}
if(!empty($errors)) {
	if($lang != null) {
		$url = RouteMaker::getEditRoute($this->_getDefaultLang(), $this->_getDefaultTitle());
	} else {
		$url = RouteMaker::getViewRoute($this->_getDefaultLang(), $this->_getDefaultTitle());
	}
	
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
	
}

//get Page
$page = null;
if($pageParam != null){
	$page = OrmCore::findById(new Page(),$pageParam);
} else {
	$page = new Page();
	$page->set('prefix', '');
	$page->set('title', $titleParam);
	$page = $page->save();
}

//Avoid edit title of version "en_US/home"
if($page->get('title') == $this->_getDefaultTitle() && $titleParam != $this->_getDefaultTitle() && $lang->get('label') == $this->_getDefaultLang()){
	$errors[] = 'default_page_with_new_title';
	$url = RouteMaker::getEditRoute($this->_getDefaultLang(), $this->_getDefaultTitle());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}


//Always create new Version
$version = new Version();

//Update old version in "last version"
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang_id={$lang->get($lang->getPk()->getName())} AND page_id={$page->get($page->getPk()->getName())}";
OrmDb::execute($query);


list($currentUS, $currentTS) = explode(" ", microtime());
$version->set('engine',Engines::$MARKDOWN);
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page_id',$page->get($page->getPk()->getName()));
$version->set('lang_id',$lang->get($lang->getPk()->getName()));
$version->set('status',$version::$STATUS_CURRENT);
$version->set('title',$titleParam);
$version->set('text',$textParam);

$version = $version->save();


$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($lang->get('label'), $titleParam));
header("Location: {$url}");
return;


?>