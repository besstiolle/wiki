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
$example = new OrmExample();
$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($lang->get('lang_id')));
$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));

$versions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,1));
if(empty($versions)){

	//Ok, we try to find a link to a page with another lang
	$example = new OrmExample();
	$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
	$example->addCriteria('lang', OrmTypeCriteria::$NEQ, array($lang->get('lang_id')));
	$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));

	$versions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,1));
	if(empty($versions)){
		$version = null;
		$vals = null;
		$page = null;
	} else {
		$version = $versions[0];
		$vals = $version->getValues();
		$page = $version->get('page');
	}
} else {
	$version = $versions[0];
	$vals = $version->getValues();
	$page = $version->get('page');
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