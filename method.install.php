<?php

if (!function_exists("cmsms")) exit;

include_once(dirname(__FILE__).'/inc.reset.php');
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
=======
include_once(dirname(__FILE__).'/inc.designInsert.php');

#Set Permission
$this->CreatePermission('Manage Wiki', 'Wiki : Manage basics options');
$this->CreatePermission('Advance Manage Wiki', 'Wiki : Allow reseting wiki');
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );
?>
