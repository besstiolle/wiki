<?php

$version = new Version();
$version->set('title', $titleParam);
$version->set('text', "## {$titleParam}\r\nWrite here some text");
$version->set('lang_id', $lang->get($lang->getPk()->getName()));


$form = $this->CreateFormStart($id, 'save', $returnid, 'post');
$cancel = $this->CreateLink ($id, "default", $returnid, '', array(), 'Sure ?', true, false, '', '', RouteMaker::getViewRoute($langParam, 'home'));


$smarty->assign('version', $version->getValues());
//$smarty->assign('page', $page->getValues());
//$smarty->assign('lang', $lang->getValues());

$smarty->assign('cancel', $cancel);
$smarty->assign('form', $form);

echo $this->ProcessTemplate('editPage.tpl');


?>