<?php







$form = $this->CreateFormStart($id, 'save', $returnid, 'post','',false,'',array(), ' data-abide');
$cancel = $this->CreateLink ($id, "default", $returnid, '', array(), '', true, false, '', '', RouteMaker::getViewRoute($langParam, $titleParam));
$preview = $this->CreateLink ($id, "preview", $returnid, '', array(), '', true, false, '', '', RouteMaker::getPreviewRoute($langParam, $titleParam));

//Case : get in edition after an error : keep the previous text.
if(!empty($params['wtext'])){
	$vals['text'] = html_entity_decode($params['wtext']);
}

$smarty->assign('version', $vals);
//$smarty->assign('page', $page->getValues());
//$smarty->assign('lang', $lang->getValues());

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

echo $this->ProcessTemplate('editPage.tpl');


?>