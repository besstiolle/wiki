<?php


class Wiki extends Orm {   

	function GetName() { return 'Wiki'; }
	function GetFriendlyName() { return $this->Lang('friendlyname'); }
	function GetVersion() { return '1.0.1'; }
	function GetDependencies() { return array('Orm'=>'0.3.3', 'Parser'=>'1.0.0'); }
	function GetHelp() { return $this->Lang('help'); }
	function GetAuthor() { return 'Kevin Danezis (aka Bess)'; }
	function GetAuthorEmail() { return 'contact at furie point be'; }
	function GetChangeLog() { return $this->Lang('changelog'); }
	function GetAdminDescription() { return $this->Lang('moddescription'); }
	function MinimumCMSVersion() { return "1.11.0"; }
	function IsPluginModule() { return true; }
	function HasAdmin() { return true; }
	function GetAdminSection() { return 'content'; }
	
  	function VisibleToAdminUser() { return $this->CheckPermission('Manage Wiki') || $this->CheckPermission('Advance Manage Wiki'); }
  	function _VisibleToUser() { return $this->CheckPermission('Manage Wiki'); }
  	function _VisibleToAdmin() { return $this->CheckPermission('Advance Manage Wiki'); }

	function InitializeFrontend() {
		$this->RegisterModulePlugin(true, false);
		$this->RestrictUnknownParams();
		
		$this->SetParameterType('vtitle',CLEAN_STRING);
		$this->SetParameterType('vtext',CLEAN_STRING);
		$this->SetParameterType('vlang',CLEAN_STRING);

		$this->SetParameterType('palias',CLEAN_STRING);
		$this->SetParameterType('pprefix',CLEAN_STRING);
		
		//save
		$this->SetParameterType('save',CLEAN_STRING);
		$this->SetParameterType('version_id',CLEAN_INT); // raw action
		$this->SetParameterType('werrors',CLEAN_NONE);


		$this->SetParameterType('is_readable',CLEAN_STRING);
		$this->SetParameterType('is_writable',CLEAN_STRING); 
		$this->SetParameterType('is_deletable',CLEAN_STRING);
		$this->SetParameterType('author_name',CLEAN_STRING); 
		$this->SetParameterType('author_id',CLEAN_STRING);
		
	}

	function InitializeAdmin() {
	    $this->CreateParameter('is_readable','false',$this->Lang('help_is_readable'), true);
	    $this->CreateParameter('is_writable','false',$this->Lang('help_is_writable'), true);
	    $this->CreateParameter('is_deletable','false',$this->Lang('help_is_deletable'), true);
	    $this->CreateParameter('author_name','',$this->Lang('help_author_name'), true);
	    $this->CreateParameter('author_id','',$this->Lang('help_author_id'), true);
	}
	function AllowSmartyCaching() { return true; }
	function LazyLoadFrontend() { return false; }
	function LazyLoadAdmin() { return false; }
	function InstallPostMessage() { return $this->Lang('postinstall'); }
	function UninstallPostMessage() { return $this->Lang('postuninstall'); }
	function UninstallPreMessage() { return $this->Lang('really_uninstall'); }
	function DisplayErrorPage($msg) { echo "<h3>".$msg."</h3>"; }  
	
	public function CreateStaticRoutes() {
		
		$page = cmsms()->GetContentOperations()->LoadContentFromAlias($this->_getCmsPage());
		if($page == null) {
			$returnid = cmsms()->GetContentOperations()->GetDefaultContent();
		} else {
			$returnid = $page->Id();
		}
		cms_route_manager::del_static('',$this->GetName());

		$mi = $this->_getMultiInstances();
		$prefix = $this->_getDefaultPrefix();
		if($mi){
			$pattern = '(.)*'.$prefix;
		} else {
			$pattern = $prefix;
		}
		$lang = null;
		if($this->_getShowCodeIso()){
 			$lang = '(?P<vlang>[\w\d\-]*)';
		} 

		$prefix = '(?P<pprefix>'.$pattern.')';
		$alias = '(?P<palias>[\w\d\-\:]*)';//(?P<palias>[\w\d\-]*(?s)^((?!sitemap).)*)
		$version = '(?P<version_id>[0-9]+)';
		$sitemap = '[sS]itemap';

		//With nothing
		$route = $this->_generateRoute($prefix);
		$this->_add_static($route, array('action'=>'default','returnid'=>$returnid));
				
		if($this->_getShowCodeIso()){
			//With Lang
			$route = $this->_generateRoute($prefix, $lang);
			$this->_add_static($route, array('action'=>'default','returnid'=>$returnid, 'palias' => 'home'));
		}
		//With Lang & alias
		$route = $this->_generateRoute($prefix, $lang, $alias);
		$this->_add_static($route, array('action'=>'default','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $alias, 'view');
		$this->_add_static($route, array('action'=>'default','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $alias, 'view', $version);
		$this->_add_static($route, array('action'=>'default','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $alias, 'edit');
		$this->_add_static($route, array('action'=>'edit','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $alias, 'delete');
		$this->_add_static($route, array('action'=>'delete','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, /*'([a-zA-Z0-9\-\_\:]+)'*/ $alias, 'preview');
		$this->_add_static($route, array('action'=>'preview','returnid'=>$returnid));
		
		$route = $this->_generateRoute($prefix, $lang, $alias, 'raw', $version);
		$this->_add_static($route, array('action'=>'raw','returnid'=>$returnid));

		//Sitemap
		$route = $this->_generateRoute($prefix, $lang, $sitemap);
		$this->_add_static($route, array('action'=>'sitemap','returnid'=>$returnid));	
		$route = $this->_generateRoute($prefix, $sitemap);
		$this->_add_static($route, array('action'=>'sitemap','returnid'=>$returnid));	
//die();
   }

    private function _generateRoute(){
    	$config = cmsms()->GetConfig();
    	$ext = $config["page_extension"]; 
    	if($ext !== ''){
    		$ext = str_replace('.', '\.', $ext);
    	}

    	//Avoid null parameter, possible id "no prefix" or "no lang" is set in Wiki
    	$func_params = func_get_args();
    	$func_params_cleaned  = array();
    	foreach($func_params as $p) {
    		if(!empty($p)){
    			$func_params_cleaned[] = $p;
    		}
    	}
   		$route = '#^'.implode('\/', $func_params_cleaned).$ext.'$#';
   		//echo '<div>'.htmlentities($route).'</div>';
   		return $route;
    }

    private function _add_static($route, $params){
		cms_route_manager::add_static(new CmsRoute($route, $this->GetName(), $params));
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
		return $this->GetPreference('default_lang','en_US');
	}
	
	function _getDefaultAlias(){
		return  $this->GetPreference('default_alias','home');
	}

	function _getDefaultPrefix(){
		return $this->GetPreference('prefix','wiki');
	}

	function _getShowCodeIso(){
		return $this->GetPreference('show_code_iso', TRUE);
	}

	function _getMultiInstances(){
		return $this->GetPreference('multiInstances',FALSE);
	}

	function _getCmsPage(){
		return $this->GetPreference('cms_page','wiki');
	}


	function _getMinimalVersionFoundationAsset(){
		return 1;
	}

	function _gethttplinkToFoundationAsset(){
		return "http://dev.cmsmadesimple.org/project/files/1256#package-1303";
	}


} 
?>
