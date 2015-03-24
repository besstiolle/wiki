<?php
if (!function_exists('cmsms')) exit;



$smarty->assign('prefix', $this->GetPreference('prefix','wiki'));
$smarty->assign('show_code_iso', $this->GetPreference('show_code_iso',TRUE));
$smarty->assign('form_save',$this->CreateFormStart($id,'admin_save'));


$admintheme = cms_utils::get_theme_object();
$imgs = array(
	'delete' => $admintheme->DisplayImage('icons/system/delete.gif','delete','','','systemicon'),
	'edit' => $admintheme->DisplayImage('icons/system/edit.gif','edit','','','systemicon'),
	'true' => $admintheme->DisplayImage('icons/system/true.gif','Is default','','','systemicon'),
	'false' => $admintheme->DisplayImage('icons/system/false.gif','Set to Default','','','systemicon'),
);
$smarty->assign('imgs', $imgs);

$langs = OrmCore::findAll(new Lang());
$langs_values = OrmUtils::entitiesToAbsoluteArray($langs);
for($i = 0; $i<count($langs_values); $i++) {
	$example = new OrmExample();
	$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($langs_values[$i]['lang_id']));
	$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
	$cpt = OrmCore::selectCountByExample(new Version(), $example);

	$langs_values[$i]['count'] = $cpt;
	$langs_values[$i]['edit'] = $this->create_url($id,'admin_lang', '', 
							array('act'=>'edit', 'lang_id'=> $langs_values[$i]['lang_id']));
	$langs_values[$i]['delete'] = $this->create_url($id,'admin_lang', '', 
							array('act'=>'delete', 'lang_id'=> $langs_values[$i]['lang_id']));
	$langs_values[$i]['default'] = $this->create_url($id,'admin_lang', '', 
							array('act'=>'default', 'lang_id'=> $langs_values[$i]['lang_id']));
}


$smarty->assign('langs', $langs_values);

$smarty->assign('reset', $this->create_url($id,'admin_reset', '', array()));

echo $this->ProcessTemplate('admin.tpl');
?>