<?php

class RouteMaker{

	private static $wiki;

	private static $id;
	private static $returnid;
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
	}

	public static function getRootRoute($langPrefix = null, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, null, null, null, $additionnalParameters);
	}
	
	protected static function getRoute($langPrefix = null, $alias = null, $action = null, $version_id = null, $additionnalParameters = null){
		if(!self::$isInitiated) {
			throw new Exception("Error RouteMaker is not initiated", 1);
		}
		$url = '';
		
		// "wiki"
		$url .= self::$prefix;

		// "/en_US"
		$url .= (self::$wiki->_getShowCodeIso() && $langPrefix != null ?'/'.$langPrefix:"");
		
		// "/title"
		$url .= ($alias==null?'':'/'.$alias);
		
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
			$url .= '&'.self::$id.$key.'='.$value;
			$parameters = array_merge($parameters, $additionnalParameters);
		}
		$parameters['vlang'] = ($langPrefix != null ? $langPrefix : "");
		$parameters['vtitle'] = $alias;
		$parameters['prefix'] = self::$prefix;
		if ($version_id != null){
			$parameters['version_id'] = $version_id;
		}

		$finalUrl = self::$wiki->CreateFrontendLink (self::$id, self::$returnid, 
				(empty($action) || $action == 'view' ?'default':$action), 
				'', 
				$parameters
				, '', true, true, '', '', 
				$url
		);

		/*echo "<a href='".$finalUrl."'>".$finalUrl.'</a><br/><br/>';*/

		return $finalUrl;

	}

}

?>