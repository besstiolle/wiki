<?php
if (!function_exists('cmsms')) exit;

define('_JS_ACTION_',FALSE);

//Default values in view class in case of {Wiki} 
if(empty($params['palias'])) {
	$params['palias'] = $this->_getDefaultAlias();
}
if(empty($params['vlang'])) {
	$params['vlang'] = $this->_getDefaultLang();
}

//Common initialization
include_once('inc.initialization.php');

if($has_error){return;}


/* Variables available :
 *
 * $errors & $messages
 * $smarty
 * $aliasParam & $langParam
 * $page & $lang
 * $prefix from preferences prefix
 * $code_iso with preferences show_code_iso
 * $engine
 * $all_langs_by_code && $all_langs_by_id
 * $isDefaultLang $isDefaultPage $isDefaultVersion
 *
 **/


$statusToCheck = null;
$version_id = null;
if(!empty($params['version_id'])){ // Case wiki/en_US/home/view/2
	$version_id = $params['version_id'];
} else {
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


/*//Avoid delete default page/default lang
$isDefaultPage = false;
if($page != null && $page->get('alias') == $this->_getDefaultAlias() && $isDefaultLang){
	$isDefaultPage = true;
}*/

// Case wiki/en_US/home/view/999999
if($version_id != null && $version == null){
	$errors[] = array('revision_unknow', $version_id);
	$smarty->assign('errors',$errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}	


if($version == null){
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