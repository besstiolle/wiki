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
if(count($versions) == 0){
	$version = null;
	$vals = null;
	$page = null;
} else {
	$version = $versions[0];
	$vals = $version->getValues();
	$page = $version->get('page');
}
	
 
if($version == null){ //Go back to home
	$errors[] = 'version_unknow';
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $this->_getDefaultTitle()));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

if($page->get('title') == $this->_getDefaultTitle() && $lang->get('code') == $this->_getDefaultLang()){ //Don't allow that.
	$errors[] = 'default_version_undeletable';
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $this->_getDefaultTitle()));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Update to "old version"
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang_id={$lang->get('lang_id')} AND page_id={$page->get('page_id')}";
OrmDb::execute($query);



$smarty->assign('title', $vals['title']);

$messages[] = 'delete_success';
$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $titleParam));
$smarty->assign('messages',$messages);
$smarty->assign('url',$url);
echo $this->ProcessTemplate('message.tpl');

?>