{$form}
{if !empty($version.page_id)}<input type='hidden' name='{$actionid}page_id' id='{$actionid}page_id' value='{$version.page_id}'/>{/if}
{if !empty($version.lang_id)}<input type='hidden' name='{$actionid}lang_id' id='{$actionid}lang_id' value='{$version.lang_id}'/>{/if}

{if !empty($version.page_id)}
	<h2>Edit the Page <b>{$version.title}</b></h2>
{else}
	<h2>Create a the new Page <b>{$version.title}</b></h2>
{/if}
<div class='wikiaction'>
	<a href='{$cancel}'>Cancel</a>
	<input type='submit' value='Save' class='sub' name='{$actionid}save' />
</div>
<label for='{$actionid}title' >Title : </label><input type='text' value='{$version.title}' name='{$actionid}title' id='{$actionid}title'/>
<label for='{$actionid}text'><textarea name='{$actionid}text' id='{$actionid}text'>{$version.text}</textarea>
<div class='wikiaction'>
	<a href='{$cancel}'>Cancel</a>
	<input type='submit' value='Save' class='sub' name='{$actionid}save' />
</div>
</form>