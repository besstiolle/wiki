<?php

//Get active Versions of each langs
$version_by_langs = VersionsService::getAll($version->get('page')->get('page_id'), null, 
							null, Version::$STATUS_CURRENT);
$other_langs = array();

//initiate all langs
foreach($all_langs_by_code as $a_lang_code => $a_lang){

	//Translation MUST pass throught the Edit Action
	$prettyUrl = RouteMaker::getEditRoute($id, $returnid, $a_lang['code'], $version->get('page')->get('title'));

	$other_langs[$a_lang_code] = array('label' => $a_lang['label'], 
				'viewUrl' => $prettyUrl, 
				'class' => 'new');
}

foreach($version_by_langs as $version_by_lang){
	if(isset($all_langs_by_id[$version_by_lang->get("lang")->get('lang_id')])){
	
		$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $all_langs_by_id[$version_by_lang->get("lang")->get("lang_id")]['code'], $version_by_lang->get('page')->get('title'));
		
		$other_langs[$all_langs_by_id[$version_by_lang->get("lang")->get('lang_id')]['code']]['viewUrl'] = $prettyUrl;
		$other_langs[$all_langs_by_id[$version_by_lang->get("lang")->get('lang_id')]['code']]['class'] = '';
	} 
}
$smarty->assign('other_langs', $other_langs);

?>