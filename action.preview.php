<?php

define('_JS_ACTION_',TRUE);
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

if(!empty($params['wtext'])){
	$textParam = $this->js_urldecode($params['wtext']);
}
if($titleParam == null){
	$errors[] = 'title_mandatory';
}
if($textParam == null){
	$errors[] = 'text_mandatory';
}

if(!empty($errors)) {
	$smarty->assign('errors',$errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

$vals['title'] = $titleParam;
$vals['text'] = Engines::process($textParam, $prefix, $prefix_lang, $engine);

$smarty->assign('version', $vals);
$smarty->assign('title', $titleParam);
$smarty->assign('action', 'Preview');

echo $this->ProcessTemplate('previewPage.tpl');


?>