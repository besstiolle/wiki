<?php

$prefix = $this->GetPreference('prefix');
$prefix_lang = ($this->GetPreference('show_prefix_lang', true)?"/{$lang->get('prefix')}":"");

$vals['raw'] = $vals['text'];	
//$vals['text'] = htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.txt'));	
$vals['text'] = Motors::process($vals['text'], $prefix, $prefix_lang, $version->get('motor'));



$edit = $this->CreateLink ($id, "edit", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getEditRoute($prefix_lang, $titleParam));
$delete = $this->CreateLink ($id, "delete", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), 'Sure ?', true, false, '', '', RouteMaker::getDeleteRoute($prefix_lang, $titleParam));
$raw = $this->CreateLink ($id, "raw", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam, 'version_id'=>$vals['version_id']), '', true, false, '', '', RouteMaker::getRawRoute($prefix_lang, $titleParam, $vals['version_id']));



//Get 10 Previous Versions
$example = new OrmExample();
$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
$example->addCriteria('status', OrmTypeCriteria::$NEQ, array(Version::$STATUS_CURRENT));
$oldversions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,10));
$oldvals = array();
foreach($oldversions as $oldversion){
	$oldvals[] = $oldversion->getValues();
}
$smarty->assign('oldvals', $oldvals);


$smarty->assign('version', $vals);
$smarty->assign('title', $vals['title']);
//$smarty->assign('page', $page->getValues());
//$smarty->assign('lang', $lang->getValues());

$smarty->assign('edit', $edit);
$smarty->assign('delete', $delete);
$smarty->assign('raw', $raw);

echo $this->ProcessTemplate('viewPage.tpl');

?>