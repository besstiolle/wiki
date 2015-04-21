<?php
if (!function_exists('cmsms')) exit;


//Get 10 Lasts Versions
$oldversions = VersionsService::getAll($page->get('page_id'), $lang->get('lang_id'), null, new OrmLimit(0,10));
$oldRevisions = array();
foreach($oldversions as $oldversion){
	$revisionval = $oldversion->getValues();

	if($oldversion->get('status') == Version::$STATUS_CURRENT){
		$prettyUrl = RouteMaker::getViewRoute($code_iso, $page->get('alias'));
	} else {
		$prettyUrl = RouteMaker::getViewOldRoute($code_iso, $oldversion->get('page')->get('alias'), $revisionval['version_id']);
	}
	$revisionval['viewUrl'] = $prettyUrl;
	$oldRevisions[] = $revisionval;
}
$smarty->assign('oldRevisions', $oldRevisions);

?>