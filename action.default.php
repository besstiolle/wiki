<?php

//Default values
$titleParam = 'home';
$langParam = 'en_US';
$version_id = null;
$smarty = cmsms()->GetSmarty();

/*******************************************/

// Case wiki/en_US/home/view/2
if(!empty($params['version_id'])){
	$version_id = $params['version_id'];
}
//Common initialization
include_once('inc.initialization.php');

// Case wiki/en_US/home/view/999999
if($version_id != null && $version == null){
	echo "The revision {$version_id} is not an known revision.";
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