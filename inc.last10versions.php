<?php

//Get 10 Lasts Versions
$example = new OrmExample();
$example->addCriteria('page_id', OrmTypeCriteria::$EQ, array($version->get('page_id')));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
$oldversions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,10));
$oldRevisions = array();
foreach($oldversions as $oldversion){
	$revisionval = $oldversion->getValues();
	if($revisionval['status'] == Version::$STATUS_CURRENT){
		$revisionval['viewUrl'] = RouteMaker::getViewRoute($prefix_lang, $titleParam);
	} else {
		$revisionval['viewUrl'] = RouteMaker::getViewOldRoute($prefix_lang, $revisionval['title'], $revisionval['version_id']);
	}echo "#{$revisionval['status']}#";
	$oldRevisions[] = $revisionval;
}
$smarty->assign('oldRevisions', $oldRevisions);

?>