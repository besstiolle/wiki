<?php
if (!function_exists('cmsms')) exit;


$pagesSiblings = PagesService::getSiblings($prefix, $aliasParam);

//Get All active Versions
$allVersions = array();
foreach ($pagesSiblings as $pageSiblings) {
	
	$vSibling = VersionsService::getOne($prefix, $pageSiblings->get('page_id'), $lang->get('lang_id'), Version::$STATUS_CURRENT);

	if($vSibling != null){
		$allVersions[] = $vSibling;
	}
}


$menu = array();
foreach($allVersions as $a_version){

	$_alias = $a_version->get('page')->get('alias');
	$_title = $a_version->get('title');
	
	$prettyUrl = RouteMaker::getViewRoute($langParam, $_alias);
	
	$menu[$_alias] = array(
			'label' => $_title,
			'viewUrl' => $prettyUrl
			);
}

$smarty->assign('wiki_menu_siblings', $menu);

?>