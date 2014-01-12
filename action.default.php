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
 *
 **/

// Case wiki/en_US/home/view/2
if(!empty($params['version_id'])){
	$version_id = $params['version_id'];
}

//Get Version
$example = new OrmExample();
$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));

if($version_id != null){ // Case wiki/en_US/home/view/2
	$example->addCriteria('version_id', OrmTypeCriteria::$EQ, array($version_id));
} else {
	$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
}

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

//Include last 10 versions
include_once('inc.last10versions.php');

if($page == null || $version == null){
	//Creation
	include_once('inc.createPage.php');
} else {
	//Breadcrumbs
	include_once('inc.breadcrumbs.php');
	//Display
	include_once('inc.viewPage.php');
}

?>