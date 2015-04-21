<?php

if (!function_exists("cmsms")) exit;

include_once(dirname(__FILE__).'/inc.reset.php');
include_once(dirname(__FILE__).'/inc.designInsert.php');

#Set Permission
$this->CreatePermission('Manage Wiki', 'Wiki : Manage basics options');
$this->CreatePermission('Advance Manage Wiki', 'Wiki : Allow reseting wiki');

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );
?>
