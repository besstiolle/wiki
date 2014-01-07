<?php 

//Default values
$titleParam = null;
$langParam = null;
$version_id = null;

//Array for errors and messages
$errors = array();
$messages[] = array();

//Smarty vars.
$smarty = cmsms()->GetSmarty();
$smarty->assign('mod', $this);

?>