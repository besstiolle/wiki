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
		spl_autoload_register(array($this,'autoload_framework'));
		$this->scan();
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
		return array('Orm'=>'0.3.0-SNAPSHOT');
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
		$this->_inner_createStaticRoutes('[wW]iki', '(?P<wlang>[a-zA-Z0-9\-\_]*?)');
	}
	
	public function _inner_createStaticRoutes($prefix, $lang) {
	
		$returnid = cmsms()->GetContentOperations()->GetDefaultContent();
		$pipe = '\/';
		$title = '(?P<wtitle>[a-zA-Z0-9\-\_\:]+)';
		$version = '(?P<version_id>[0-9]+)';

		//WIth nothing
		$route = new CmsRoute("/{$prefix}$/", $this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
				
		//With Lang
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}{$title}$/", 
				$this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}{$title}{$pipe}view$/", 
				$this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}{$title}{$pipe}view{$pipe}{$version}$/", 
				$this->GetName(), array('action'=>'default','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}{$title}{$pipe}edit$/", 
				$this->GetName(), array('action'=>'edit','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}{$title}{$pipe}delete$/", 
				$this->GetName(), array('action'=>'delete','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}([a-zA-Z0-9\-\_\:]+){$pipe}preview$/", 
				$this->GetName(), array('action'=>'preview','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
		$route = new CmsRoute("/{$prefix}{$pipe}{$lang}{$pipe}{$title}{$pipe}raw{$pipe}{$version}$/", 
				$this->GetName(), array('action'=>'raw','returnid'=>$returnid));
		cms_route_manager::add_static($route);
		
   }
	
	/**
	 * a inner function for factorize some recurrent code
	 **/
	function securize($str){
		return htmlentities($str, ENT_QUOTES, 'UTF-8');
	}
	/**
	* @param string $str unicode and ulrencoded string
	* @return string decoded string
	*/
	function js_urldecode($str) {
	    return preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
	}

	/**
	 * 1 - Replace accent
	 * 2 - Replace everything except a-zA-Z0-9  and -:_  by a underscore
	 * 3 - Replace groupe of underscore by a single underscore
	 *
	 */
	function clean_title($str, $charset='UTF-8'){
		$str = htmlentities($str, ENT_NOQUOTES, $charset);
		
		$str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
		$str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
		
		//$str = str_replace(array('&#45;','&#58;','&#95;'), array('-',':','_') , $str); // restaure -:_
		$str = preg_replace('#&[^;]+;#', '_', $str); // supprime les autres caractères html
		$str = preg_replace('#[^a-zA-Z0-9\-_:]#', '_', $str); // supprime les autres caractères interdits
		$str = preg_replace('#(_)+#', '_', $str); // reduit les couples d'underscore
		$str = preg_replace('#(:)+#', ':', $str); // reduit les couples de ::::
    
		$str = html_entity_decode($str, ENT_NOQUOTES, $charset);
		
		return $str;
	}
		
	function _getDefaultLang(){
		return 'en_US';
	}
	
	function _getDefaultTitle(){
		return 'home';
	}
	
	function _getDefaultEngine(){
		return Engines::$MARKDOWN;
	}
} 
?>
