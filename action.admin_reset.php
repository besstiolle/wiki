<?php
if (!function_exists('cmsms')) exit;

if(!$this->_VisibleToAdmin()) exit;

include_once(dirname(__FILE__).'/inc.reset.php');

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('reseted', $this->GetVersion()) );


$this->RedirectToAdminTab('tab4');

?>