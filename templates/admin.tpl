{$form_save}

	<div>
		<label for='{$actionid}prefix'>
			Prefix for URLs : 
			<input type='text' name='{$actionid}prefix' value='{$prefix}' />
		</label>
	</div>
	<div>
		<label for='{$actionid}show_code_iso'>
			Show langs in URL : 
			<input type='radio' name='{$actionid}show_code_iso' value='1' checked='1'>
			 YES : NO
			<input type='radio' name='{$actionid}show_code_iso' value='0' checked='0'>
		</label>
	</div>
	<div>
		<input type='submit' value='save' />
	</div>
</form>

<table class="pagetable">
	<thead>
		<tr>
			<th>Code</th>
			<th>Label</th>
			<th>Actives Pages</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		{foreach $langs lang}
			<tr>
				<td>
					{if $lang.isdefault}<b>{/if}{$lang.code}{if $lang.isdefault}</b>{/if}
				</td>
				<td>
					{if $lang.isdefault}<b>{/if}{$lang.label}{if $lang.isdefault}</b>{/if}
				</td>
				<td>
					{if $lang.isdefault}<b>{/if}{$lang.count}{if $lang.isdefault}</b>{/if}
				</td>
				<td>
					{if $lang.isdefault}
						{$imgs.true}
					{else}
						<a href='{$lang.default}'>{$imgs.false}</a>
					{/if}
				</td>
				<td>
					<a href='{$lang.edit}'>{$imgs.edit}</a>{if !$lang.isdefault}&nbsp;&nbsp;<a href='{$lang.delete}'>{$imgs.delete}</a>{/if}
				</td>
			</tr>
		{foreachelse}
			<tr><td>There is no Lang, it's a problem...</td></tr>
		{/foreach}
	</tbody>
</table>

<div><p>Clic <span onclick='$("#resetme").show();' style='color:#F00;cursor: no-drop;'>here</span> if you really <b>really</b> want to reset the wiki</p>
	<p id='resetme' style='display:none;'><a href='{$reset}' >Reset the entire Wiki (trust me, you certainly don't want to clic on this link...)</a></p>
</div>