<?php 

if(!empty($params['wtitle'])){
	$titleParam = $params['wtitle'];
}
if(!empty($params['wlang'])){
	$langParam = $params['wlang'];
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
	$example->addCriteria('status', OrmTypeCriteria::$EQ, array(Version::$STATUS_CURRENT));

	$versions = OrmCore::findByExample(new Version(),$example, null, new OrmLimit(0,1));
	if(count($versions) == 0){
		$version = null;
		$vals = null;
		$page = null;
	} else {
		$version = $versions[0];
		$vals = $version->getValues();
		$page = OrmCore::findById(new Page(),$version->get('page_id'));
	}
		
} else { //Error cases
	echo "The lang {$langParam} is not an unknown lang.";
	return;
}


?>