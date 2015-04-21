
{form_start action="admin_lang_save" extraparms=['lang_id' => $lang->get('lang_id')]}
<h3>{$title}</h3>
<input type='text' name='{$actionid}code' value='{$lang->get('code')}' placeholder="ISO Code"/>
<input type='text' name='{$actionid}label' value='{$lang->get('label')}' placeholder="Label"/>
<input type='submit' value='save' />
</form>