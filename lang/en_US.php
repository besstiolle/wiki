<?php
$lang['friendlyname'] = 'Simple Wiki';
$lang['postinstall'] = '';
$lang['postuninstall'] = 'Module Wiki uninstalled, bye !"';
$lang['really_uninstall'] = 'Really? Are you sure you want to uninstall this fine module?';
$lang['uninstalled'] = 'Module Wiki Uninstalled.';
$lang['installed'] = 'Module Wiki version %s installed.';
$lang['reseted'] = 'Module Wiki version %s reseted with success ';
$lang['moddescription'] = 'This module is a simple implementation of a WIKI into CmsMadeSimple';
$lang['changelog'] = 'see changelog : <a href="https://github.com/besstiolle/wiki-ms" target="_blank">https://github.com/besstiolle/wiki-ms</a>';

$lang['lang_id_mandatory'] = 'the lang_id parameter is missing';
$lang['lang_mandatory'] = 'The lang is missing or unknown';
$lang['title_mandatory'] = 'The title is mandatory';
$lang['text_mandatory'] = 'The text is mandatory';
$lang['default_page_with_new_title'] = 'You can\'t change the title of the default page';
$lang['default_version_undeletable'] = 'You can\'t delete the default page';
$lang['title_format'] = 'Title is required and must be an alphanumerique string (symbols "-_:" are accepted too).';
$lang['version_unknow'] = 'The current page is not know. Maybe it\'s already deleted ?';
$lang['revision_unknow'] = 'The version %s of the page is not known.';


$lang['save_success'] = 'Page saved with success.';
$lang['delete_success'] = 'Page deleted with success.';
$lang['dupplicate_code'] = 'Another Lang already exists with this code';
$lang['code_is_mandatory'] = 'The code is mandatory';
$lang['label_is_mandatory'] = 'The label is mandatory';
$lang['prefix_mandatory'] = 'The prefix is mandatory';
$lang['alias_mandatory'] = 'The alias is mandatory';


$lang['wiki_not_readable'] = 'You cannot read this wiki';
$lang['wiki_not_writable'] = 'You cannot modify the pages of this wiki';
$lang['wiki_not_deletable'] = 'You cannot delete the pages of this wiki';
$lang['wiki_page_not_exists'] = 'This page doesn\'t exists and you don\'t have the right to create it.';

$lang['help_is_readable'] = 'Set to TRUE if you want that the wiki  can be readable';
$lang['help_is_writable'] = 'Set to TRUE if you want that the pages of the wiki can be writable (creating new page, editing existing page)';
$lang['help_is_deletable'] = 'Set to TRUE if you want that the pages of the wiki can be readable';
$lang['help_author_name'] = 'Set to the name (username, login, whatever) of the current user. Will be stored into the database for every modifications';
$lang['help_author_id'] = 'Set to the ID (integer) of the current user. Will be stored into the database for every modifications';


$lang['type_Wiki'] = 'Wiki';
$lang['type_Page'] = 'Page';

$lang['help'] = '<h3>What Does This Do?</h3>
<p>more informations on : <a href="https://github.com/besstiolle/wiki-ms" target="_blank">https://github.com/besstiolle/wiki-ms</a></p>
<h3>How use it</h3>
<h4>Step 1 : Install it</h4>
<p>Just install it ! it will works immediatly for the page /wiki. you don\'t have to create a page for it. You can customize the options in the admin pale.</p>
<p>in the case where you would have a cmsms page called "wiki" you should change the prefix of this module in the options.</p>
<h4>Access Template</h4>
<p>To customize the access you can modify the options in the admin panel. Into the access template you can add/customize the tag {Wiki action="setAccess"} to set the authorization. There is some options : </p>
<ul>
<li>is_readable (TRUE by default)</li>
<li>is_writable (FALSE by default)</li>
<li>is_deletable (FALSE by default)</li>
<li>author_name (empty by default)</li>
<li>author_id (empty by default)</li>
</ul>
<p>If you don\'t touch anything you will have a readonly wiki</p>
<p>For example : </p>
<pre>
{Wiki action="setAccess" is_readable="TRUE" is_writable="TRUE" is_deletable="FALSE"}
</pre>

<p>You can easily test the current FEU user/group to allow or deny access to the wiki</p>
<pre>
{if $ccuser->loggedin()}
  {Wiki action="setAccess" is_readable="TRUE" is_writable="TRUE" is_deletable="FALSE" author_name=$ccuser->username() author_id=$ccuser->loggedin() }<br/>
{else}
  {Wiki action="setAccess" is_readable="TRUE"}
{/if}
</pre>

<p>finally you can customize your own test with a custom UDT or with another module and the array {$gatewayParams}.For example : </p>
<pre>
{MyModule action="myCustomAction" wiki_prefix=$gatewayParams.pprefix}{* will set result into $myCustomResult *}

{if $myCustomResult}
  {Wiki action="setAccess" is_readable=TRUE is_writable=TRUE is_deletable=TRUE}
{else}
  {Wiki action="setAccess" is_readable=TRUE}
{/if}
</pre>
<p>the array {$gatewayParams} is always available and contains the current $params values of the wiki</p>

<p style="color:#F00;">! Remember, don\'t use this action into your own template or the settings won\'t be actives all the time ! </p>
<h4>{Wiki action="doesPageExists"}</h4>
<p>add the tag {Wiki action="doesPageExists"} in your template and you will know ... if a page exists (it does not test old page deleted). You can test the result like this</p>
<pre>
{Wiki action="doesPageExists" pprefix="wiki" palias="home" vlang="en_US"}
[...]
{if $doesPageExists}yes{/if}
</pre>
<p>there is 3 possible parameters</p>
<ul>
<li>pprefix </li>
<li>palias (optionnal, will use the default alias of the wiki if not defined)</li>
<li>vlang (optionnal, will use the default lang code of the wiki if not defined)</li>
</ul>
</h4>
';
$lang['xxx'] = 'xxx';


?>
