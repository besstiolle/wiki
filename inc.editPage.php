<?php

$form = $this->CreateFormStart($id, 'save', $returnid, 'post');
$cancel = $this->CreateLink ($id, "default", $returnid, '', array(), 'Sure ?', true, false, '', '', RouteMaker::getViewRoute($langParam, $titleParam));


$smarty->assign('version', $version->getValues());
//$smarty->assign('page', $page->getValues());
//$smarty->assign('lang', $lang->getValues());

$smarty->assign('cancel', $cancel);
$smarty->assign('form', $form);

echo $this->ProcessTemplate('editPage.tpl');


?>