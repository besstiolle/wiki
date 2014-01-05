<?php

if (!function_exists("cmsms")) exit;

include_once(dirname(__FILE__).'/lib/class.Motors.php');

//Create all the tables automatically 
$entities = MyAutoload::getAllInstances($this->GetName());
foreach($entities as $anEntity) {
	OrmCore::dropTable($anEntity);
	OrmCore::createTable($anEntity);
}

list($currentUS, $currentTS) = explode(" ", microtime());
$config = cmsms()->GetConfig();

$this->SetPreference('prefix','wiki');
$this->SetPreference('show_prefix_lang',TRUE);

//Create first undeletable-page
$page = new Page();
$page->set('prefix','');
$page->set('title','home');
$page = $page->save();

//Create first indeletable-lang
$lang = new Lang();
$lang->set('prefix','en_US');
$lang->set('label','en_US');
$lang->set('page_id',$page->get($page->getPk()->getName()));
$lang = $lang->save();

// Create first version of text
$version = new Version();
$version->set('title',$page->get('title'));
$version->set('text',htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.txt')));
$version->set('motor',Motors::$MARKDOWN);
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page_id',$page->get($page->getPk()->getName()));
$version->set('lang_id',$lang->get($lang->getPk()->getName()));
$version->set('status',$version::$STATUS_CURRENT);
$version = $version->save();

// Add some routes
$this->CreateStaticRoutes();

// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );
?>
