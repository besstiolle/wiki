<?php
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc

include_once(dirname(__FILE__).'/lib/class.Engines.php');
=======
if (!function_exists('cmsms')) exit;



>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e

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
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc

//Create first undeletable-page
$page = new Page();
$page->set('prefix','');
$page->set('alias','home');
=======
$this->SetPreference('multiInstances',FALSE);

//Create first undeletable-page
$page = new Page();
$page->set('prefix',$this->_getDefaultPrefix());
$page->set('alias', $this->_getDefaultAlias());
$page->set('lvl',0);
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$page = $page->save();

//Create first indeletable-lang
$en_US = new Lang();
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
$en_US->set('code','en_US');
=======
$en_US->set('code',$this->_getDefaultLang());
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
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
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
$version->set('text',htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.txt')));
$version->set('engine',Engines::$MARKDOWN);
=======
$version->set('text',htmlentities(file_get_contents($config['root_path'].'/modules/Wiki/default.md')));
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$version->set('dt_creation',$currentTS);
$version->set('author_name','admin');
$version->set('author_id',0);
$version->set('page',$page->get('page_id'));
$version->set('lang',$en_US->get('lang_id'));
$version->set('status',$version::$STATUS_CURRENT);
$version = $version->save();

<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
// Add some routes
=======
$config = cmsms()->GetConfig();
$content = file_get_contents($config['root_path'].'/modules/Wiki/templates/setAccess.tpl');
$this->SetTemplate('access', $content);

//Refresh Routes
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
$this->CreateStaticRoutes();

?>