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
	$params['werrors'] = 'lang_id_mandatory|';
	$this->RedirectForFrontEnd($id, $returnid, 'default', $params);
}

//Get Lang
$lang = OrmCore::findById(new Lang(),$langParam);
$errors = '';

if($lang == null){
	$errors .= 'lang_mandatory|';
}
if($titleParam == null){
	$errors .= 'title_mandatory|';
}
if($textParam == null){
	$errors .= 'text_mandatory|';
	unset($params['wtext']); //avoid blank text in edition
}
if(!empty($errors)){
	$params['werrors'] = $errors;
	if($lang != null) {
		$params['wlang'] = $lang->get('label');
		$this->RedirectForFrontEnd($id, $returnid, 'edit', $params);
	} else {
		$this->RedirectForFrontEnd($id, $returnid, 'default', $params);
	}
	
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

//Avoir edit title of version "en_US/home"
if($page->get('title') == 'home' && $titleParam != 'home' && $lang->get('label') == 'en_US'){
	if($lang != null) {
		$params['wlang'] = $lang->get('label');
	}
	//Reset title
	$params['wtitle'] = $page->get('title');
	$params['werrors'] = 'default_page_with_new_title|';
	$this->RedirectForFrontEnd($id, $returnid, 'edit', $params);
}


//Always create new Version
$version = new Version();

//Update old version in "last version"
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang_id={$lang->get($lang->getPk()->getName())} AND page_id={$page->get($page->getPk()->getName())}";
OrmDb::execute($query);


list($currentUS, $currentTS) = explode(" ", microtime());
$version->set('motor',Motors::$MARKDOWN);
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page_id',$page->get($page->getPk()->getName()));
$version->set('lang_id',$lang->get($lang->getPk()->getName()));
$version->set('status',$version::$STATUS_CURRENT);
$version->set('title',$titleParam);
$version->set('text',$textParam);

$version = $version->save();


$this->RedirectForFrontEnd($id, $returnid, 'default', $params);


?>