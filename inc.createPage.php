<?php

$version = new Version();
$version->set('title', $titleParam);
$version->set('text', "## {$titleParam}\r\nWrite here some text");
$version->set('lang_id', $lang->get($lang->getPk()->getName()));


$form = $this->CreateFormStart($id, 'save', $returnid, 'post');
$cancel = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, 'home'));
$preview = $this->CreateLink ($id, "preview", $returnid, '', array(), '', true, false, '', '', RouteMaker::getPreviewRoute($langParam, $titleParam));

$smarty->assign('version', $version->getValues());
$smarty->assign('title', $titleParam);
$smarty->assign('action', 'Create');

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

echo $this->ProcessTemplate('editPage.tpl');


?>