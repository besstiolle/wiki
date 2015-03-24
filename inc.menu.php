<?php


//Get All active Versions
$allVersions = VersionsService::getAll(null, $lang->get('lang_id'), 
							null, Version::$STATUS_CURRENT);
$menu = array();
foreach($allVersions as $a_version){
	$elts = explode(':', $a_version->get('page')->get('title'));
	
	$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $langParam, $elts[0]);
	
	//Initiate a no-existing page
	if(!isset($menu[$elts[0]])){
	
		$menu[$elts[0]] = array(
				'label' => $elts[0],
				'viewUrl' => $prettyUrl,
				'class' => 'new'
				);
	}
	
	if(isset($menu[$a_version->get('page')->get('title')])){
		$menu[$a_version->get('page')->get('title')]['class'] = '';
		$menu[$a_version->get('page')->get('title')]['label'] = $a_version->get('title');
	}
}

$smarty->assign('wiki_menu', $menu);

?>