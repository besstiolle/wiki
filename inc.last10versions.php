<?php

//Get 10 Lasts Versions
$example = new OrmExample();
$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
$oldversions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,10));
$oldvals = array();
foreach($oldversions as $oldversion){
	$oldval = $oldversion->getValues();
	if($oldversion->get('status') == Version::$STATUS_CURRENT){
		$oldval['viewUrl'] = RouteMaker::getViewRoute($prefix_lang, $titleParam);
	} else {
		$oldval['viewUrl'] = RouteMaker::getViewOldRoute($prefix_lang, $titleParam, $oldval['version_id']);
	}
	$oldvals[] = $oldval;
}
$smarty->assign('oldvals', $oldvals);

?>