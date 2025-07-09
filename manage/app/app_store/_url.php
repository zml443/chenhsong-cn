<?php
function_exists('c')||exit();
if (!p('app.app_store.edit')) {
	exit(str::json(array(
		'msg' => language('{/notes.no_permit/}'),
		'ret' => 5001
	)));
}

$use = a('__use__');
$key = $_POST['key'];

if ($use[$key]) {
	exit(str::json(array(
		'url' => c('manage.permit.allurl.'.$use[$key]['key'].'._'),
		'ret' => 1,
	)));
} else {
	exit(str::json(array(
		'ret' => 0
	)));
}