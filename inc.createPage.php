<?php

$version = new Version();
$version->set('title', $titleParam);
$version->set('text', "## Your title <h2> for the new page {$titleParam}\r\nWrite here some text");
$version->set('lang', $lang->get('lang_id'));


$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'post', '', true, '', array());
$cancel = RouteMaker::getViewRoute($id, $returnid, $langParam, $this->_getDefaultTitle());
$preview = RouteMaker::getPreviewRoute($id, $returnid, $langParam, $titleParam);








$smarty->assign('version', $version->getValues());

$smarty->assign('title', $titleParam);
$smarty->assign('action', 'Create');

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

echo $this->ProcessTemplate('editPage.tpl');


?>