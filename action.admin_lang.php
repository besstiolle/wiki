<?php
if (!function_exists('cmsms')) exit;

if(empty($params['act'])) {
	throw new Exception("act parameter not found", 1);
}
if(empty($params['lang_id'])) {
	throw new Exception("lang_id parameter not found", 1);
}
$action = $params['act'];
$lang_id = $params['lang_id'];

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

} else {
	die('paf');	
}
$this->Redirect($id, 'defaultadmin');

?>