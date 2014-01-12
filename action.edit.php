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
 *
 **/


//Get Version
$example = new OrmExample();
$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));

$versions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,1));
if(count($versions) == 0){
	$version = null;
	$vals = null;
	$page = null;
} else {
	$version = $versions[0];
	$vals = $version->getValues();
	$page = OrmCore::findById(new Page(),$version->get('page_id'));
}

//Avoid edit title of default page/default lang
$isDefaultPage = false;
if($page != null && $page->get('title') == $this->_getDefaultTitle()
	&& $lang != null && $lang->get('code') == $this->_getDefaultLang()){
	$isDefaultPage = true;
}
$smarty->assign('isDefaultPage', $isDefaultPage);

if($page == null || $version == null){
	//Creation
	include_once('inc.createPage.php');
} else {
	//Edition
	include_once('inc.editPage.php');
}

?>