<?php
if (!function_exists('cmsms')) exit;

$glue = ':';
$elts = explode($glue,$aliasParam);
$previous = '';
$breadcrumbs = array();
foreach($elts as $elt){
	$b_url = RouteMaker::getViewRoute($langParam, $previous.$elt);
	$b_name = $elt;
	
	
	$b_class = '';
	$b_title  = '';

	//Test existance of Internal link
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	$pageOfChild = PagesService::getOneByAlias($previous.$elt);
=======
	$pageOfChild = PagesService::getOneByAlias($prefix, $previous.$elt);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
	if($pageOfChild == null){
		$b_class = 'new'; 
		$b_title = "Clic to create the page {$previous}{$elt}";
	} else {
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$versionOfChildren = VersionsService::getOne($pageOfChild->get('page_id'), null, 
							null, Version::$STATUS_CURRENT);
=======
		$versionOfChildren = VersionsService::getOne($pageOfChild->get('page_id'), null, Version::$STATUS_CURRENT);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
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