
<?php

define('_JS_ACTION_',FALSE);
$has_error = false;

//Default values in view class
$titleParam = $this->_getDefaultTitle();
$langParam = $this->_getDefaultLang();

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

// Case wiki/en_US/home/view/2
if(!empty($params['version_id'])){
	$version_id = $params['version_id'];
}

$page = PagesService::getOneByTitle($titleParam);
$vals = null;

if($page !== null){

	$statusToCheck = null;
	if($version_id == null){ // Case wiki/en_US/home/view/2
		$statusToCheck = Version::$STATUS_CURRENT;
	}

	$version = VersionsService::getOne(
			$page->get('page_id'), 
			$lang->get('lang_id'),
			$version_id,
			$statusToCheck);


	if($version !== null){
		$vals = $version->getValues();
	}
}

//Avoid delete default page/default lang
$isDefaultPage = false;
if($page != null && $page->get('title') == $this->_getDefaultTitle() 
	&& $lang != null && $lang->get('code') == $this->_getDefaultLang()){
	$isDefaultPage = true;
}
$smarty->assign('isDefaultPage', $isDefaultPage);

// Case wiki/en_US/home/view/999999
if($version_id != null && $version == null){
	$errors[] = array('revision_unknow', $version_id);
	$smarty->assign('errors',$errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}	


if($page == null || $version == null){
	//Menu
	include_once('inc.menu.php');
	//Creation
	include_once('inc.createPage.php');
} else {
	//Menu
	include_once('inc.menu.php');
	//SubPage
	include_once('inc.childrens.php');
	//Include langs
	include_once('inc.langs.php');
	//Include last 10 versions
	include_once('inc.last10versions.php');
	//Breadcrumbs
	include_once('inc.breadcrumbs.php');
	//Display
	include_once('inc.viewPage.php');
}

?>