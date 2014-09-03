<?php

//Get active Versions of each langs
$example = new OrmExample();
$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
$example->addCriteria('lang', OrmTypeCriteria::$EQ, array($lang->get('lang_id')));
$example->addCriteria('title', OrmTypeCriteria::$LIKE, array($version->get('title').':%'));
$childrens = OrmCore::findByExample(new Version(),$example);

$sub_entries = array();

//initiate all langs
foreach($childrens as $child){

	$pos = strpos ( $child->get('title'), ':' , strlen($version->get('title').':%'));
	$label = '';
	if($pos === FALSE){  //Last Child
		$label = substr($child->get('title'), strlen($version->get('title')) + 1);
	} else {
		$label = substr($child->get('title'), strlen($version->get('title')) + 1 , $pos - strlen($child->get('title')));
	}
	
	$prettyUrl = RouteMaker::getViewRoute($id, $returnid, $langParam, $version->get('title').':'.$label);

	$sub_entries[$label] = array(
				'label' => $version->get('title').':'.$label,
				'viewUrl' => $prettyUrl,
				'class' => 'new'
				);
	
	
	if($pos === FALSE){
		$sub_entries[$label]['class'] = '';
	}
}

$smarty->assign('sub_entries', $sub_entries);

?>