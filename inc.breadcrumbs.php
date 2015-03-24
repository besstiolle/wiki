<?php
$glue = ':';
$elts = explode($glue,$aliasParam);
$previous = '';
$breadcrumbs = array();
foreach($elts as $elt){
	$b_url = RouteMaker::getViewRoute($id, $returnid, $langParam, $previous.$elt);
	$b_name = $elt;
	
	
	$b_class = '';
	$b_title  = '';

	//Test existance of Internal link
	$pageOfChild = PagesService::getOneByAlias($previous.$elt);
	if($pageOfChild == null){
		$b_class = 'new'; 
		$b_title = "Clic to create the page {$previous}{$elt}";
	} else {
		$versionOfChildren = VersionsService::getOne($pageOfChild->get('page_id'), null, 
							null, Version::$STATUS_CURRENT);
		if($versionOfChildren == null){
			$b_class = 'new'; 
			$b_title = "Clic to create the page {$previous}{$elt}";
		} 
	}

	
	
	$breadcrumbs[] = array('name'=>$b_name,
						'url'=>$b_url,
						'class'=>$b_class,
						'title'=>$b_title);
	
	$previous .= $elt.$glue;
}
$smarty->assign('breadcrumbs', $breadcrumbs);




?>