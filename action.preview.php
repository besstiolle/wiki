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


if(!empty($params['vtext'])){
	$textParam = $params['vtext'];//$this->js_urldecode($params['vtext']);
} else {
	$errors[] = 'text_mandatory';
}
if(empty($params['vtitle'])){
	$errors[] = 'title_mandatory';
}

if(!empty($errors)) {
	$smarty->assign('errors',$errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

$vals['title'] = $params['vtitle'];
$vals['text'] = WikiUtils::parseText($textParam, $prefix, $langParam);

$smarty->assign('version', $vals);
$smarty->assign('title', $params['vtitle']);
$smarty->assign('action', 'Preview');

echo $this->ProcessTemplate('previewPage.tpl');


?>