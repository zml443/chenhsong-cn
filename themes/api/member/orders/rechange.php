<?php
isset($c) || exit();
$wb_orders_id = (int)$_POST['wb_orders_id'];
$wb_member_id = (int)member('Id');

$where = "Id='{$wb_orders_id}' and wb_member_id='{$wb_member_id}'";

$orders = db::get_one('wb_orders', $where);
if (!$orders) {
	str::msg('订单错误');
}
if (!in_array($orders['Status'], array(4,5))) {
	str::msg('无法进行售后申请');
}

$data = array(
	'RechangeStatus' => (int)$_POST['type'],
	'RechangeText' => $_POST['message'],
	'RechangeTime' => c('time')
);
if (!$data['RechangeStatus']) {
	str::msg('售后类型');
}
if (!$data['RechangeText']) {
	str::msg('请填写原因');
}
// 保存图片
if ($_FILES['Pictures']) {
	$pictures = array();
	$save_dir = c('u_file_dir') . strtolower(c('website.name')) . date('/Y-m/d/');
	foreach ($_FILES['Pictures']['tmp_name'] as $k => $v) {
		if ($v) {
			$files = array(
				'tmp_name' => $v,
				'name' => $_FILES['Pictures']['name'][$k],
				'type' => $_FILES['Pictures']['type'][$k],
				'size' => $_FILES['Pictures']['size'][$k],
				'error' => $_FILES['Pictures']['error'][$k]
			);
			$filename = file::upload($files, $save_dir);
			if ($filename) {
				$pictures[] = array('path'=>$filename);
			}
		}
	}
	if ($pictures) {
		$data['RechangePicture'] = str::json($pictures);
	}
}

db::update('wb_orders', $where, $data);
str::msg('提交评论成功', 1);
?>