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
	
	public static function getViewRoute($langPrefix = null, $title){
		return RouteMaker::getRoute($langPrefix, $title);
	}
	
	protected static function getRoute($langPrefix = null, $title, $action = null, $version_id = null){
				$modops = cmsms()->GetModuleOperations(); 
		$wiki = $modops->get_module_instance('Wiki');
		
		// "wiki"
		$prefix = $wiki->GetPreference('prefix');
		
		// "/en_US
		$prefix_lang = ($wiki->GetPreference('show_prefix_lang', true)?'/'.$langPrefix:"");
		
		// /action
		$action = ($action==null?'':'/'.$action);
		
		// "wiki/en_US/myPage/action"
		$url = $prefix.$prefix_lang.'/'.$title.$action;
		
		// /version_id 
		$url .= ($version_id==null?'':'/'.$version_id);
		
		return $url;
	}

}

?>