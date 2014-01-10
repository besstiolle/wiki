<?php

//Common initialization
include_once('inc.initialization.php');

/*******************************************/

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
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute('en_US', 'home'));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

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

if(!empty($params['werrors'])){
	$errors = explode('|',$params['werrors']);
	$smarty->assign('errors', $errors);
}

//Avoid edit title of default page/default lang
$isDefaultPage = false;
if($page != null && $page->get('title') == 'home' 
	&& $lang != null && $lang->get('label') == 'en_US'){
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