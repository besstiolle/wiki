{literal}
<script type="text/javascript" src="http://localhost/cmsms1.11.x/lib/jquery/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
//<![CDATA[
  $(document).ready(function () {
	  $("input[name='preview']").click(function () { 
			query = "{/literal}{$actionid}{literal}wtitle=" + $("#{/literal}{$actionid}{literal}wtitle").val() + "&" 
				+ "{/literal}{$actionid}{literal}wtext=" + $("#{/literal}{$actionid}{literal}wtext").val();
			
			url = '{/literal}{$preview}{literal}&showtemplate=false';
		
			$.post( url, query).done(function( data ) {
				alert( "Data Loaded: " + data );
			});
		});
	});
// ]]>
</script>
{/literal}

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
		<input type='button' value='Preview' class='sub' name='preview' />
	</div>

	<label for='{$actionid}wtitle' >Title : </label><input type='text' value='{$version.title}' name='{$actionid}wtitle' id='{$actionid}wtitle'/>
	<textarea name='{$actionid}wtext' id='{$actionid}wtext' rows='10' cols='20'>{$version.text}</textarea>

	<div class='wikiaction'>
		<a href='{$cancel}'>Cancel</a>
		<input type='submit' value='Save' class='sub' name='{$actionid}save' />
		<input type='button' value='Preview' class='sub' name='preview' id='preview' />
	</div>
</form>