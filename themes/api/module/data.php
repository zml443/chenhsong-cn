<?php

$dir = dirname(__FILE__).'/.data/';
file::mkdir($dir,1);

$data = array();
if ($_POST['header']) {
	$data['header'] = array(
		'name' => $_POST['header'],
		'download' => 0,
		'type' => $_POST['type'],
	);
}
if (is_array($_POST['content'])) {
	$data['content'] = array();
	foreach ($_POST['content'] as $k => $v) {
		if (is_array($v) && count($v)>0 && $v[0]) {
			$data['content'][$k] = array();
			foreach ($v as $name) {
				$data['content'][$k][] = array(
					'name' => $name,
					'download' => 0,
					'type' => $_POST['type'],
				);
			}
		}
	}
}
if (!$data['content']) {
	str::msg('需要填写内容编号', 0);
}
if ($_POST['footer']) {
	$data['footer'] = array(
		'name' => $_POST['footer'],
		'download' => 0,
		'type' => $_POST['type'],
	);
}

file_put_contents($dir.'var', str::json($data));

str::msg('数据已保存', 1);