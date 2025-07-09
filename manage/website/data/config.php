<?php
isset($c) || exit;

$_GET['_inline_view_'] = 1;

$id = (int)$_POST['id'];
if ($id) {
	$config = saas::config(array(
		'id' => $id,
	));
} else {
	$type = $_POST['type']?:'index';
	$config = saas::config(array(
		'type' => $type,
	));
}
exit(str::json($config));