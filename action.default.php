<?php

//Common initialization
include_once('inc.initialization.php');

/*******************************************/

//Default values in view class
$titleParam = $this->_getDefaultTitle();
$langParam = $this->_getDefaultLang();

/*******************************************/

// Case wiki/en_US/home/view/2
if(!empty($params['version_id'])){
	$version_id = $params['version_id'];
}

if(!empty($params['wtitle'])){
	$titleParam = $this->clean_title($params['wtitle']);
}
if(!empty($params['wlang'])){
	$langParam = $params['wlang'];
}

//Get Lang
$example = new OrmExample();
$example->addCriteria('label', OrmTypeCriteria::$EQ, array($langParam));
$langs = OrmCore::findByExample(new Lang(),$example);
if(count($langs) == 0){
	$lang = null;
} else {
	$lang = $langs[0];
}

if($lang == null){
	$errors[] = 'lang_mandatory';
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($this->_getDefaultLang(), $this->_getDefaultTitle()));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
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
	

if(!empty($params['werrors'])){
	$errors = explode('|',$params['werrors']);
	$smarty->assign('errors', $errors);
}

//Avoid delete default page/default lang
$isDefaultPage = false;
if($page != null && $page->get('title') == $this->_getDefaultTitle() 
	&& $lang != null && $lang->get('label') == $this->_getDefaultLang()){
	$isDefaultPage = true;
}
$smarty->assign('isDefaultPage', $isDefaultPage);


// Case wiki/en_US/home/view/999999
if($version_id != null && $version == null){
	echo "The revision {$version_id} is not an known revision.";
	return;
}


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