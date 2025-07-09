<?php
isset($c) || exit();
$data = array(
	'wb_member_id' => member('Id'),
	'session_id' => c('session_id'),
	'wb_orders_id' => (int)$_POST['wb_orders_id'],
	'wb_orders_products_id' => (int)$_POST['wb_orders_products_id'],
	'wb_products_id' => (int)$_POST['wb_products_id'],
	'Star' => (int)$_POST['Star']?:10,
	'Message' => $_POST['Message'],
	'AddTime' => c('time'),
	'Ip' => ip::get(),
	'IpInfo' => addslashes(str::json(ip::info()))
);
if (!$data['wb_products_id']) {
	str::msg('請選擇商品');
}
if (!$data['wb_member_id']) {
	str::msg('請登錄賬號');
}

if ($data['wb_orders_id']) {
	$one_orders = db::get_one("wb_orders", "wb_member_id='{$data['wb_member_id']}' and Id='{$data['wb_orders_id']}'");
	$one_orders_pro = db::get_row_count("wb_orders_products", "wb_orders_id='{$data['wb_orders_id']}' and Id='{$data['wb_orders_products_id']}'");
	if (!$one_orders || !$one_orders_pro) {
		str::msg('請購買商品后評論');
	}
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
		$data['IsHasPictures'] = 1;
		$data['Pictures'] = str::json($pictures);
	}
}
// 回复的层级
if ($wb_products_comment_id = (int)$_POST['wb_products_comment_id']) {
	$comment = db::get_one("wb_products_comment", "Id='{$wb_products_comment_id}'", "Id,UId");
	$data['UId'] = $comment['UId'].$comment['Id'].',';
	$data['Dept'] = substr_count($data['UId']);
}
db::insert('wb_products_comment', $data);
db::number('comment', 'wb_products', $data['wb_products_id'], 1, 'day week month');


if ($data['wb_orders_id']) {
	$update_orders = array(
		'IsProductsComment' => 1,
	);
	if ($one_orders['Status']==4) {
		$update_orders['Status'] = 5;
	}
	$one_orders = db::update("wb_orders", "wb_member_id='{$data['wb_member_id']}' and Id='{$data['wb_orders_id']}'", $update_orders);
}

$total = db::get_row_count('wb_products_comment', "wb_products_id='{$data['wb_products_id']}'");
$star = db::get_sum('wb_products_comment', "wb_products_id='{$data['wb_products_id']}'", 'Star');

$average_star = ($star/$total);
db::update('wb_products', "Id='{$data['wb_products_id']}'", array(
	'Star' => $average_star
));

str::msg('感謝您的評論', 1);
?>