<?php
if (!function_exists('cmsms')) exit;

define('_JS_ACTION_',FALSE);


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


//Get Version
$version = null;
$vals = null;

$version = VersionsService::getOne($page->get('page_id'), $lang->get('lang_id'), 
							null, Version::$STATUS_CURRENT);
if($version == null){

	//Ok, we try to find a link to a page with another lang
	$version = VersionsService::getOne($page->get('page_id'), null, 
							null, Version::$STATUS_CURRENT);
}

/*if($version != null){
	$vals = $version->getValues();
}
*/

if($version == null){
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