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

$version = VersionsService::getOne($page->get('page_id'), $lang->get('lang_id'), 
							 null, Version::$STATUS_CURRENT);

 
if($version == null){ //Go back to home
	$errors[] = 'version_unknow';
	$url = RouteMaker::getViewRoute($id, $returnid, $langParam, $this->_getDefaultAlias());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

if($isDefaultVersion){ //Don't allow that.
	$errors[] = 'default_version_undeletable';
	$url = RouteMaker::getViewRoute($id, $returnid, $langParam, $this->_getDefaultAlias());
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
$url = RouteMaker::getViewRoute($id, $returnid, $langParam, $aliasParam);
$smarty->assign('messages',$messages);
$smarty->assign('url',$url);
echo $this->ProcessTemplate('message.tpl');

?>