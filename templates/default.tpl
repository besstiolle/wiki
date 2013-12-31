<style>
a.new{
	color: #93000C;
}

a.follow{
}
</style>

<h3>{$version.title}</h3>
<div class='wikimeta'>
	Created by <b>{$version.author_name}</b>
	the <b>{$version.dt_creation|cms_date_format|utf8_encode}</b>. 
	<b>v{$version.version_id}</b>
</div>
<div class='wikiContent'>{$version.text}

</div>