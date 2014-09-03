<?php

$vals['text'] = Engines::process($vals['text'], $prefix, $prefix_lang, $version->get('engine'));


$edit = RouteMaker::getEditRoute($id, $returnid, $prefix_lang, $titleParam);
$delete = RouteMaker::getDeleteRoute($prefix_lang, $titleParam);
$raw = RouteMaker::getRawRoute($id, $returnid, $prefix_lang, $titleParam, $vals['version_id']);
$canonical = RouteMaker::getViewRoute($id, $returnid, $prefix_lang, $titleParam);
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
	$defaultLangCanonical = RouteMaker::getViewRoute($id, $returnid, $this->_getDefaultLang(), $titleParam);
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