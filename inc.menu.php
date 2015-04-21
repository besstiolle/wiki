<?php
if (!function_exists('cmsms')) exit;



//Get All active Versions
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
$allVersions = VersionsService::getAll(null, $lang->get('lang_id'), 
							null, Version::$STATUS_CURRENT);
=======
$allVersions = VersionsService::getAll(null, $lang->get('lang_id'), Version::$STATUS_CURRENT);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$menu = array();
foreach($allVersions as $a_version){
	$elts = explode(':', $a_version->get('page')->get('alias'));
	
	$prettyUrl = RouteMaker::getViewRoute($langParam, $elts[0]);
	
	//Initiate a no-existing page
	if(!isset($menu[$elts[0]])){
	
		$menu[$elts[0]] = array(
				'label' => $elts[0],
				'viewUrl' => $prettyUrl,
				'class' => 'new'
				);
	}
	
	if(isset($menu[$a_version->get('page')->get('alias')])){
		$menu[$a_version->get('page')->get('alias')]['class'] = '';
		$menu[$a_version->get('page')->get('alias')]['label'] = $a_version->get('title');
	}
}

$smarty->assign('wiki_menu', $menu);

?>