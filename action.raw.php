<?php
if (!function_exists('cmsms')) exit;

//Default values
$version_id = null;
$smarty = cmsms()->GetSmarty();

if(!empty($params['version_id'])){
	$version_id = $params['version_id'];
}

if($version_id == null){
	echo "The version_id parameter is mandatory.";
	return;
}

$version = OrmCore::findById(new Version(),$version_id);
$smarty->assign('version',$version->getValues());

echo $this->ProcessTemplate('rawCode.tpl');

?>