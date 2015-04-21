{if !empty($breadcrumbs)}<ul class="breadcrumbs">
{foreach $breadcrumbs as $bread}
	 <li {if $bread@last}class='current'{/if}><a href="{$bread.url}" {if !empty($bread.class)}class='{$bread.class}'{/if} {if !empty($bread.title)}title='{$bread.title}'{/if}>{$bread.name}</a></li>
{/foreach}</ul>
{/if}

<div class="off-canvas-wrap" data-offcanvas>
<div class="inner-wrap">

<nav class="tab-bar">

{*	<section class="left-small">
		<a class="left-off-canvas-toggle menu-icon" ><span></span></a>
	</section> *}

	<section class="middle tab-bar-section"> 
		
	<ul class="button-group in-off-bar">
			<li><input class='tiny button in-off-bar preview' type='button' value='Preview'></li>
			<li><input class='tiny button in-off-bar cancelPre' type='button' value='Cancel'></li>
			<li><input class='tiny button in-off-bar cancelPost alert' type='button' value='Cancel (Are You Sure?)'></li>
			<li><input class='tiny button in-off-bar save' type='submit' value='Save' name='{$wiki_action_id}save' /></li>
		</ul>
			
	</section>
</nav>

{*
<aside class="left-off-canvas-menu">
	<ul class="off-canvas-list">
		<li><label>Menu</label></li>
	
		{foreach $wiki_menu as $elt}
			<li><a href="{$elt.viewUrl}" {if !empty($elt.class)}class='{$elt.class}'{/if}>{$elt.label|capitalize}</a></li>
		{/foreach}
		
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		{*
		<li><label>Options</label></li>
		<li><a href="#">Some options</a></li>
		<li><a href="#">Other options</a></li>
		*}
=======
		
		<li><label>Options</label></li>
		<li><a href="#">Some options</a></li>
		<li><a href="#">Other options</a></li>
		
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
	</ul>
</aside>*}


<section class="main-section">

<div class='panel no-margin'>

	<div class='fancybox' id='preview_result'></div>

	{$form}
<<<<<<< 4b92f3e5512b80b22b72f1ccd054456cfc6addcc
		{*{if !empty($page)}<input type='hidden' name='{$actionid}page_id' id='{$actionid}page_id' value='{$page.page_id}'/>{/if}
		{if !empty($lang.code)}<input type='hidden' name='{$actionid}vlang' id='{$actionid}vlang' value='{$lang.code}'/>{/if}*}

		<div class="name-field">
			<label>Title : </label>
			<input type='text' value='{$version.title}' name='{$actionid}vtitle' id='{$actionid}vtitle' />
		</div>
		<div class="name-field">
			<textarea name='{$actionid}vtext' id='{$actionid}vtext' rows='10' cols='20' class='wikiarea' required>{$version.text}</textarea>
=======
	
		<div class="name-field">
			<label>Title : </label>
			<input type='text' value='{$version.title}' name='{$wiki_action_id}vtitle' id='{$wiki_action_id}vtitle' />
		</div>
		<div class="name-field">
			<textarea name='{$wiki_action_id}vtext' id='{$wiki_action_id}vtext' rows='10' cols='20' class='wikiarea' required>{$version.text}</textarea>
>>>>>>> 4b4a4edfddda6e68495bfc89ce95a31e5ac0de0e
		</div>
		
	</form>
</div>

 </section> <a class="exit-off-canvas"></a> </div> </div>