<?php

$vals['text'] = Engines::process($vals['text'], $prefix, $prefix_lang, $version->get('engine'));


$edit = $this->CreateLink ($id, "edit", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getEditRoute($prefix_lang, $titleParam));
$delete = $this->CreateLink ($id, "delete", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getDeleteRoute($prefix_lang, $titleParam));
$raw = $this->CreateLink ($id, "raw", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam, 'version_id'=>$vals['version_id']), '', true, false, '', '', RouteMaker::getRawRoute($prefix_lang, $titleParam, $vals['version_id']));
$canonical = $this->CreateLink ($id, "view", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getViewRoute($prefix_lang, $titleParam));
$goLast = '';
if($vals['status'] != 1){
	$goLast = $canonical;
}


// If the default-lang-page is newer
$isUpToDate = true;
$defaultLangCanonical = '';
if(count($versions) != 0 && !$isDefaultLang){
	$example = new OrmExample();
	$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
	$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($all_langs_by_code[$this->_getDefaultLang()]['lang_id'] ));
	$example->addCriteria('version_id', OrmTypeCriteria::$GTE, array($version->get('version_id')));
	$defaultLangVersions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,10));
	$isUpToDate = (count($defaultLangVersions) === 0);
	$defaultLangCanonical = $this->CreateLink ($id, "view", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$this->_getDefaultLang()), '', true, false, '', '', RouteMaker::getViewRoute($this->_getDefaultLang(), $titleParam));
}

$smarty->assign('isDefaultLang', $isDefaultLang);
$smarty->assign('isUpToDate', $isUpToDate);


$smarty->assign('version', $vals);
$smarty->assign('title', $titleParam);

$smarty->assign('edit', $edit);
$smarty->assign('delete', $delete);
$smarty->assign('raw', $raw);
$smarty->assign('canonical', $canonical);
$smarty->assign('defaultLangCanonical', $defaultLangCanonical);
$smarty->assign('goLast', $goLast);

echo $this->ProcessTemplate('viewPage.tpl');

?>