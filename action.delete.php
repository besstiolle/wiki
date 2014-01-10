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

if($lang != null){
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
		
} else { //Error cases
	$errors[] = 'lang_mandatory';
	$url = $this->CreateLink ($id, "default", $returnid, '', array('errors'=>$errors), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $titleParam));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}
if($version == null){ //Go back to home
	$errors[] = 'version_unknow';
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $this->_getDefaultTitle()));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

if($page->get('title') == $this->_getDefaultTitle() && $lang->get('label') == $this->_getDefaultLang()){ //Don't allow that.
	$errors[] = 'default_version_undeletable';
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $this->_getDefaultTitle()));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Update to "old version"
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang_id={$lang->get($lang->getPk()->getName())} AND page_id={$page->get($page->getPk()->getName())}";
OrmDb::execute($query);



$smarty->assign('title', $vals['title']);

$messages[] = 'delete_success';
$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $titleParam));
$smarty->assign('messages',$messages);
$smarty->assign('url',$url);
echo $this->ProcessTemplate('message.tpl');

?>