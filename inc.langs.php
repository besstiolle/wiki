<?php

//Get active Versions of each langs
$example = new OrmExample();
$example->addCriteria('page_id', OrmTypeCriteria::$EQ, array($version->get('page_id')));
$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
$version_by_langs = OrmCore::findByExample(new Version(),$example);

$other_langs = array();

//initiate all langs
foreach($all_langs_by_code as $a_lang_code => $a_lang){
	$other_langs[$a_lang_code] = array('label' => $a_lang['label'], 'viewUrl' => RouteMaker::getEditRoute($a_lang['code'], $titleParam), 'class' => 'new');
}

foreach($version_by_langs as $version_by_lang){
	if(isset($all_langs_by_id[$version_by_lang->get("lang_id")])){
		$other_langs[$all_langs_by_id[$version_by_lang->get("lang_id")]['code']]['viewUrl'] = RouteMaker::getViewRoute($all_langs_by_id[$version_by_lang->get("lang_id")]['code'], $version_by_lang->get('title'));
		$other_langs[$all_langs_by_id[$version_by_lang->get("lang_id")]['code']]['class'] = '';
	} 
}
$smarty->assign('other_langs', $other_langs);

?>