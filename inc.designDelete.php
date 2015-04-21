<?php
if (!function_exists('cmsms')) exit;


try{
	$design = CmsLayoutCollection::load("Wiki Design With Foundation");
	$css_all = $design->get_stylesheets();
	if($css_all != null){
	foreach ($css_all as $css) {
		try{
			$css_obj = CmsLayoutStylesheet::load($css);
			if($css_obj != null){$css_obj->delete();echo "<br/>css ".$css_obj->get_name()." deleted";}
		} catch (CmsDataNotFoundException $e){ echo "css ".$css." not found"; }

		$design->delete_stylesheet($css);
	}}

	$tpl_all = $design->get_templates();
	if($tpl_all != null){
	foreach ($tpl_all as $tpl) {
		try{
			$tpl_obj = CmsLayoutTemplate::load($tpl);
			if($tpl_obj != null){$tpl_obj->delete();echo "<br/>tpl ".$tpl_obj->get_name()." deleted";}
		} catch (CmsDataNotFoundException $e){ echo "template ".$tpl." not found"; }

		$design->set_templates(array());
	}}
	
	try{
		$design->delete();
		echo "<br/>design ".$design->get_name()." deleted";
	} catch (CmsException $e){ echo "design ".$design->get_name()." cannot be deleted"; echo $e->getMessage();}

} catch (CmsDataNotFoundException $e){ echo "design not found";  echo $e->getMessage();}

?>