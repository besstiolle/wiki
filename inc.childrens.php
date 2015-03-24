<?php

//Get active Versions of each langs
$childrensPages = PagesService::getByTitleLike($page->get('title').':%');
$childrens = array();
$sub_entries = array();

foreach ($childrensPages as $childrensPage) {

	$subTitle = substr($childrensPage->get('title'), strlen($page->get('title') ) + 1);

	if(substr_count($subTitle, ':')){
		continue;
	}

	$child = VersionsService::getOne($childrensPage->get('page_id'), $lang->get('lang_id'), 
							null, Version::$STATUS_CURRENT);

	if($child != null){
		$pos = strpos ( $child->get('title'), ':' , strlen($page->get('title').':%'));
		
		$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $langParam, $child->get('page')->get('title'));

		$class = '';
		if($pos === TRUE){
			$class = 'new';
		}

		$label = $child->get('title');

		$sub_entries[$label] = array(
					'label' => $label,
					'viewUrl' => $prettyUrl,
					'class' => $class
					);
	}
}

$smarty->assign('sub_entries', $sub_entries);

?>