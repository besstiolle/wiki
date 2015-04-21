<?php
if (!function_exists('cmsms')) exit;

$smarty->assign('gatewayParams', $params);
$this->ProcessTemplateFromDatabase('access');
define('_JS_ACTION_',FALSE);

if(!Authentification::is_readable()){
	$errors = array("wiki_not_readable");
	$smarty->assign('errors', $errors);
	echo $this->ProcessTemplate('message.tpl');
	return;
}

//Default values in view class in case of {Wiki} 
if(empty($params['palias'])) {
	$params['palias'] = $this->_getDefaultAlias();
}
if(empty($params['vlang'])) {
	$params['vlang'] = $this->_getDefaultLang();
}

//Common initialization
include_once('inc.initialization.php');

if($has_error){return;}


/* Variables available :
 *
 * $errors & $messages
 * $smarty
 * $aliasParam & $langParam
 * $page & $lang
 * $prefix from preferences prefix
 * $code_iso with preferences show_code_iso
 * $engine
 * $all_langs_by_code && $all_langs_by_id
 * $isDefaultLang $isDefaultPage $isDefaultVersion
 *
 **/

$entries = VersionsService::getAllCurrentByPrefixAndLang($prefix,  $lang->get('lang_id'));

$sitemap = array();

//echo count($entries);
foreach ($entries as $entry) {
	$alias = $entry->get('page')->get('alias');
	$exploded = explode(':', $alias);

	$sitemap = parseEntry($sitemap, $exploded, $entry, '');

//	echo "\n----- ".$alias." ------\n";
//	echo print_r($sitemap, true);

	
}

function parseEntry($sub, $exploded, $entry, $currentalias){


	$part = array_shift($exploded);

	if(!empty($currentalias)){
		$currentalias.= ':';	
	}
	$currentalias.= $part;

	if(!isset($sub[$part])){
		$sub[$part] = array(
			'label' => $part,
			'url' => RouteMaker::getViewRoute($entry->get('lang')->get('code'), $currentalias),
			'css' => 'new',
			'children' => array(),
			);
	}
	
	if(!empty($exploded)){
		$sub[$part]['children'] = parseEntry($sub[$part]['children'], $exploded, $entry, $currentalias);
	} else {
		$sub[$part]['label'] = $entry->get('title');
		$sub[$part]['css'] = 'follow';
		$sub[$part]['url'] = RouteMaker::getViewRoute($entry->get('lang')->get('code'), $entry->get('page')->get('alias'));
	}

	return $sub;
}

array_multisort($sitemap);

$smarty->assign('root_wiki_url', RouteMaker::getRootRoute($langParam));
$smarty->assign('sitemap', $sitemap);

echo $this->ProcessTemplate('sitemap.tpl');

?>