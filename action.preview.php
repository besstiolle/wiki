<?php

//Default values
$titleParam = null;
$textParam = null;
$langParam = null;
//$pageParam = null;
$smarty = cmsms()->GetSmarty();

$motorsParams = Motors::$MARKDOWN;

if(!empty($params['wtext'])){
	$textParam = urldecode($params['wtext']);
}
if(!empty($params['wtitle'])){
	$titleParam = urldecode($params['wtitle']);
}
if(!empty($params['lang_id'])){
	$langParam = $params['lang_id'];
}
if($langParam == null){
die("redirect langParam == null");
//TODO
}



//Get Lang
$lang = OrmCore::findById(new Lang(),$langParam);
$errors = array();

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
	}die("redirect lang == null");
	//TODO
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