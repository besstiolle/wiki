<?php

class RouteMaker{

	private static $wiki;

	public static function getDeleteRoute($id, $returnid, $langPrefix = null, $title){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'delete');
	}
	
	public static function getEditRoute($id, $returnid, $langPrefix = null, $title){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'edit');
	}
	
	public static function getPreviewRoute($id, $returnid, $langPrefix = null, $title){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'preview');
	}
	
	public static function getRawRoute($id, $returnid, $langPrefix = null, $title, $version_id){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'raw', $version_id);
	}
	
	public static function getViewOldRoute($id, $returnid, $langPrefix = null, $title, $version_id){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title, 'view', $version_id);
	}
	
	public static function getViewRoute($id, $returnid, $langPrefix = null, $title){
		return RouteMaker::getRoute($id, $returnid, $langPrefix, $title);
	}
	
	protected static function getRoute($id, $returnid, $langPrefix = null, $title, $action = null, $version_id = null){
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
		$url .= '/'.$title;
		
		// "/action"
		$url .= ($action==null?'':'/'.$action);
		
		// "/version_id"
		$url .= ($version_id==null?'':'/'.$version_id);

		$finalUrl = self::$wiki->CreateLink ($id, (empty($action) || $action == 'view' ?'default':$action), $returnid, '', 
				array('wlang' => ($langPrefix != null ? $langPrefix : ""), 'wtitle'=> $title)
				, '', true, false, '', '', 
				$url
		);

		echo $finalUrl.'<br/>';

		return $finalUrl;

	}

}

?>