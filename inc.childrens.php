<?php
if (!function_exists('cmsms')) exit;

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
//Get active Versions of each langs
$childrensPages = PagesService::getByAliasLike($page->get('alias').':%');
=======

//Get active Versions of each langs
$childrensPages = PagesService::getByAliasLike($prefix, $page->get('alias').':%');
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$childrens = array();
$sub_entries = array();

foreach ($childrensPages as $childrensPage) {
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc

	$subTitle = substr($childrensPage->get('alias'), strlen($page->get('alias') ) + 1);

=======

	$subTitle = substr($childrensPage->get('alias'), strlen($page->get('alias') ) + 1);

>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
	if(substr_count($subTitle, ':')){
		continue;
	}

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	$version_child = VersionsService::getOne($childrensPage->get('page_id'), $lang->get('lang_id'), 
							null, Version::$STATUS_CURRENT);
=======
	$version_child = VersionsService::getOne($childrensPage->get('page_id'), $lang->get('lang_id'), Version::$STATUS_CURRENT);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

	if($version_child != null){
		$pos = strpos ( $version_child->get('title'), ':' , strlen($page->get('alias').':%'));
		
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $langParam, $version_child->get('page')->get('alias'));
=======
		$prettyUrl = RouteMaker::getViewRoute($langParam, $version_child->get('page')->get('alias'));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

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