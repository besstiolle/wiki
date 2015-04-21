{if !empty($breadcrumbs)}<ul class="breadcrumbs">
{foreach $breadcrumbs as $bread}
	 <li {if $bread@last}class='current'{/if}><a href="{$bread.url}" {if !empty($bread.class)}class='{$bread.class}'{/if} {if !empty($bread.title)}title='{$bread.title}'{/if}>{$bread.name}</a></li>
{/foreach}</ul>
{/if}

<div class="off-canvas-wrap" data-offcanvas>
<div class="inner-wrap">

<nav class="tab-bar">

	<section class="left-small">
		<a class="left-off-canvas-toggle menu-icon" ><span></span></a>
	</section> 

	<section class="middle tab-bar-section"> 
		
		
	<div class="right">
	{if $version.status!=1}
		<span data-tooltip aria-haspopup="true" class="has-tip" title="The page is an old version. See the last version of this page">
			<i class="fi-clock ico-bar ico-warning goLast"></i></span>
	{elseif !$isUpToDate}
		<span data-tooltip aria-haspopup="true" class="has-tip" title="The page is a translation and may be outdated. See the original here">
			<i class="fi-comments ico-bar ico-alert goLastDefaultLang"></i></span>
	{elseif !$isDefaultLang}
		<span data-tooltip aria-haspopup="true" class="has-tip" title="The page is a translation. See the original here.">
			<i class="fi-comment ico-bar ico-success goLastDefaultLang"></i></span>
	{else}
		<span data-tooltip aria-haspopup="true" class="has-tip" title="You're looking the last version.">
			<i class="fi-check ico-bar ico-success"></i></span>
	{/if}
		<span data-tooltip aria-haspopup="true" class="has-tip" title="Go back home">
			<a href='{$root_wiki_url}'><i class="fi-home ico-bar ico-secondary"></i></a></span>
		<span data-tooltip aria-haspopup="true" class="has-tip" title="See the sitemap of the wiki.">
			<a href='{$root_wiki_url}/sitemap'><i class="fi-map ico-bar ico-secondary"></i></a></span>
		
	</div>
<!-- 	.fi-results
	.fi-thumbnails
	.fi-map
	.fi-list-bullet
	.fi-foundation

	.fi-arrows-in
	.fi-arrows-out -->

	<ul class="button-group in-off-bar">
		<li><input class='tiny button in-off-bar raw' type='button' value='Show Raw Code'></li>
		{if $wiki_access.is_writable}
		<li><input class='tiny button in-off-bar edit' type='button' value='Edit'{if $version.status!=1} disabled='disabled' title='you can not edit an old version'{/if}></li>
		{/if}
		{if $wiki_access.is_deletable}
		<li><input class='tiny button in-off-bar deletePre' type='button' value='Delete'{if $version.status!=1} disabled='disabled' title='you can not delete an old version'{elseif $isDefaultPage} disabled='disabled' title='you can not delete the default page'{/if}></li>
		<li><input class='tiny button in-off-bar deletePost alert' type='button' value='Delete (Are You Sure?)'></li>
		{/if}
	</ul>	

	</section>


	
	<section class="right-small">
		<a class="right-off-canvas-toggle menu-icon" ><span></span></a>
	</section>
</nav>
<aside class="left-off-canvas-menu">
	<ul class="off-canvas-list">
		<li><label>Menu</label></li>
	
		{foreach $wiki_menu as $elt}
			<li><a href="{$elt.viewUrl}" {if !empty($elt.class)}class='{$elt.class}'{/if}>{$elt.label|capitalize}</a></li>
		{foreachelse}
			<li>There is no entry in this wiki</li>
		{/foreach}
		<li><label>Siblings Entries</label></li>
	
		{foreach $wiki_menu_siblings as $elt}
			<li><a href="{$elt.viewUrl}" {if !empty($elt.class)}class='{$elt.class}'{/if}>{$elt.label|capitalize}</a></li>
		{foreachelse}
			{*<li>There is no siblings entry in this wiki</li>*}
		{/foreach}
	</ul>
</aside>
<aside class="right-off-canvas-menu">
	<ul class="off-canvas-list">
{if $showLangs}
		<li><label>Lang</label></li>
		
		{foreach $other_langs as $elt}
			<li><a href="{$elt.viewUrl}" {if !empty($elt.class)}class='{$elt.class}'{/if}>{$elt.label|capitalize}</a></li>
		{/foreach}
{/if}		
		<li><label>Revisions</label></li>
		
		{foreach $oldRevisions as $elt}
			<li class='small'><a href="{$elt.viewUrl}">{if $elt.version_id==$version.version_id}&raquo; {/if}The <b>{$elt.dt_creation|cms_date_format|utf8_encode}</b> by <b>{$elt.author_name}</b> </a></li>
		{/foreach} 
		
	</ul>
</aside> 



<section class="main-section">

<div class='panel no-margin h500'>
	{if !empty($sub_entries)}
	<dl class="sub-nav">
		<dt>Sub page:</dt>
		
		{foreach $sub_entries as $elt}
			<dd><a href="{$elt.viewUrl}" {if !empty($elt.class)}class='{$elt.class}'{/if}>{$elt.label|capitalize}</a></dd>
		{/foreach}
	</dl>
	{/if}

	{if !empty($errors)}
	{foreach $errors as $error}{if !empty($error)}
	<div data-alert class="alert-box warning radius">
	  {$mod->Lang($error)}
	  <a href="#" class="close">&times;</a>
	</div>{/if}{/foreach}
	{/if}

	<div class='fancybox' id='raw_result'></div>
	<div class='wikiContent'>{$version.text}</div>
	<div><small>
		Last edition 
			{if !empty($version.author_name)}by <b><span title="{if !empty($version.author_id)}#{$version.author_id} : {/if}{$version.author_name}">{$version.author_name}</span></b>{/if}
			the <b>{$version.dt_creation|cms_date_format}</b>
		</small></div>

</div>




 </section> <a class="exit-off-canvas"></a> </div> </div>
