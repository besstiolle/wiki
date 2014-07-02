<?php

//Get 10 Lasts Versions
$example = new OrmExample();
$example->addCriteria('page', OrmTypeCriteria::$EQ, array($version->get('page')->get('page_id')));
$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($lang->get('lang_id')));
$oldversions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,10));
$oldRevisions = array();
foreach($oldversions as $oldversion){
	$revisionval = $oldversion->getValues();
	if($revisionval['status'] == Version::$STATUS_CURRENT){
		$prettyUrl = RouteMaker::getViewRoute($prefix_lang, $titleParam);
	} else {
		$prettyUrl = RouteMaker::getViewOldRoute($prefix_lang, $revisionval['title'], $revisionval['version_id']);
	}
	$revisionval['viewUrl'] = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', $prettyUrl);
	$oldRevisions[] = $revisionval;
}
$smarty->assign('oldRevisions', $oldRevisions);

?>