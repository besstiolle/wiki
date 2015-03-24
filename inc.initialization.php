<?php 

//Default values
/*if(!isset($aliasParam)){$aliasParam = null;}
if(!isset($langParam)){$langParam = null;}
if(!isset($version_id)){$version_id = null;}*/


//Array for errors and messages
$errors = array();
$messages[] = array();
$has_error = false;

//Smarty vars.
$smarty = cmsms()->GetSmarty();
$smarty->assign('mod', $this);

//Get commons parameters
//if(!empty($params['palias'])){
	$aliasParam = $params['palias'];
	if(_JS_ACTION_){
		$aliasParam = $this->js_urldecode($aliasParam);
	}
	$aliasParam = $this->clean_title($aliasParam);
//}
if(!empty($params['vlang'])){
	$langParam = $params['vlang'];
} else {
//	$langParam = $this->_getDefaultLang();
	die("DIEEEE");
}

$langs = OrmCore::findAll(new Lang());
$all_langs_by_code = array();
$all_langs_by_id = array();
foreach($langs as $lang){
	$all_langs_by_code[$lang->get("code")] = $lang->getValues();
	$all_langs_by_id[$lang->get("lang_id")] = $lang->getValues();
}

//Get lang db entity, panic only if there is no lang.

/************* LANG ****************/
$lang = LangsService::findOne($langParam);

if($lang == null){
	$errors[] = 'lang_mandatory';
	$url = RouteMaker::getViewRoute($id, $returnid, $this->_getDefaultLang(), $this->_getDefaultAlias());
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	$has_error = TRUE;
	return;
}
$smarty->assign('lang', $lang->getValues());

/************** PAGE *****************/
$page = PagesService::getOneByAlias($aliasParam);
if($page == null){
	$page = new Page();
	$page->set('prefix', $this->_getDefaultPrefix());
	$page->set('alias', $aliasParam);
	$page = $page->save();
}

//Is this the default Lang ? Page & Version
$isDefaultLang = $lang->get('isdefault');
$isDefaultPage = ($this->_getDefaultAlias() == $aliasParam);
$isDefaultVersion = $isDefaultLang && $isDefaultPage;

$smarty->assign('isDefaultLang', $isDefaultLang);
$smarty->assign('isDefaultPage', $isDefaultPage);
$smarty->assign('isDefaultVersion', $isDefaultVersion);
 

// Get preferences
$prefix = $this->_getDefaultPrefix();
$code_iso = ($this->GetPreference('show_code_iso', true)?$lang->get('code'):"");
$engine = $this->_getDefaultEngine();


?>