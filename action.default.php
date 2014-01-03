<?php

//Default values
$titleParam = 'home';
$langParam = 'en_US';
$smarty = cmsms()->GetSmarty();

/*******************************************/

if(!empty($params['title'])){
	$titleParam = $params['title'];
}
if(!empty($params['lang'])){
	$langParam = $params['lang'];
}

//Get Lang
$example = new OrmExample();
$example->addCriteria('label', OrmTypeCriteria::$EQ, array($langParam));
$langs = OrmCore::findByExample(new Lang(),$example);
if(count($langs) == 0){
	$lang = null;
} else {
	$lang = $langs[0];
}

if($lang != null){
	//Get Version
	$example = new OrmExample();
	$example->addCriteria('title', OrmTypeCriteria::$EQ, array($titleParam));
	$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
	$limit = new OrmLimit(0,1);
	$versions = OrmCore::findByExample(new Version(),$example, $order, $limit);
	if(count($versions) == 0){
		$version = null;
		$vals = null;
	} else {
		$version = $versions[0];
		$vals = $version->getValues();
	}
	
	if($version != null){
		//Get Page
		$page = OrmCore::findById(new Page(),$version->get('page_id'));
	} else {
		$page = null;
	}

	
} else { //Error cases
	echo "The lang {$langParam} is not an unknown lang.";
	return;
}

if($page == null || $version == null){
	//Creation
	include_once('inc.createPage.php');
} else {
	//Display
	include_once('inc.viewPage.php');
}

?>