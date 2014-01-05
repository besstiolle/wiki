{literal}
<script type="text/javascript">
//<![CDATA[
  $(document).ready(function () {
	  $("input.preview").click(function () { 
			query = "{/literal}{$actionid}{literal}wtitle=" + escape($("#{/literal}{$actionid}{literal}wtitle").val()) + "&" 
				+ "{/literal}{$actionid}{literal}wtext=" + escape($("#{/literal}{$actionid}{literal}wtext").val()) + "&" 
				+ "{/literal}{$actionid}{literal}lang_id=" + $("#{/literal}{$actionid}{literal}lang_id").val();
			
			url = '{/literal}{$preview|unescape:"htmlall"}{literal}&showtemplate=false';
		
			$.post( url, query).done(function( data ) {
				$("#preview_result").html(data);
				
				$("a.wikilinks").attr("target","_blank");
				
				$.fancybox.open( {href : '#preview_result', title : 'Preview', autoSize : false});
			});
		});
	});
// ]]>
</script>
{/literal}

<div class='fancybox' id='preview_result'></div>

{$form}
	{if !empty($version.page_id)}<input type='hidden' name='{$actionid}page_id' id='{$actionid}page_id' value='{$version.page_id}'/>{/if}
	{if !empty($version.lang_id)}<input type='hidden' name='{$actionid}lang_id' id='{$actionid}lang_id' value='{$version.lang_id}'/>{/if}

	{if !empty($version.page_id)}
		<h2>Edit the Page <b>{$version.title}</b></h2>
	{else}
		<h2>Create a the new Page <b>{$version.title}</b></h2>
	{/if}
	<div class='wikiaction'>
		<a class='small button' href='{$cancel}'>Cancel</a>
		<input class='small button' type='submit' value='Save' name='{$actionid}save' />
		<input class='small button preview' type='button' value='Preview'>
	</div>

	<label for='{$actionid}wtitle' >Title : </label><input type='text' value='{$version.title}' name='{$actionid}wtitle' id='{$actionid}wtitle'/>
	<textarea name='{$actionid}wtext' id='{$actionid}wtext' rows='10' cols='20' class='wikiarea'>{$version.text}</textarea>

	<div class='wikiaction'>
		<a class='small button' href='{$cancel}'>Cancel</a>
		<input class='small button' type='submit' value='Save' name='{$actionid}save' />
		<input class='small button preview' type='button' value='Preview'>
	</div>
</form>