<?php
$glue = ':';
$elts = explode($glue,$titleParam);
$previous = '';
$breadcrumbs = array();
foreach($elts as $elt){
	$b_url = RouteMaker::getViewRoute($id, $returnid, $langParam, $previous.$elt);
	$b_name = $elt;
	
	
	$b_class = '';
	$b_title  = '';

	//Test existance of Internal link
	$example = new OrmExample();
	$example->addCriteria('title', OrmTypeCriteria::$EQ, array($previous.$elt));
	$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
	$versions = OrmCore::findByExample(new Version(),$example);
	if(count($versions) == 0){
		$b_class = 'new'; 
		$b_title = "Clic to create the page {$previous}{$elt}";
	} 
	
	
	$breadcrumbs[] = array('name'=>$b_name,
						'url'=>$b_url,
						'class'=>$b_class,
						'title'=>$b_title);
	
	$previous .= $elt.$glue;
}
$smarty->assign('breadcrumbs', $breadcrumbs);




?>