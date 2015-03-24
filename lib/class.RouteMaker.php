<?php

class RouteMaker{

	private static $wiki;

	private static $id;
	private static $returnid;

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
	}

	public static function getRootRoute($langPrefix = null, $additionnalParameters = null){
		return RouteMaker::getRoute($langPrefix, null, null, null, $additionnalParameters);
	}
	
	protected static function getRoute($id, $returnid, $langPrefix = null, $title = null, $action = null, $version_id = null, $additionnalParameters = null){
		if(self::$wiki == null){
			$modops = cmsms()->GetModuleOperations(); 
			self::$wiki = $modops->get_module_instance('Wiki');
		}
		
		
		$url = '';
		
		// "wiki"
		$url .= self::$wiki->GetPreference('prefix');
		
		// "/en_US"
		$url .= (self::$wiki->GetPreference('show_code_iso', true) && $langPrefix != null ?'/'.$langPrefix:"");
		
		// "/title"
		$url .= ($title==null?'':'/'.$title);
		
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
			$url .= '&'.$id.$key.'='.$value;
			$parameters = array_merge($parameters, $additionnalParameters);
		}
		$parameters['vlang'] = ($langPrefix != null ? $langPrefix : "");
		$parameters['vtitle'] = $title;
		$parameters['prefix'] = self::$wiki->GetPreference('prefix');
		if ($version_id != null){
			$parameters['version_id'] = $version_id;
		}

		$finalUrl = self::$wiki->CreateFrontendLink ((empty($action) || $action == 'view' ?'default':$action), '', 
				$parameters
				, '', true, true, '', '', 
				$url
		);

		//echo "<a href='".$finalUrl."'>".$finalUrl.'</a><br/><br/>';

		return $finalUrl;

	}

}

?>