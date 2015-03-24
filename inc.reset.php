<?php

include_once(dirname(__FILE__).'/lib/class.Engines.php');

//Create all the tables automatically 
$entities = MyAutoload::getAllInstances($this->GetName());
foreach($entities as $anEntity) {
	OrmCore::dropTable($anEntity);
	OrmCore::createTable($anEntity);
}

list($currentUS, $currentTS) = explode(" ", microtime());
$config = cmsms()->GetConfig();

$this->SetPreference('prefix','wiki');
$this->SetPreference('default_alias','home');
$this->SetPreference('default_lang','en_US');
$this->SetPreference('show_code_iso',TRUE);

//Create first undeletable-page
$page = new Page();
$page->set('prefix','');
$page->set('alias','home');
$page = $page->save();

//Create first indeletable-lang
$en_US = new Lang();
$en_US->set('code','en_US');
$en_US->set('label','English');
$en_US->set('isdefault',1);
$en_US = $en_US->save();
//Create second lang
$fr_FR = new Lang();
$fr_FR->set('code','fr_FR');
$fr_FR->set('label','Français');
$fr_FR = $fr_FR->save();

// Create first version of text
$version = new Version();
$version->set('title',$page->get('alias'));
$version->set('text',htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.txt')));
$version->set('engine',Engines::$MARKDOWN);
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page',$page->get('page_id'));
$version->set('lang',$en_US->get('lang_id'));
$version->set('status',$version::$STATUS_CURRENT);
$version = $version->save();

// Add some routes
$this->CreateStaticRoutes();

?>