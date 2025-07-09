<?php

function_exists('c')||exit;

if (strstr($_POST['color'],'ffffff') || strstr(str_replace(' ','',$_POST['color']),'255,255,255')) {
	exit(str::json(array(
		'msg' => language('{/notes.fail/}'),
		'ret' => 0
	)));
}

$old_color = g('website.mainColor');

g('website.mainColor', $_POST['color']);

log::manage('website_main_color', '主题色切换：'.$old_color.'->'.$_POST['color']);

exit(str::json(array(
	'msg' => language('{/notes.ok/}'),
	'ret' => 1
)));