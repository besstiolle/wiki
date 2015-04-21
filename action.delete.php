<?php
if (!function_exists('cmsms')) exit;

$smarty->assign('gatewayParams', $params);
$this->ProcessTemplateFromDatabase('access');
define('_JS_ACTION_',FALSE);

if(!Authentification::is_deletable()){
	$errors = array("wiki_not_deletable");
	$smarty->assign('errors', $errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
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

$version = VersionsService::getOne($page->get('page_id'), $lang->get('lang_id'), Version::$STATUS_CURRENT);

 
if($version == null){ //Go back to home
	$errors[] = 'version_unknow';
	$url = RouteMaker::getViewRoute($langParam, $this->_getDefaultAlias());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

if($isDefaultVersion){ //Don't allow that.
	$errors[] = 'default_version_undeletable';
	$url = RouteMaker::getViewRoute($langParam, $this->_getDefaultAlias());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Update to "old version"
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang={$lang->get('lang_id')} AND page={$version->get('page')->get('page_id')}";
OrmDb::execute($query);


$smarty->assign('title', $version->get('title'));

$messages[] = 'delete_success';
$url = RouteMaker::getViewRoute($langParam, $aliasParam);
$smarty->assign('messages',$messages);
$smarty->assign('url',$url);
echo $this->ProcessTemplate('message.tpl');

?>