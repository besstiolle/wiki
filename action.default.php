<?php

//Default values
$titleParam = 'home';
$langParam = 'en_US';
$smarty = cmsms()->GetSmarty();

/*******************************************/

//Common initialization
include_once('inc.initialization.php');

if($page == null || $version == null){
	//Creation
	include_once('inc.createPage.php');
} else {
	//Display
	include_once('inc.viewPage.php');
}

?>