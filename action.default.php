<?php

//Default wiki's page = home
$wiki = 'home';
if(!empty($params['wiki'])){
	$wiki = $params['wiki'];
}
//Default wiki's lang = en_US
$lang = 'en_US';
if(!empty($params['lang'])){
	$lang = $params['lang'];
}

//Get Page
$example = new OrmExample();
$example->addCriteria('title', OrmTypeCriteria::$EQ, array($wiki));
$pages = OrmCore::findByExample(new Page(),$example);
$page = $pages[0];

//Get Lang
$example = new OrmExample();
$example->addCriteria('label', OrmTypeCriteria::$EQ, array($lang));
$langs = OrmCore::findByExample(new Lang(),$example);
$lang = $langs[0];

//Get Version
$example = new OrmExample();
$example->addCriteria('page_id', OrmTypeCriteria::$EQ, array($page->get($page->getPk()->getName())));
$example->addCriteria('lang_id', OrmTypeCriteria::$EQ, array($lang->get($lang->getPk()->getName())));
$order = new OrmOrderBy(array('version_id'=>OrmOrderBy::$DESC));
//$limit = new OrmLimit(0,1);
$versions = OrmCore::findByExample(new Version(),$example, $order, $limit);
$version = $versions[0];

$smarty = cmsms()->GetSmarty();
$smarty->assign('page', $page->getValues());
$smarty->assign('lang', $lang->getValues());
$smarty->assign('version', $version->getValues());
echo $this->ProcessTemplate('default.tpl');

?>