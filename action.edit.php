<?php

define('_JS_ACTION_',FALSE);
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


//Get Version
$page = PagesService::getOneByTitle($titleParam);
$version = null;
$vals = null;

if($page != null){

	$version = VersionsService::getOne($page->get('page_id'), $lang->get('lang_id'), 
								null, Version::$STATUS_CURRENT);
	if($version == null){

		//Ok, we try to find a link to a page with another lang
		$version = VersionsService::getOne($page->get('page_id'), null, 
								null, Version::$STATUS_CURRENT);
	}

	if($version != null){
		$vals = $version->getValues();
	}
}


//Avoid edit title of default page/default lang
$isDefaultPage = false;
if($page != null && $page->get('title') == $this->_getDefaultTitle()
	&& $lang != null && $lang->get('code') == $this->_getDefaultLang()){
	$isDefaultPage = true;
}
$smarty->assign('isDefaultPage', $isDefaultPage);

if($page == null || $version == null){
	//Menu
	include_once('inc.menu.php');
	//Creation
	include_once('inc.createPage.php');
} else {
	//Menu
	include_once('inc.menu.php');
	//Edition
	include_once('inc.editPage.php');
}

?>