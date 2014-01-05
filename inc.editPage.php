<?php


$form = $this->CreateFormStart($id, 'save', $returnid, 'post');
$cancel = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $titleParam));
$preview = $this->CreateLink ($id, "preview", $returnid, '', array(), '', true, false, '', '', RouteMaker::getPreviewRoute($langParam, $titleParam));


$smarty->assign('version', $version->getValues());
//$smarty->assign('page', $page->getValues());
//$smarty->assign('lang', $lang->getValues());

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

echo $this->ProcessTemplate('editPage.tpl');


?>