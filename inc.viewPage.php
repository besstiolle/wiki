<?php
if (!function_exists('cmsms')) exit;


$vals['text'] = WikiUtils::parseText($vals['text'], $prefix, $code_iso);


$edit = RouteMaker::getEditRoute($code_iso, $aliasParam);
$delete = RouteMaker::getDeleteRoute($code_iso, $aliasParam);
$raw = RouteMaker::getRawRoute($code_iso, $aliasParam, $vals['version_id']);
$canonical = RouteMaker::getViewRoute($code_iso, $aliasParam);
$goLast = '';
if($vals['status'] != 1){
	$goLast = $canonical;
}


// If the default-lang-page is newer
$isUpToDate = true;
$defaultLangCanonical = '';
if($version != null && !$isDefaultLang){
	/*$example = new OrmExample();
	$example->addCriteria('page', OrmTypeCriteria::$EQ, array($page->get('page_id')));
	$example->addCriteria('lang', OrmTypeCriteria::$NEQ, array($lang->get('lang_id')));
	$example->addCriteria('version_id', OrmTypeCriteria::$GT, array($version->get('version_id')));
	$cptNewerVersion = OrmCore::selectCountByExample(new Version(),$example);
	$isUpToDate = ($cptNewerVersion == 0);*/
	$isUpToDate = (VersionsService::countNewerVersion($page, $lang, $version) == 0);
	$defaultLangCanonical = RouteMaker::getViewRoute($this->_getDefaultLang(), $aliasParam);
}

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