<?php

isset($c) || exit();

$data = array(
	'Name' => $_POST['Name'],
	'Email' => $_POST['Email'],
	'Phone' => $_POST['Phone'],
	'Company' => $_POST['Company'],
	'Job' => $_POST['Job'],
	'Message' => $_POST['Message'],
	'wb_products_id' => $_POST['wb_products_id'],
	'AddTime' => c('time'),
	'Ip' => ip::get(),
);

// 保存图片
if ($_FILES['Files']) {
	$pictures = array();
	$save_dir = c('u_file_dir') . strtolower(c('website.name')) . date('/Y-m/d/');
	foreach ($_FILES['Files']['tmp_name'] as $k => $v) {
		if ($v) {
			$files = array(
				'tmp_name' => $v,
				'name' => $_FILES['Files']['name'][$k],
				'type' => $_FILES['Files']['type'][$k],
				'size' => $_FILES['Files']['size'][$k],
				'error' => $_FILES['Files']['error'][$k]
			);
			$filename = file::upload($files, $save_dir);
			if ($filename) {
				$pictures[] = array('path'=>$filename);
			}
		}
	}
	if ($pictures) {
		$data['Files'] = str::json($pictures);
	}
}

db::insert('wb_products_inquiry', $data);

str::msg('提交留言成功', 1);

?>