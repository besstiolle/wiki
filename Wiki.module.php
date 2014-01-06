<?php

/* Force the loading of Orm Framework BEFORE this module */
$config = cmsms()->GetConfig();
$Orm = $config['root_path'].'/modules/Orm/Orm.module.php';
if( !is_readable( $Orm ) ) {
  echo '<h1><font color="red">ERROR: The Orm Framework could not be found [<a href="https://github.com/besstiolle/orm-ms/wiki">help</a>].</font></h1>';
  return;
}
require_once($Orm);

class Wiki extends Orm
{   
	function __construct() {
		parent::__autoload();
		parent::__construct();
	}

	function GetName() {
		return 'Wiki';
	}

	function GetFriendlyName() {
		return $this->Lang('friendlyname');
	}

	function GetVersion() {
		return '1.0.0';
	}

	function GetDependencies() {
		return array('Orm'=>'0.2.1');
	}

	function GetHelp() {
		return $this->Lang('help');
	}

	function GetAuthor() {
		return 'Kevin Danezis (aka Bess)';
	}

	function GetAuthorEmail() {
		return 'contact at furie point be';
	}

	function GetChangeLog() {
		return $this->Lang('changelog');
	}

	function GetAdminDescription() {
		return $this->Lang('moddescription');
	}

	function MinimumCMSVersion() {
		return "1.11.0";
	}

	function IsPluginModule() {
		return true;
	}

	function HasAdmin() {
		return true;
	}

	function GetAdminSection() {
		return 'content';
	}

	function VisibleToAdminUser() {
		return true;
	}

	function InitializeFrontend() {
		$this->RegisterModulePlugin(true, false);
		$this->RestrictUnknownParams();
		
		$this->SetParameterType('wtitle',CLEAN_STRING);
		$this->SetParameterType('wlang',CLEAN_STRING);
		
		//save
		$this->SetParameterType('wtext',CLEAN_STRING);
		$this->SetParameterType('save',CLEAN_STRING);
		$this->SetParameterType('page_id',CLEAN_INT);
		$this->SetParameterType('lang_id',CLEAN_INT);
		$this->SetParameterType('version_id',CLEAN_INT); // raw action
		$this->SetParameterType('werrors',CLEAN_NONE);
		
	}

	function InitializeAdmin() {
	}

	function AllowSmartyCaching() {
		return true;
	}

	function LazyLoadFrontend() {
		return false;
	}

	function LazyLoadAdmin() {
		return false;
	}

	function InstallPostMessage() {
		return $this->Lang('postinstall');
	}

	function UninstallPostMessage() {
		return $this->Lang('postuninstall');
	}

	function UninstallPreMessage() {
		return $this->Lang('really_uninstall');
	}

	function DisplayErrorPage($msg) {
		echo "<h3>".$msg."</h3>";
	}  
	
	public function CreateStaticRoutes() {
	
		$returnid = cmsms()->GetContentOperations()->GetDefaultContent();

		//WIth nothing
		$route = new CmsRoute('/[wW]iki$/', $this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
				
		//Without Lang
		$route = new CmsRoute('/[wW]iki\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)$/', $this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/edit$/', $this->GetName(), array('action'=>'edit','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/delete$/', $this->GetName(), array('action'=>'delete','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/preview$/', $this->GetName(), array('action'=>'preview','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/raw\/(?P<version_id>[0-9]+)$/', $this->GetName(), array('action'=>'raw','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		//With Lang
		$route = new CmsRoute('/[wW]iki\/(?P<wlang>[a-zA-Z0-9\-\_]*?)\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)$/', $this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wlang>[a-zA-Z0-9\-\_]*?)\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/edit$/', $this->GetName(), array('action'=>'edit','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wlang>[a-zA-Z0-9\-\_]*?)\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/delete$/', $this->GetName(), array('action'=>'delete','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wlang>[a-zA-Z0-9\-\_]*?)\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/preview$/', $this->GetName(), array('action'=>'preview','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		$route = new CmsRoute('/[wW]iki\/(?P<wlang>[a-zA-Z0-9\-\_]*?)\/(?P<wtitle>[a-zA-Z0-9\-\_\:]+)\/raw\/(?P<version_id>[0-9]+)$/', $this->GetName(), array('action'=>'raw','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
  }
	
	/**
	 * a inner function for factorize some recurrent code
	 **/
	function securize($str){
		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}
} 
?>
