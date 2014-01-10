<?php


//Get All active Versions
$example = new OrmExample();
$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));
$allPages = OrmCore::findByExample(new Version(),$example);
$menu = array();
foreach($allpages as $elt){
	
	
}
$smarty->assign('wiki_menu', $menu);

?>