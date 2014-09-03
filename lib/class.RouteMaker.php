<?php

class RouteMaker{

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
		$modops = cmsms()->GetModuleOperations(); 
		$wiki = $modops->get_module_instance('Wiki');
		
		$url = '';
		
		// "wiki"
		$url .= $wiki->GetPreference('prefix');
		
		// "/en_US"
		$url .= ($wiki->GetPreference('show_prefix_lang', true) && $langPrefix != null ?'/'.$langPrefix:"");
		
		// "/title"
		$url .= '/'.$title;
		
		// "/action"
		$url .= ($action==null?'':'/'.$action);
		
		// "/version_id"
		$url .= ($version_id==null?'':'/'.$version_id);

		$finalUrl = $wiki->CreateLink ($id, $action, $returnid, '', 
				array('wlang' => ($langPrefix != null ? $langPrefix : ""), 'wtitle'=> $title)
				, '', true, false, '', '', 
				$url
		);

		return $finalUrl;

	}

}

?>