<?php

//Default values
$titleParam = null;
$langParam = null;
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
	//Edition
	include_once('inc.editPage.php');
}

/*
//Get the text
$prefix = $this->GetPreference('prefix');
$prefix_lang = ($this->GetPreference('show_prefix_lang', true)?"/{$lang->get('prefix')}":"");

		
$vals['text'] = Motors::process($vals['text'], $prefix, $prefix_lang, $version->get('motor'));

$cancel = $this->CreateLink ($id, "default", $returnid, '', array('version_id'=>$version->get($version->getPk()->getName())), 'Sure ?', true, false, '', '', '');
$delete = $this->CreateLink ($id, "delete", $returnid, '', array('version_id'=>$version->get($version->getPk()->getName())), 'Sure ?', true, false, '', '', '/delete');



$smarty = cmsms()->GetSmarty();
$smarty->assign('page', $page->getValues());
$smarty->assign('lang', $lang->getValues());
$smarty->assign('edit', $edit);
$smarty->assign('delete', $delete);
$smarty->assign('version', $vals);
echo $this->ProcessTemplate('default.tpl');*/

?>