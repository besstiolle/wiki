{if !empty($breadcrumbs)}<ul class="breadcrumbs">
{foreach $breadcrumbs as $bread}
	 <li {if $bread@last}class='current'{/if}><a href="{$bread.url}" {if !empty($bread.class)}class='{$bread.class}'{/if} {if !empty($bread.title)}title='{$bread.title}'{/if}>{$bread.name}</a></li>
{/foreach}</ul>
{/if}

<div class="off-canvas-wrap">
<div class="inner-wrap">

<nav class="tab-bar">

	<section class="left-small">
		<a class="left-off-canvas-toggle menu-icon" ><span></span></a>
	</section> 

	<section class="middle tab-bar-section"> 
		
	<ul class="button-group in-off-bar">
			<li><input class='tiny button in-off-bar preview' type='button' value='Preview'></li>
			<li><input class='tiny button in-off-bar cancelPre' type='button' value='Cancel'></li>
			<li><input class='tiny button in-off-bar cancelPost alert' type='button' value='Cancel (Are You Sure?)'></li>
			<li><input class='tiny button in-off-bar save' type='submit' value='Save' name='{$actionid}save' /></li>
		</ul>
			
	</section>
</nav>
<aside class="left-off-canvas-menu">
	<ul class="off-canvas-list">
		<li><label>Menu</label></li>
	
		{foreach $wiki_menu as $elt}
			<li><a href="{$elt.viewUrl}" {if !empty($elt.class)}class='{$elt.class}'{/if}>{$elt.label|capitalize}</a></li>
		{/foreach}
		
		<li><label>Options</label></li>
		<li><a href="#">Some options</a></li>
		<li><a href="#">Other options</a></li>
	</ul>
</aside>


<section class="main-section">

<div class='panel no-margin'>
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
		
		$("input.save").click(function () { 
			$( "#{/literal}{$actionid}{literal}moduleform_1" ).submit();
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

	<div class='fancybox' id='preview_result'></div>

	{$form}
		{if !empty($version.page)}<input type='hidden' name='{$actionid}page_id' id='{$actionid}page_id' value='{$page.page_id}'/>{/if}
		{if !empty($lang.code)}<input type='hidden' name='{$actionid}wlang' id='{$actionid}wlang' value='{$lang.code}'/>{/if}

		<div class="name-field">
			<label>Title : </label>
			<input type='text' value='{$version.title}' disabled="disabled" title="You can't edit the title" />
			<input type='hidden' value='{$version.title}' name='{$actionid}wtitle' id='{$actionid}wtitle' />
			{if $isDefaultPage}<input type='hidden' value='{$version.title}' name='{$actionid}wtitle' id='{$actionid}wtitle' />{/if}
			<small class="error">Title is required.</small>
		</div>
		<div class="name-field">
			<textarea name='{$actionid}wtext' id='{$actionid}wtext' rows='10' cols='20' class='wikiarea' required>{$version.text}</textarea>
			<small class="error">Text is required.</small>
		</div>
		
	</form>
</div>

 </section> <a class="exit-off-canvas"></a> </div> </div>