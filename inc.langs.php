<?php
if (!function_exists('cmsms')) exit;

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
//Get active Versions of each langs
$version_by_langs = VersionsService::getAll($page->get('page_id'), null, 
							null, Version::$STATUS_CURRENT);
=======

//Get active Versions of each langs
$version_by_langs = VersionsService::getAll($page->get('page_id'), null, Version::$STATUS_CURRENT);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$other_langs = array();

//initiate all langs
foreach($all_langs_by_code as $a_lang_code => $a_lang){

	//Translation MUST pass throught the Edit Action
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	$prettyUrl = RouteMaker::getEditRoute($id, $returnid, $a_lang['code'], $version->get('page')->get('alias'));
=======
	$prettyUrl = RouteMaker::getEditRoute($a_lang['code'], $version->get('page')->get('alias'));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

	$other_langs[$a_lang_code] = array('label' => $a_lang['label'], 
				'viewUrl' => $prettyUrl, 
				'class' => 'new');
}

foreach($version_by_langs as $version_by_lang){
	if(isset($all_langs_by_id[$version_by_lang->get("lang")->get('lang_id')])){
	
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $all_langs_by_id[$version_by_lang->get("lang")->get("lang_id")]['code'], $version_by_lang->get('page')->get('alias'));
=======
		$prettyUrl = RouteMaker::getViewRoute($all_langs_by_id[$version_by_lang->get("lang")->get("lang_id")]['code'], $version_by_lang->get('page')->get('alias'));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		
		$other_langs[$all_langs_by_id[$version_by_lang->get("lang")->get('lang_id')]['code']]['viewUrl'] = $prettyUrl;
		$other_langs[$all_langs_by_id[$version_by_lang->get("lang")->get('lang_id')]['code']]['class'] = '';
	} 
}
$smarty->assign('other_langs', $other_langs);

?>