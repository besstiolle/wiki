<?php

class RouteMaker{

	public static function getDeleteRoute($langPrefix = null, $title){
		return RouteMaker::getRoute($langPrefix, $title, 'delete');
	}
	
	public static function getEditRoute($langPrefix = null, $title){
		return RouteMaker::getRoute($langPrefix, $title, 'edit');
	}
	
	public static function getPreviewRoute($langPrefix = null, $title){
		return RouteMaker::getRoute($langPrefix, $title, 'preview');
	}
	
	public static function getRawRoute($langPrefix = null, $title, $version_id){
		return RouteMaker::getRoute($langPrefix, $title, 'raw', $version_id);
	}
	
	public static function getViewOldRoute($langPrefix = null, $title, $version_id){
		return RouteMaker::getRoute($langPrefix, $title, 'view', $version_id);
	}
	
	public static function getViewRoute($langPrefix = null, $title){
		return RouteMaker::getRoute($langPrefix, $title);
	}
	
	protected static function getRoute($langPrefix = null, $title, $action = null, $version_id = null){
		$modops = cmsms()->GetModuleOperations(); 
		$wiki = $modops->get_module_instance('Wiki');
		
		$url = '';
		
		// "wiki"
		$url .= $wiki->GetPreference('prefix');
		
		// "/en_US"
		$url .= ($wiki->GetPreference('show_prefix_lang', true)?'/'.$langPrefix:"");
		
		// "/title"
		$url .= '/'.$title;
		
		// "/action"
		$url .= ($action==null?'':'/'.$action);
		
		// "/version_id"
		$url .= ($version_id==null?'':'/'.$version_id);
		
		return $url;
	}

}

?>