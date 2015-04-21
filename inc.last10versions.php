<?php
if (!function_exists('cmsms')) exit;


//Get 10 Lasts Versions
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
$oldversions = VersionsService::getAll($page->get('page_id'), $lang->get('lang_id'), 
							null, null, new OrmLimit(0,10));
=======
$oldversions = VersionsService::getAll($page->get('page_id'), $lang->get('lang_id'), null, new OrmLimit(0,10));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$oldRevisions = array();
foreach($oldversions as $oldversion){
	$revisionval = $oldversion->getValues();

	if($oldversion->get('status') == Version::$STATUS_CURRENT){
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $code_iso, $page->get('alias'));
	} else {
		$prettyUrl = RouteMaker::getViewOldRoute($id, $returnid, $code_iso, $oldversion->get('page')->get('alias'), $revisionval['version_id']);
=======
		$prettyUrl = RouteMaker::getViewRoute($code_iso, $page->get('alias'));
	} else {
		$prettyUrl = RouteMaker::getViewOldRoute($code_iso, $oldversion->get('page')->get('alias'), $revisionval['version_id']);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
	}
	$revisionval['viewUrl'] = $prettyUrl;
	$oldRevisions[] = $revisionval;
}
$smarty->assign('oldRevisions', $oldRevisions);

?>