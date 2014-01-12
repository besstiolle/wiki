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
 *
 **/

if(!empty($params['wtext'])){
	$textParam = $this->js_urldecode($params['wtext']);
}
if($titleParam == null){
	$errors[] = 'title_mandatory';
} 
if($textParam == null){
	$errors[] = 'text_mandatory';
}

if(!empty($errors)) {
	$url = RouteMaker::getEditRoute($this->_getDefaultLang(), $this->_getDefaultTitle());
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
if($page->get('title') == $this->_getDefaultTitle() && $titleParam != $this->_getDefaultTitle() && $lang->get('code') == $this->_getDefaultLang()){
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


$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($lang->get('code'), $titleParam));
header("Location: {$url}");
return;


?>