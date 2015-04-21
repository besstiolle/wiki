<?php
if (!function_exists('cmsms')) exit;

$smarty->assign('gatewayParams', $params);
$this->ProcessTemplateFromDatabase('access');
define('_JS_ACTION_',TRUE);

if(!Authentification::is_readable()){
	$errors = array("wiki_not_readable");
	$smarty->assign('errors', $errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Default values
$version_id = null;
$smarty = cmsms()->GetSmarty();

if(!empty($params['version_id'])){
	$version_id = $params['version_id'];
}

if($version_id == null){
	echo "The version_id parameter is mandatory.";
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

$version = VersionsService::getOneByVersionId(
		$page->get('page_id'), 
		$lang->get('lang_id'),
		$version_id);

if($version == null){
	$errors = array("wiki_page_not_exists");
	$smarty->assign('errors', $errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

$smarty->assign('version',$version->getValues());

echo $this->ProcessTemplate('rawCode.tpl');

?>