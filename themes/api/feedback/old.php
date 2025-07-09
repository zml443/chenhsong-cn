<?php

isset($c) || exit();

$data = array(
	'Name' => $_POST['Name'],
	'Email' => $_POST['Email'],
	'Phone' => $_POST['Phone'],
	'Company' => $_POST['Company'],
	'Job' => $_POST['Job'],
	'Message' => $_POST['Message'],
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


db::insert('wb_feedback', $data);

$feedback_reminder_email = g('wb_site_config.feedback_reminder_email');
if ($feedback_reminder_email) {
	$data['Name'] && $content .= '
		<tr style="font-size:16px;">
			<td>名称：</td>
			<td>'.$data['Name'].'</td>
		</tr>
	';
	$data['Email'] && $content .= '
		<tr style="font-size:16px;">
			<td>邮箱：</td>
			<td>'.$data['Email'].'</td>
		</tr>
	';
	$data['Phone'] && $content .= '
		<tr style="font-size:16px;">
			<td>电话：</td>
			<td>'.$data['Phone'].'</td>
		</tr>
	';
	$data['Company'] && $content .= '
		<tr style="font-size:16px;">
			<td>公司：</td>
			<td>'.$data['Company'].'</td>
		</tr>
	';
	$data['Job'] && $content .= '
		<tr style="font-size:16px;">
			<td>职位：</td>
			<td>'.$data['Job'].'</td>
		</tr>
	';
	$data['Message'] && $content .= '
		<tr style="font-size:16px;">
			<td>留言：</td>
			<td>'.$data['Message'].'</td>
		</tr>
	';
	if ($content) {
		$content = "<table>{$content}</table>";
		ly200::sendmail($feedback_reminder_email, '在线留言', $content);
	}
}

str::msg('提交留言成功', 1);

?>