<?php

isset($c) || exit();



if(!$_POST['Name']||!$_POST['Email']){
	str::msg('提交留言失败', 0);
}


$data = array(
	'Name' => $_POST['Name'],
	'Email' => $_POST['Email'],
	'Phone' => $_POST['Phone'],
	'Company' => $_POST['Company'],
	'AddTime' => c('time'),
	'Ip' => ip::get(),
);

db::insert('wb_download_feedback', $data);

$_SESSION['lysaas-downloadFeedback'] = 1;

str::msg('提交留言成功', 1);

?>