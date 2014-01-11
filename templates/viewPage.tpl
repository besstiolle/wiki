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
		<li><input class='tiny button in-off-bar raw' type='button' value='Show Raw Code'></li>
		<li><input class='tiny button in-off-bar edit' type='button' value='Edit'{if $version.status!=1} disabled='disabled' title='you can not edit an old version'{/if}></li>
		<li><input class='tiny button in-off-bar deletePre' type='button' value='Delete'{if $version.status!=1} disabled='disabled' title='you can not delete an old version'{elseif $isDefaultPage} disabled='disabled' title='you can not delete the default page'{/if}></li>
		<li><input class='tiny button in-off-bar deletePost alert' type='button' value='Delete (Are You Sure?)'></li>
	</ul>
			
	</section>
	
	<section class="right-small">
		<a class="right-off-canvas-toggle menu-icon" ><span></span></a>
	</section>
</nav>
<aside class="left-off-canvas-menu">
	<ul class="off-canvas-list">
		<li><label>Menu</label></li>
		<li><a href="#">Home</a></li>
		<li><a href="#">A Page</a></li>
		<li><a href="#">Another page</a></li>
		<li><a href="#" class='new'>A no-existing page</a></li>
		<li><a href="#">Ho ! another one with a very long entry</a></li>
		<li><label>Options</label></li>
		<li><a href="#">Some options</a></li>
		<li><a href="#">Other options</a></li>
	</ul>
</aside>
<aside class="right-off-canvas-menu">
	<ul class="off-canvas-list">
		<li><label>Lang</label></li>
			<li><a href="#">en_US</a></li>
			<li><a href="#" class='new'>de_DE</a></li>
			<li><a href="#">fr_FR</a></li>
		<li><label>Revisions</label></li>
		{foreach $oldvals as $oldval}
			<li><a href="{$oldval.viewUrl}">{if $oldval.version_id==$version.version_id}&raquo; {/if}The <b>{$oldval.dt_creation|cms_date_format|utf8_encode}</b> by <b>{$oldval.author_name}</b> </a></li>
		{/foreach} 
	</ul>
</aside> 


<section class="main-section">

<div class='panel no-margin'>

	<dl class="sub-nav">
		<dt>Sub page:</dt>
		<dd{* class="active"*}><a href="#">First</a></dd>
		<dd><a href="#">Second</a></dd>
		<dd><a href="#">Third</a></dd>
		<dd><a href="#">Suspended</a></dd>
		<dd><a href="#">Active</a></dd>
		<dd><a href="#">Pending</a></dd>
		<dd><a href="#">Suspended</a></dd>
		<dd><a href="#">Active</a></dd>
		<dd><a href="#">Pending</a></dd>
		<dd><a href="#">Suspended</a></dd>
		<dd><a href="#">Active</a></dd>
		<dd><a href="#">Pending</a></dd>
		<dd><a href="#">Suspended</a></dd>
	</dl>

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
	<div class='wikiContent'>{$version.text}</div>

</div>




 </section> <a class="exit-off-canvas"></a> </div> </div>