{literal}
<script type="text/javascript">
//<![CDATA[

  var timeoutID;
  var label;
  var cnt = 4;
  var fieldPre = '.deletePre';
  var fieldPost = '.deletePost';
  
  $(document).ready(function () {
	  $("input.raw").click(function () { 
			query = "";
			url = '{/literal}{$raw|unescape:"htmlall"}{literal}&showtemplate=false';
		
			$.post( url, query).done(function( data ) {
				$("#raw_result").html(data);
								
				$.fancybox.open( {href : '#raw_result', title : 'Raw Code', autoSize : false});
			});
		});
		
		$('.edit').click(function () { 
			location.href = "{/literal}{$edit}{literal}";
		});
		
		$(fieldPost).click(function () { 
			location.href = "{/literal}{$delete}{literal}";
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
		    cnt=4;
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

<div class='fancybox' id='raw_result'></div>

{*<h3>{$version.title|capitalize}</h3>*}

{capture assign='btns'}
<ul class="button-group radius">
	<li><input class='tiny button raw' type='button' value='Show Raw Code'></li>
	<li><input class='tiny button edit' type='button' value='Edit'{if $version.status!=1} disabled='disabled' title='you can not edit an old version'{/if}></li>
	<li><input class='tiny button deletePre' type='button' value='Delete'{if $version.status!=1} disabled='disabled' title='you can not delete an old version'{/if}></li>
	<li><input class='tiny button deletePost alert' type='button' value='Delete (Are You Sure?)'></li>
	<li><input type='button' class="tiny button" data-dropdown="drop" value='R.{$version.version_id} &raquo;' />
		<ul id="drop" class="small f-dropdown" data-dropdown-content> 
			{foreach $oldvals as $oldval}
				<li><a href="{$oldval.viewUrl}">{if $oldval.version_id==$version.version_id}&raquo; {/if}R.{$oldval.version_id} By <b>{$oldval.author_name}</b> the <b>{$oldval.dt_creation|cms_date_format|utf8_encode}</b></a></li>
			{/foreach}
		</ul></li>
</ul>
{/capture}

{$btns}
<div class='wikiContent'>{$version.text}</div>
{$btns}