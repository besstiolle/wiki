<?php

if (!function_exists("cmsms")) exit;

if(!$this->_VisibleToUser()) exit;

$errors = array();
if(!empty($params['code'])){
	$code = $params['code'];
	$lang = LangsService::getOne($code);
	if(($lang !== null && empty($params['lang_id'])) 
		|| ($lang !== null && $lang->get('lang_id') !== $params['lang_id'])){
		$errors[] = 'dupplicate_code';
	}
} else {
	$errors[] = 'code_is_mandatory';
}

if(!empty($params['label'])){
	$label = $params['label'];
} else {
	$errors[] = 'label_is_mandatory';
}

if(!empty($params['lang_id'])){
	$lang_id = $params['lang_id'];
}

if(!empty($errors)){
	$params['werrors'] = serialize($errors);
	$params['act'] = 'edit';
	$this->redirect($id,'admin_lang', '', $params);
}

if($lang_id == null){
	$lang = new Lang();
} else {
	$lang = LangsService::getOneById($lang_id);
}

$lang->set('code', $code);
$lang->set('label', $label);
$lang->save();


$this->RedirectToAdminTab('tab2');


?>