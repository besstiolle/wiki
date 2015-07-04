<?php

$palias = $this->_getDefaultAlias();
$pprefix = $this->_getDefaultPrefix();
$vlang = $this->_getDefaultLang();

if(!empty($params['pprefix'])){
	$pprefix = $params['pprefix'];
}
if(!empty($params['palias'])){
	$palias = $params['palias'];
}
if(!empty($params['vlang'])){
	$vlang = $params['vlang'];
}

$page = PagesService::getOneByAlias($pprefix, $palias);
$lang = LangsService::getOne($vlang);
$version = null;
if($page == null || $lang == null){
	return false;
} else {
	$version = VersionsService::getOne($page->get("page_id"), $lang->get("lang_id") , Version::$STATUS_CURRENT);
	return ($version != null);
}

?>