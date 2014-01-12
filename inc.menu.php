<?php


//Get All active Versions
$example = new OrmExample();
$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
$allPages = OrmCore::findByExample(new Version(),$example);
$menu = array();
foreach($allPages as $a_page){
	$elts = explode(':', $a_page->get('title'));
	
	$prettyUrl = RouteMaker::getViewRoute($langParam, $elts[0]);
	
	//Initiate a no-existing page
	if(!isset($menu[$elts[0]])){
	
		$menu[$elts[0]] = array(
				'label' => $elts[0],
				'viewUrl' => $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', $prettyUrl),
				'class' => 'new'
				);
	}
	
	if(isset($menu[$a_page->get('title')])){
		$menu[$a_page->get('title')]['class'] = '';
	}
}

$smarty->assign('wiki_menu', $menu);

?>