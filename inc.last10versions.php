<?php

//Get 10 Lasts Versions
$oldversions = VersionsService::getAll($version->get('page')->get('page_id'), $lang->get('lang_id'), 
							null, null, new OrmLimit(0,10));
$oldRevisions = array();
foreach($oldversions as $oldversion){
	$revisionval = $oldversion->getValues();

	if($oldversion->get('status') == Version::$STATUS_CURRENT){
		$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $prefix_lang, $page->get('title'));
	} else {
		$prettyUrl = RouteMaker::getViewOldRoute($id, $returnid, $prefix_lang, $oldversion->get('page')->get('title'), $revisionval['version_id']);
	}
	$revisionval['viewUrl'] = $prettyUrl;
	$oldRevisions[] = $revisionval;
}
$smarty->assign('oldRevisions', $oldRevisions);

?>