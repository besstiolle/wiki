<?php
if (!function_exists('cmsms')) exit;

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
$vals = array();
$vals['lang'] = $lang->get('lang_id');

if(!empty($params['vtitle'])){
	$vals['title'] = html_entity_decode($params['vtitle']);
} else {
	$vals['title'] = $aliasParam.' ['.$lang->get('label').']';
}

if(!empty($params['vtext'])){
	$vals['text'] = html_entity_decode($params['vtext']);
} else {
	$vals['text'] = "## Your subTitle for the new page {$aliasParam} [".$lang->get('label')."]\r\nWrite here some text";
}
$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'post', '', true, '', array(
					'vlang' => $lang->get('code'),
					'palias' => $page->get('alias')
					));
$cancel = RouteMaker::getRootRoute($id, $returnid, $langParam);
$preview = RouteMaker::getPreviewRoute($id, $returnid, $langParam, $aliasParam);
=======

$vals = array();
$vals['lang'] = $lang->get('lang_id');

if(!empty($params['vtitle'])){
	$vals['title'] = html_entity_decode($params['vtitle']);
} else {
	$vals['title'] = $aliasParam.' ['.$lang->get('label').']';
}
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

if(!empty($params['vtext'])){
	$vals['text'] = html_entity_decode($params['vtext']);
} else if( $this->_getDefaultAlias() == $page->get('alias') && $this->_getDefaultLang() == $lang->get('code')){
	$vals['text'] = htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.md'));
} else {
	$vals['text'] = "## Your subTitle for the new page {$aliasParam} [".$lang->get('label')."]\r\nWrite here some text";
}
$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'post', '', true, '', array(
					'vlang' => $lang->get('code'),
					'palias' => $page->get('alias'),
					'pprefix' => $prefix
					));
$cancel = RouteMaker::getRootRoute($langParam);
$preview = RouteMaker::getPreviewRoute($langParam, $aliasParam);







<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
$smarty->assign('version', $vals);

=======

$smarty->assign('version', $vals);

>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$smarty->assign('title', $vals['title']);
$smarty->assign('action', 'Create');

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

$js = $this->ProcessTemplate('editPage.js.tpl');
$smarty->assign('wiki_js', $js);

echo $this->ProcessTemplate('editPage.tpl');


?>