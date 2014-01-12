<?php

$vals['text'] = Engines::process($vals['text'], $prefix, $prefix_lang, $version->get('engine'));


$edit = $this->CreateLink ($id, "edit", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getEditRoute($prefix_lang, $titleParam));
$delete = $this->CreateLink ($id, "delete", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getDeleteRoute($prefix_lang, $titleParam));
$raw = $this->CreateLink ($id, "raw", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam, 'version_id'=>$vals['version_id']), '', true, false, '', '', RouteMaker::getRawRoute($prefix_lang, $titleParam, $vals['version_id']));
$canonical = $this->CreateLink ($id, "view", $returnid, '', array('wtitle'=>$titleParam, 'wlang'=>$langParam), '', true, false, '', '', RouteMaker::getViewRoute($prefix_lang, $titleParam));


$smarty->assign('version', $vals);
$smarty->assign('title', $titleParam);

$smarty->assign('edit', $edit);
$smarty->assign('delete', $delete);
$smarty->assign('raw', $raw);
$smarty->assign('canonical', $canonical);

echo $this->ProcessTemplate('viewPage.tpl');

?>