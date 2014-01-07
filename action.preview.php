<?php


//Common initialization
include_once('inc.initialization.php');

/*******************************************/

$motorsParams = Motors::$MARKDOWN;

if(!empty($params['wtext'])){
	$textParam = $this->js_urldecode($params['wtext']);
}
if(!empty($params['wtitle'])){
	$titleParam = $this->clean_title($this->js_urldecode($params['wtitle']));
}
if(!empty($params['lang_id'])){
	$langParam = $params['lang_id'];
}
if($langParam == null){
	echo $this->Lang("lang_id_mandatory");
}

//$textParam =htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.txt'));

//Get Lang
$lang = OrmCore::findById(new Lang(),$langParam);

if($lang == null){
	$errors[] = 'lang_mandatory';;
}
if($titleParam == null){
	$errors[] = 'title_mandatory';
}
if($textParam == null){
	$errors[] = 'text_mandatory';
}
if(count($errors) !== 0){
	$params['werrors'] = $errors;
	if($lang != null) {
		$params['wlang'] = $lang->get('label');
	}
	echo $this->Lang("lang_mandatory");
	return;
}

$prefix = $this->GetPreference('prefix');
$prefix_lang = ($this->GetPreference('show_prefix_lang', true)?"/{$lang->get('prefix')}":"");

$vals['title'] = $titleParam;
$vals['text'] = Motors::process($textParam, $prefix, $prefix_lang, $motorsParams);



$smarty->assign('version', $vals);
//$smarty->assign('page', $page->getValues());
//$smarty->assign('lang', $lang->getValues());

//$smarty->assign('edit', $edit);
//$smarty->assign('delete', $delete);

echo $this->ProcessTemplate('previewPage.tpl');


?>