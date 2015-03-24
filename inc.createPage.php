<?php

$version = new Version();
$version->set('lang', $lang->get('lang_id'));

if(!empty($params['wtitle'])){
	$version->set('title', html_entity_decode($params['wtitle']));
} else {
	$version->set('title', $titleParam);
}

if(!empty($params['wtext'])){
	$version->set('text', html_entity_decode($params['wtext']));
} else {
	$version->set('text', "## Your title <h2> for the new page {$titleParam}\r\nWrite here some text");
}
$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'post', '', true, '', array('create_page_title' => $titleParam));
$cancel = RouteMaker::getRootRoute($id, $returnid, $langParam);
$preview = RouteMaker::getPreviewRoute($id, $returnid, $langParam, $titleParam);








$smarty->assign('version', $version->getValues());

$smarty->assign('title', $titleParam);
$smarty->assign('action', 'Create');

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);


$js = $this->ProcessTemplate('editPage.js.tpl');
$smarty->assign('wiki_js', $js);

echo $this->ProcessTemplate('editPage.tpl');


?>