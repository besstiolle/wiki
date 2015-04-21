<?php
if (!function_exists('cmsms')) exit;


//Get active Versions of each langs
$childrensPages = PagesService::getByAliasLike($prefix, $page->get('alias').':%');
$childrens = array();
$sub_entries = array();

foreach ($childrensPages as $childrensPage) {

	$subTitle = substr($childrensPage->get('alias'), strlen($page->get('alias') ) + 1);

	if(substr_count($subTitle, ':')){
		continue;
	}

	$version_child = VersionsService::getOne($childrensPage->get('page_id'), $lang->get('lang_id'), Version::$STATUS_CURRENT);

	if($version_child != null){
		$pos = strpos ( $version_child->get('title'), ':' , strlen($page->get('alias').':%'));
		
		$prettyUrl = RouteMaker::getViewRoute($langParam, $version_child->get('page')->get('alias'));

		$class = '';
		if($pos === TRUE){
			$class = 'new';
		}

		$label = $version_child->get('title');

		$sub_entries[$label] = array(
					'label' => $label,
					'viewUrl' => $prettyUrl,
					'class' => $class
					);
	}
}

$smarty->assign('sub_entries', $sub_entries);

?>