{literal}
<!-- Add jQuery library -->
<script type="text/javascript" src="{/literal}{root_url}{literal}/modules/Wiki/scripts/jquery/jquery-1.10.1.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="{/literal}{root_url}{literal}/modules/Wiki/scripts/jquery/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="{/literal}{root_url}{literal}/modules/Wiki/scripts/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{/literal}{root_url}{literal}/modules/Wiki/scripts/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
	
<script type="text/javascript">
//<![CDATA[
  $(document).ready(function () {
	  $("input[name='preview']").click(function () { 
			query = "{/literal}{$actionid}{literal}wtitle=" + $("#{/literal}{$actionid}{literal}wtitle").val() + "&" 
				+ "{/literal}{$actionid}{literal}wtext=" + $("#{/literal}{$actionid}{literal}wtext").val() + "&" 
				+ "{/literal}{$actionid}{literal}lang_id=" + $("#{/literal}{$actionid}{literal}lang_id").val();
			
			url = '{/literal}{$preview}{literal}&showtemplate=false';
		
			$.post( url, query).done(function( data ) {
				$("#preview_result").html(data);
				
				$("a.wikilinks").attr("target","_blank");
				
				$.fancybox.open( {href : '#preview_result', title : 'Preview', autoSize : false});
			});
		});
		$( "a" ).click(function( event ) {
			event.preventDefault();
			alert('');
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