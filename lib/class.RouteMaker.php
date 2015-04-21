<?php

class RouteMaker{

	private static $wiki;

	private static $id;
	private static $returnid;
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc

	public static function init($id, $returnid){
		RouteMaker::$id = $id;
		RouteMaker::$returnid = $returnid;
	}

	public static function getDeleteRoute($langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $title, 'delete', null, $additionnalParameters);
	}
	
	public static function getEditRoute($langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $title, 'edit', null, $additionnalParameters);
	}
	
	public static function getPreviewRoute($langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $title, 'preview', null, $additionnalParameters);
	}
	
	public static function getRawRoute($langPrefix = null, $title, $version_id, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $title, 'raw', $version_id, $additionnalParameters);
	}
	
	public static function getViewOldRoute($langPrefix = null, $title, $version_id, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $title, 'view', $version_id, $additionnalParameters);
	}
	
	public static function getViewRoute($langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $title, null, null, $additionnalParameters);
=======
	private static $prefix;

	private static $isInitiated = false;

	public static function init($id, $returnid, $prefix){
		
		if(self::$wiki == null){
			$modops = cmsms()->GetModuleOperations(); 
			self::$wiki = $modops->get_module_instance('Wiki');
		}
		
		self::$id = $id;
		self::$returnid = $returnid;
		self::$prefix = $prefix;
		self::$isInitiated = true;
	}

	public static function getDeleteRoute($langPrefix = null, $alias, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $alias, 'delete', null, $additionnalParameters);
	}
	
	public static function getEditRoute($langPrefix = null, $alias, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $alias, 'edit', null, $additionnalParameters);
	}
	
	public static function getPreviewRoute($langPrefix = null, $alias, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $alias, 'preview', null, $additionnalParameters);
	}
	
	public static function getRawRoute($langPrefix = null, $alias, $version_id, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $alias, 'raw', $version_id, $additionnalParameters);
	}
	
	public static function getViewOldRoute($langPrefix = null, $alias, $version_id, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $alias, 'view', $version_id, $additionnalParameters);
	}
	
	public static function getViewRoute($langPrefix = null, $alias, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, $alias, null, null, $additionnalParameters);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
	}

	public static function getRootRoute($langPrefix = null, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, null, null, null, $additionnalParameters);
	}
	
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
	protected static function getRoute($id, $returnid, $langPrefix = null, $title = null, $action = null, $version_id = null, $additionnalParameters = null){
		if(self::$wiki == null){
			$modops = cmsms()->GetModuleOperations(); 
			self::$wiki = $modops->get_module_instance('Wiki');
=======
	protected static function getRoute($langPrefix = null, $alias = null, $action = null, $version_id = null, $additionnalParameters = null){
		if(!self::$isInitiated) {
			throw new Exception("Error RouteMaker is not initiated", 1);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		}
		
		$url = '';
		
		// "wiki"
		$url .= self::$prefix;

		// "/en_US"
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$url .= (self::$wiki->GetPreference('show_code_iso', true) && $langPrefix != null ?'/'.$langPrefix:"");
		
		// "/title"
		$url .= ($title==null?'':'/'.$title);
=======
		$url .= (self::$wiki->_getShowCodeIso() && $langPrefix != null ?'/'.$langPrefix:"");
		
		// "/title"
		$url .= ($alias==null?'':'/'.$alias);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		
		// "/action"
		$url .= ($action==null?'':'/'.$action);
		
		// "/version_id"
		$url .= ($version_id==null?'':'/'.$version_id);

		if( !is_array($additionnalParameters)){
			$additionnalParameters = array();
		}

		$parameters = array();

		if(!empty($additionnalParameters)){
			$url.='?';
		}

		foreach ($additionnalParameters as $key => $value) {
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
			$url .= '&'.$id.$key.'='.$value;
			$parameters = array_merge($parameters, $additionnalParameters);
		}
		$parameters['vlang'] = ($langPrefix != null ? $langPrefix : "");
		$parameters['vtitle'] = $title;
		$parameters['prefix'] = self::$wiki->GetPreference('prefix');
=======
			$url .= '&'.self::$id.$key.'='.$value;
			$parameters = array_merge($parameters, $additionnalParameters);
		}
		$parameters['vlang'] = ($langPrefix != null ? $langPrefix : "");
		$parameters['vtitle'] = $alias;
		$parameters['prefix'] = self::$prefix;
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		if ($version_id != null){
			$parameters['version_id'] = $version_id;
		}

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		$finalUrl = self::$wiki->CreateFrontendLink ((empty($action) || $action == 'view' ?'default':$action), '', 
=======
		$finalUrl = self::$wiki->CreateFrontendLink (self::$id, self::$returnid, 
				(empty($action) || $action == 'view' ?'default':$action), 
				'', 
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
				$parameters
				, '', true, true, '', '', 
				$url
		);

		/*echo "<a href='".$finalUrl."'>".$finalUrl.'</a><br/><br/>';*/

		return $finalUrl;

	}

}

?>