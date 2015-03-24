<?php
if (!function_exists('cmsms')) exit;

include_once(dirname(__FILE__).'/inc.reset.php');

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('reseted', $this->GetVersion()) );


$this->Redirect($id, 'defaultadmin');

?>