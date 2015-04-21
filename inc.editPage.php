<?php
if (!function_exists('cmsms')) exit;














<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc

$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'get', '', true, '', array(
					'vlang' => $lang->get('code'),
					'palias' => $page->get('alias')
							));
$cancel = RouteMaker::getViewRoute($id, $returnid, $lang->get('code'), $page->get('alias'));
$preview = RouteMaker::getPreviewRoute($id, $returnid, $lang->get('code'), $page->get('alias'));
=======
$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'get', '', true, '', array(
					'vlang' => $lang->get('code'),
					'palias' => $page->get('alias'),
					'pprefix' => $prefix
							));
$cancel = RouteMaker::getViewRoute($lang->get('code'), $page->get('alias'));
$preview = RouteMaker::getPreviewRoute($lang->get('code'), $page->get('alias'));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

$vals = $version->getValues();

//Case : get in edition after an error : keep the previous text.
if(!empty($params['vtext'])){
	$vals['text'] = html_entity_decode($params['vtext']);
}
if(!empty($params['vtitle'])){
	$vals['title'] = html_entity_decode($params['vtitle']);
}

$page_values = $page->getValues();

$smarty->assign('version', $vals);
$smarty->assign('page', $page_values);
$smarty->assign('title', $vals['title']);
$smarty->assign('action', 'Edit');

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

$js = $this->ProcessTemplate('editPage.js.tpl');
$smarty->assign('wiki_js', $js);

echo $this->ProcessTemplate('editPage.tpl');


?>