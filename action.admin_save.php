<?php

if (!function_exists("cmsms")) exit;

if(!$this->_VisibleToUser()) exit;

if(isset($params['show_code_iso'])){
	$this->SetPreference('show_code_iso',$params['show_code_iso']);
}
if(isset($params['multiInstances'])){
	$this->SetPreference('multiInstances',$params['multiInstances']);
}
if(isset($params['default_alias'])){
	$this->SetPreference('default_alias',$params['default_alias']);
}
if(isset($params['prefix'])){
	$this->SetPreference('prefix',$params['prefix']);
}
if(isset($params['cms_page'])){
	$this->SetPreference('cms_page',$params['cms_page']);
}

//Refresh Routes
$this->CreateStaticRoutes();

$this->RedirectToAdminTab('tab1');


?>