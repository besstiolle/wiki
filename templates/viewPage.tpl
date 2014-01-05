{literal}
<script type="text/javascript">
//<![CDATA[
  $(document).ready(function () {
	  $("input.raw").click(function () { 
			query = "";
			
			url = '{/literal}{$raw|unescape:"htmlall"}{literal}&showtemplate=false';
		
			$.post( url, query).done(function( data ) {
				$("#raw_result").html(data);
								
				$.fancybox.open( {href : '#raw_result', title : 'Raw Code', autoSize : false});
			});
		});
	});
// ]]>
</script>
{/literal}

<div class='fancybox' id='raw_result'></div>

<div class='wikiaction'>
	<a class='small button' href='{$edit}'>Edit</a>
	<a class='small button' href='{$delete}'>Delete</a>
	<input class='small button raw' type='button' value='Show Raw Code'>
</div>

{*<h3>{$version.title|capitalize}</h3>*}

<div class='wikimeta'>
	Created by <b>{$version.author_name}</b>
	the <b>{$version.dt_creation|cms_date_format|utf8_encode}</b>. 
	<b>v{$version.version_id}</b>
</div>
<div class='wikiContent'>{$version.text}</div>

<div class='wikiaction'>
	<a class='small button' href='{$edit}'>Edit</a>
	<a class='small button' href='{$delete}'>Delete</a>
	<input class='small button raw' type='button' value='Show Raw Code'>
</div>