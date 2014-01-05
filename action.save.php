<?php

//Default values
$titleParam = null;
$textParam = null;
$langParam = null;
$pageParam = null;
$smarty = cmsms()->GetSmarty();

/*******************************************/


if(!empty($params['page_id'])){
	$pageParam = $params['page_id'];
}
if(!empty($params['lang_id'])){
	$langParam = $params['lang_id'];
}
if(!empty($params['wtitle'])){
	$titleParam = $params['wtitle'];
}
if(!empty($params['wtext'])){
	$textParam = $params['wtext'];
}
if($langParam == null){
die("redirect langParam == null");
	$this->RedirectForFrontEnd($id, $returnid, 'default');
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
	$this->RedirectForFrontEnd($id, $returnid, 'edit', $params);
}

//get Page
$page = null;
if($pageParam != null){
	$page = OrmCore::findById(new Page(),$pageParam);
} else {
	$page = new Page();
	$page->set('prefix', '');
	$page->set('title', $titleParam);
	$page = $page->save();
	
}
//Always create new Version
$version = new Version();

list($currentUS, $currentTS) = explode(" ", microtime());
$version->set('motor',Motors::$MARKDOWN);
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page_id',$page->get($page->getPk()->getName()));
$version->set('lang_id',$lang->get($lang->getPk()->getName()));
$version->set('title',$titleParam);
$version->set('text',$textParam);

$version = $version->save();


$this->RedirectForFrontEnd($id, $returnid, 'default', $params);


?>