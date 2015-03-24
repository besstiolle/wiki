<?php







$form = $this->CreateFrontendFormStart ($id, $returnid, 'save', 'get', '', true, '', array());//,'',false,true,  ' data-abide');
$cancel = RouteMaker::getViewRoute($id, $returnid, $langParam, $titleParam);
$preview = RouteMaker::getPreviewRoute($id, $returnid, $langParam, $titleParam);

//Case : get in edition after an error : keep the previous text.
if(!empty($params['wtext'])){
	$vals['text'] = html_entity_decode($params['wtext']);
}
if(!empty($params['wtitle'])){
	$vals['title'] = html_entity_decode($params['wtitle']);
}

$page_values = $page->getValues();

$smarty->assign('version', $vals);
$smarty->assign('page', $page_values);
$smarty->assign('title', $titleParam);
$smarty->assign('action', 'Edit');

$smarty->assign('cancel', $cancel);
$smarty->assign('preview', $preview);
$smarty->assign('form', $form);

$js = $this->ProcessTemplate('editPage.js.tpl');
$smarty->assign('wiki_js', $js);

echo $this->ProcessTemplate('editPage.tpl');


?>