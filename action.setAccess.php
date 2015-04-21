<?php
if (!function_exists('cmsms')) exit;


$is_readable = true;
$is_writable = false;
$is_deletable = false;
$author_name = null;
$author_id = null;

if(isset($params['is_readable'])) {
	$is_readable = $params['is_readable'];
}
if(isset($params['is_writable'])) {
	$is_writable = $params['is_writable'];
}
if(isset($params['is_deletable'])) {
	$is_deletable = $params['is_deletable'];
}
if(isset($params['author_name'])) {
	$author_name = $params['author_name'];
}
if(isset($params['author_id'])) {
	$author_id = $params['author_id'];
}

$smarty->assign('wiki_access', array(
					"is_readable" => $is_readable,
					"is_writable" => $is_writable,
					"is_deletable" => $is_deletable,
					"author_name" => $author_name,
					"author_id" => $author_id,
						));

Authentification::setStatus($is_readable, $is_writable, $is_deletable, $author_name, $author_id);

?>