<?php

class RouteMaker{

	private static $wiki;

	public static function getDeleteRoute($id, $returnid, $langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'delete', null, $additionnalParameters);
	}
	
	public static function getEditRoute($id, $returnid, $langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'edit', null, $additionnalParameters);
	}
	
	public static function getPreviewRoute($id, $returnid, $langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'preview', null, $additionnalParameters);
	}
	
	public static function getRawRoute($id, $returnid, $langPrefix = null, $title, $version_id, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'raw', $version_id, $additionnalParameters);
	}
	
	public static function getViewOldRoute($id, $returnid, $langPrefix = null, $title, $version_id, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'view', $version_id, $additionnalParameters);
	}
	
	public static function getViewRoute($id, $returnid, $langPrefix = null, $title, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, null, null, $additionnalParameters);
	}

	public static function getRootRoute($id, $returnid, $langPrefix = null, $additionnalParameters = null){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, null, null, null, $additionnalParameters);
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
		$url .= (self::$wiki->GetPreference('show_prefix_lang', true) && $langPrefix != null ?'/'.$langPrefix:"");
		
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
		$parameters['wlang'] = ($langPrefix != null ? $langPrefix : "");
		$parameters['wtitle'] = $title;
		$parameters['prefix'] = self::$wiki->GetPreference('prefix');
		if ($version_id != null){
			$parameters['version_id'] = $version_id;
		}

		$finalUrl = self::$wiki->CreateFrontendLink ($id, $returnid, (empty($action) || $action == 'view' ?'default':$action), '', 
				$parameters
				, '', true, true, '', '', 
				$url
		);

		//echo "<a href='".$finalUrl."'>".$finalUrl.'</a><br/><br/>';

		return $finalUrl;

	}

}

?>