<?php 

//Default values
if(!isset($titleParam)){$titleParam = null;}
if(!isset($langParam)){$langParam = null;}
if(!isset($version_id)){$version_id = null;}

//Array for errors and messages
$errors = array();
$messages[] = array();

//Smarty vars.
$smarty = cmsms()->GetSmarty();
$smarty->assign('mod', $this);

//Get commons parameters
if(!empty($params['wtitle'])){
	$titleParam = $params['wtitle'];
	if(_JS_ACTION_){
		$titleParam = $this->js_urldecode($titleParam);
	}
	$titleParam = $this->clean_title($titleParam);
}
if(!empty($params['wlang'])){
	$langParam = $params['wlang'];
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
$example = new OrmExample();
$example->addCriteria('code', OrmTypeCriteria::$EQ, array($langParam));
$langs = OrmCore::findByExample(new Lang(),$example);
if(count($langs) == 0){
	$lang = null;
} else {
	$lang = $langs[0];
}

if($lang == null){
	$errors[] = 'lang_mandatory';
	$url = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($this->_getDefaultLang(), $this->_getDefaultTitle()));
	$smarty->assign('errors',$errors);
	$smarty->assign('url',$url);
	echo $this->ProcessTemplate('message.tpl');
	$has_error = TRUE;
	return;
}
$smarty->assign('lang', $lang->getValues());

// Get preferences
$prefix = $this->GetPreference('prefix');
$prefix_lang = ($this->GetPreference('show_prefix_lang', true)?"/{$lang->get('code')}":"");
$engine = $this->_getDefaultEngine();

?>