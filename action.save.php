<?php
if (!function_exists('cmsms')) exit;

$smarty->assign('gatewayParams', $params);
$this->ProcessTemplateFromDatabase('access');
define('_JS_ACTION_',TRUE);

if(!Authentification::is_writable()){
	$errors = array("wiki_not_writable");
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

$vtext = '';
if(!empty($params['vtext'])){
	$vtext = $this->js_urldecode($params['vtext']);
} else {
	$errors[] = 'text_mandatory';
}

$vtitle = '';
if(!empty($params['vtitle'])){
	$vtitle = $this->js_urldecode($params['vtitle']);
} else {
	$errors[] = 'title_mandatory';
}

if(!empty($errors)) {
	$additionnalParameters = array();
	if($vtitle != null){
		$additionnalParameters['vtitle'] = urlencode($vtitle);
	}
	if($vtext != null){
		$additionnalParameters['vtext'] = urlencode($vtext);
	}
	$url = RouteMaker::getEditRoute($this->_getDefaultLang(), $this->_getDefaultAlias(), $additionnalParameters);

	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Update all the old versions in "last version"
$version = new Version();
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang={$lang->get('lang_id')} AND page={$page->get("page_id")}";
OrmDb::execute($query);

//Always create new Version
$version = new Version();

list($currentUS, $currentTS) = explode(" ", microtime());
$version->set('dt_creation',$currentTS);
$version->set('author_name',Authentification::get_author_name());
$version->set('author_id',Authentification::get_author_id());
$version->set('page',$page->get('page_id'));
$version->set('lang',$lang->get('lang_id'));
$version->set('status',$version::$STATUS_CURRENT);
$version->set('title',$vtitle);
$version->set('text',$vtext);
$version = $version->save();

//$url = RouteMaker::getViewRoute($lang->get('code'), $aliasParam);
$url = RouteMaker::getViewRoute($lang->get('code'), $page->get('alias'));
$url = str_replace('&amp;', '&', $url);
header("Location: {$url}");
return;



?>