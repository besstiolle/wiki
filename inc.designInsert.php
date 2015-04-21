<?php
if (!function_exists('cmsms')) exit;

$uid = null;
if( cmsms()->test_state(CmsApp::STATE_INSTALL) ) {
  $uid = 1; // hardcode to first user
} else {
  $uid = get_userid();
}


$config = cmsms()->GetConfig();
$c_css1 = file_get_contents($config['root_path'].'/modules/Wiki/templates/init/css_normalize');
$c_css2 = file_get_contents($config['root_path'].'/modules/Wiki/templates/init/css_foundation');
$c_css3 = file_get_contents($config['root_path'].'/modules/Wiki/templates/init/css_foundation_icones');
$c_css4 = file_get_contents($config['root_path'].'/modules/Wiki/templates/init/css_wiki');

$c_tpl1 = file_get_contents($config['root_path'].'/modules/Wiki/templates/init/tpl_wiki1col');
$c_tpl2 = file_get_contents($config['root_path'].'/modules/Wiki/templates/init/tpl_wiki2cols');


try {

  //Using core::page type
  $wiki_type = CmsLayoutTemplateType::load("Core::page");

  try{
    $tpl1 = CmsLayoutTemplate::load('Wiki Sample 1 col');
    echo "<p>Template ".$tpl1->get_name()." already exists</p>";
  } catch(CmsDataNotFoundException $notfound){
    // CREATE TEMPLATE 1 COL
    $tpl1 = new CmsLayoutTemplate();
    $tpl1->set_name('Wiki Sample 1 col');
    $tpl1->set_owner($uid);
    $tpl1->set_content($c_tpl1);
    $tpl1->set_type($wiki_type);
    $tpl1->set_type_dflt(FALSE);
    echo "<p>Saving ".$tpl1->get_name()."</p>";
    $tpl1->save();
    echo "<p>".$tpl1->get_name()." saved with success</p>";
  }

  try{
    $tpl2 = CmsLayoutTemplate::load('Wiki Sample 2 cols');
    echo "<p>Template ".$tpl2->get_name()." already exists</p>";
  } catch(CmsDataNotFoundException $notfound){
    // CREATE TEMPLATE 2 ROL
    $tpl2 = new CmsLayoutTemplate();
    $tpl2->set_name('Wiki Sample 2 cols');
    $tpl2->set_owner($uid);
    $tpl2->set_content($c_tpl2);
    $tpl2->set_type($wiki_type);
    $tpl2->set_type_dflt(FALSE);
    echo "<p>Saving ".$tpl2->get_name()."</p>";
    $tpl2->save();
    echo "<p>".$tpl2->get_name()." saved with success</p>";
  }

  // CREATE OR UPDATE CSS
  try{
    $css1 = CmsLayoutStylesheet::load('Wiki_Normalize');
  } catch(CmsDataNotFoundException $notfound){
    $css1 = new CmsLayoutStylesheet();
  }
  
  $css1->set_name('Wiki_Normalize');
  $css1->set_content($c_css1);
  $css1->set_description("CSS for the Normalize's base design v3.0.2");
  echo "<p>Saving ".$css1->get_name()."</p>";
  $css1->save();
  echo "<p>".$css1->get_name()." saved with success</p>";

  try{
    $css2 = CmsLayoutStylesheet::load('Wiki_Foundation');
  } catch(CmsDataNotFoundException $notfound){
    $css2 = new CmsLayoutStylesheet();
  }

  $css2->set_name('Wiki_Foundation');
  $css2->set_content($c_css2);
  $css2->set_description("CSS for the foundation's base design v5.5.1");
  echo "<p>Saving ".$css2->get_name()."</p>";
  $css2->save();
  echo "<p>".$css2->get_name()." saved with success</p>";

  try{
    $css3 = CmsLayoutStylesheet::load('Wiki_Foundation_icones');
  } catch(CmsDataNotFoundException $notfound){
    $css3 = new CmsLayoutStylesheet();
  }

  $css3->set_name('Wiki_Foundation_icones');
  $css3->set_content($c_css3);
  $css3->set_description("CSS for the foundation's icones design v3.0");
  echo "<p>Saving ".$css3->get_name()."</p>";
  $css3->save();
  echo "<p>".$css3->get_name()." saved with success</p>";

  try{
    $css4 = CmsLayoutStylesheet::load('Wiki_Main');
  } catch(CmsDataNotFoundException $notfound){
    $css4 = new CmsLayoutStylesheet();
  }
  $css4->set_name('Wiki_Main');
  $css4->set_content($c_css4);
  $css4->set_description("CSS for the wiki v1.0.0 . Extends the foundations's base design");
  echo "<p>Saving ".$css4->get_name()."</p>";
  $css4->save();
  echo "<p>".$css4->get_name()." saved with success</p>";


  // CREATE DESIGN
  try{
    $design = CmsLayoutCollection::load('Wiki Design With Foundation');
  } catch(CmsDataNotFoundException $notfound){
    $design = new CmsLayoutCollection();
  }

  $design->set_name("Wiki Design With Foundation");
  $design->set_description("Foundation Design needed by the wiki to work. It will include CSS and JS for foundation 5.5.1");
  $design->set_templates(array(
  			$tpl1->get_id(),
  			$tpl2->get_id(),
  			));
  $design->set_stylesheets(array(
  			$css1->get_id(),
  			$css2->get_id(),
        $css3->get_id(),
  			$css4->get_id(),
  			));
  $design->save();

}
catch( CmsException $e ) {
  audit('',$this->GetName(),' Installation Error: '.$e->GetMessage());
  echo $this->GetName(),' Installation Error: '.$e->GetMessage();
  die();
}

?>