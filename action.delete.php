<?php

//Default values
$titleParam = null;
$langParam = null;
$smarty = cmsms()->GetSmarty();

/*******************************************/

//Common initialization
include_once('inc.initialization.php');

//Update to "old version"
$query = "UPDATE {$version->getDbname()} SET status={$version::$STATUS_OLD} WHERE status={$version::$STATUS_CURRENT} AND lang_id={$lang->get($lang->getPk()->getName())} AND page_id={$page->get($page->getPk()->getName())}";
OrmDb::execute($query);

$this->RedirectForFrontEnd($id, $returnid, 'default', $params);

?>