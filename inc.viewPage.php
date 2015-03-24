<?php

$vals['text'] = Engines::process($id, $returnid, $vals['text'], $prefix, $prefix_lang, $version->get('engine'));

$edit = RouteMaker::getEditRoute($id, $returnid, $prefix_lang, $titleParam);
$delete = RouteMaker::getDeleteRoute($id, $returnid, $prefix_lang, $titleParam);
$raw = RouteMaker::getRawRoute($id, $returnid, $prefix_lang, $titleParam, $vals['version_id']);
$canonical = RouteMaker::getViewRoute($id, $returnid, $prefix_lang, $titleParam);
$goLast = '';
if($vals['status'] != 1){
	$goLast = $canonical;
}


// If the default-lang-page is newer
$isUpToDate = true;
$defaultLangCanonical = '';
if($version != null && !$isDefaultLang){
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
$smarty->assign('title', $version->get('title'));

$smarty->assign('edit', $edit);
$smarty->assign('delete', $delete);
$smarty->assign('raw', $raw);
$smarty->assign('canonical', $canonical);
$smarty->assign('defaultLangCanonical', $defaultLangCanonical);
$smarty->assign('goLast', $goLast);

$js = $this->ProcessTemplate('viewPage.js.tpl');
$smarty->assign('wiki_js', $js);

echo $this->ProcessTemplate('viewPage.tpl');

?>