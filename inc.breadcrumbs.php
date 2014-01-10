<?php
$glue = ':';
$elts = explode($glue,$titleParam);
$previous = '';
$breadcrumbs = array();
foreach($elts as $elt){
	$b_url = RouteMaker::getViewRoute($langParam, $previous.$elt);
	$b_name = $elt;
	$previous .= $elt.$glue;
	$current = ($titleParam == $previous.$elt);
	
	$b_class = '';
	if($current){
		$b_class = 'current';die();
	}
	
	$breadcrumbs[] = array('name'=>$b_name,
						'url'=>$b_url,
						'class'=>$b_class);
}
$smarty->assign('breadcrumbs', $breadcrumbs);




?>