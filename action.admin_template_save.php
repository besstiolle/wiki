<?php

if (!function_exists("cmsms")) exit;

if(!$this->_VisibleToUser()) exit;

if(isset($params['template_access'])){
	$this->SetTemplate('access',$params['template_access']);
}
$this->RedirectToAdminTab('tab3');


?>