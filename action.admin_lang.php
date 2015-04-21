<?php
if (!function_exists('cmsms')) exit;

if(!$this->_VisibleToUser()) exit;

if(empty($params['act'])) {
	throw new Exception("act parameter not found", 1);
}
$action = $params['act'];


if($action != 'edit' && empty($params['lang_id'])) {
	throw new Exception("lang_id parameter not found", 1);
}


if($action != 'edit'){
	$lang_id = $params['lang_id'];
}

if($action == 'delete') {
	//delete all page with this lang_id
	$example = new OrmExample();
	$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($lang_id));
	OrmCore::deleteByExample(new Version(), $example);

	//delete the lang itself
	$example = new OrmExample();
	$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang_id));
	$example->addCriteria('isdefault', OrmTypeCriteria::$NEQ, array(1));
	OrmCore::deleteByExample(new Lang(), $example);

	$this->RedirectToAdminTab('tab2');
} else if($action == 'default') {
	$lang = new Lang();
	$query1 = "UPDATE {$lang->getDbname()} SET isdefault=0 WHERE 1";
	$query2 = "UPDATE {$lang->getDbname()} SET isdefault=1 WHERE lang_id={$lang_id}";
	OrmDb::execute($query1);
	OrmDb::execute($query2);

	//Update also the cmsms preferences
	$langs = OrmCore::findByIds(new Lang(), array($lang_id));
	$defaultLang = $langs[0];
	$this->SetPreference('default_lang',$defaultLang->get('code'));

	$this->RedirectToAdminTab('tab2');
} else if($action == 'edit') {

	$lang_id = null;
	if(!empty($params['lang_id'])){
		$lang_id = $params['lang_id'];
	}

	$lang = null;
	if($lang_id != null){
		$lang = LangsService::getOneById($lang_id);
	}

	if($lang == null){
		$lang_id = null;
		$lang = new Lang();
	}

	if(!empty($params['code'])){
		$lang->set('code', $params['code']);
	}
	if(!empty($params['label'])){
		$lang->set('label', $params['label']);
	}

	$smarty->assign('lang', $lang);

	if($lang_id == null){
		$smarty->assign('title', 'Creation');
	} else {	
		$smarty->assign('title', 'Edition');
	}

	if(!empty($params['werrors'])){
		$errs = unserialize($params['werrors']);
		$fullErrors = array();
		foreach ($errs as $err) {
			$fullErrors[] = $this->Lang($err);
		}
		$smarty->assign('errors', $fullErrors);
	}

	echo $this->ProcessTemplate('admin_lang.tpl');
}


?>