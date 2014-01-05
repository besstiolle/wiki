<?php

//Default values
$titleParam = null;
$langParam = null;
$smarty = cmsms()->GetSmarty();

/*******************************************/

//Common initialization
include_once('inc.initialization.php');

if($page == null || $version == null){
	//Creation
	include_once('inc.createPage.php');
} else {
	//Edition
	include_once('inc.editPage.php');
}

?>