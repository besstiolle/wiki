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
		return array('Orm'=>'0.3.0');
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
		$prefix = '[wW]iki';
		$lang = '(?P<wlang>[a-zA-Z0-9\-\_]*?)';
		$title = '(?P<wtitle>[a-zA-Z0-9\-\_\:]+)';
		$version = '(?P<version_id>[0-9]+)';

		//With nothing
		$route = $this->_generateRoute($prefix);
		$this->_add_static($route, array('action'=>'default','returnid'=>$returnid));
				
		//With Lang
		$route = $this->_generateRoute($prefix, $lang, $title);
		$this->_add_static($route, array('action'=>'default','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $title, 'view');
		$this->_add_static($route, array('action'=>'view','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $title, 'view', $version);
		$this->_add_static($route, array('action'=>'view','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $title, 'edit');
		$this->_add_static($route, array('action'=>'edit','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $title, 'delete');
		$this->_add_static($route, array('action'=>'delete','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, '([a-zA-Z0-9\-\_\:]+)', 'preview');
		$this->_add_static($route, array('action'=>'preview','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $title, 'raw', $version);
		$this->_add_static($route, array('action'=>'raw','returnid'=>$returnid));
		
		
   }

    private function _generateRoute(){
   		return '/'.implode('\/', func_get_args()).'$/';
    }

    private function _add_static($route, $params){
		cms_route_manager::add_static(new CmsRoute($route, $this->GetName(), $params));
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
