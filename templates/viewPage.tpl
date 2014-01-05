<div class='wikiaction'>
	<a class='small button' href='{$edit}'>Edit</a>
	<a class='small button' href='{$delete}'>Delete</a>
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
</div>