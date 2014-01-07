{literal}
<script type="text/javascript">
//<![CDATA[

  var timeoutID;
  var label;
  var cnt = 1;
  var fieldPre = '.cancelPre';
  var fieldPost = '.cancelPost';
  
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
		
		$(fieldPost).click(function () { 
			location.href = "{/literal}{$cancel}{literal}";
		});
		
		$(fieldPost).hide();	
		//All but fieldPre
		$(document).bind('click', function (e) {
		    window.clearTimeout(timeoutID);
			$(fieldPre).show();
			$(fieldPost).hide();
			$(fieldPost).attr('disabled','disabled');
			if(label==null){
			    label = $(fieldPost).val();
			}
			$(fieldPost).val(label);
		    cnt=1;
		});

		$(fieldPre).bind('click', function(e) {
			e.stopPropagation();
			$(fieldPre).hide();
			$(fieldPost).show().attr('disabled','disabled');
			count(fieldPost);
			
		});
	});
	
	
	function count(fieldId) {
	  if(label==null){
		label = $(fieldId).val();
	  }
	  if(cnt <= 0){
		  $(fieldId).val(label);
		  $(fieldId).removeAttr('disabled');
	  } else {
		  $(fieldId).val(label + " " + (cnt) + "s");
		  cnt--;
		  timeoutID = window.setTimeout(function() {count(fieldId);}, 1000);
	  }
	}

// ]]>
</script>
{/literal}

{if !empty($errors)}
{foreach $errors as $error}{if !empty($error)}
<div data-alert class="alert-box warning radius">
  {$mod->Lang($error)}
  <a href="#" class="close">&times;</a>
</div>{/if}{/foreach}
{/if}

<div class='fancybox' id='preview_result'></div>

{$form}
	{if !empty($version.page_id)}<input type='hidden' name='{$actionid}page_id' id='{$actionid}page_id' value='{$version.page_id}'/>{/if}
	{if !empty($version.lang_id)}<input type='hidden' name='{$actionid}lang_id' id='{$actionid}lang_id' value='{$version.lang_id}'/>{/if}

	{if !empty($version.page_id)}
		<h2>Edit the Page <b>{$version.title}</b></h2>
	{else}
		<h2>Create a the new Page <b>{$version.title}</b></h2>
	{/if}
	
	{capture assign='btns'}
	<ul class="button-group radius">
		<li><input class='tiny button preview' type='button' value='Preview'></li>
		<li><input class='tiny button cancelPre' type='button' value='Cancel'></li>
		<li><input class='tiny button cancelPost alert' type='button' value='Cancel (Are You Sure?)'></li>
		<li><input class='tiny button save' type='submit' value='Save' name='{$actionid}save' /></li>
	</ul>
	{/capture}
	
	{$btns}
	<div class="name-field">
		<label for='{$actionid}wtitle' >Title : </label><input type='text' value='{$version.title}' name='{$actionid}wtitle' id='{$actionid}wtitle' required/>
		<small class="error">Title is required.</small>
	</div>
	<div class="name-field">
		<textarea name='{$actionid}wtext' id='{$actionid}wtext' rows='10' cols='20' class='wikiarea' required>{$version.text}</textarea>
		<small class="error">Text is required.</small>
	</div>
	{$btns}
	
</form>