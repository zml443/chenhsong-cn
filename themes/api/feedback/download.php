<?php

isset($c) || exit();

$VCode=htmlspecialchars(addslashes($_POST['VCode']));

if($VCode){
	if($VCode != $_SESSION['VCode']['download']){
		str::msg(l('验证码不正确，请重新输入','The verification code is incorrect, please re-enter it'), 0);
	}
}else{
	str::msg(l('验证码不能为空','The verification code cannot be empty'), 0);
}

$Name=htmlspecialchars(addslashes($_POST['Name']));
$Sex=htmlspecialchars(addslashes($_POST['Sex']));
$Phone=htmlspecialchars(addslashes($_POST['Phone']));
$Country=htmlspecialchars(addslashes($_POST['Country']));
$Email=htmlspecialchars(addslashes($_POST['Email']));
$Address=htmlspecialchars(addslashes($_POST['Address']));
$Message=htmlspecialchars(addslashes($_POST['Message']));
$From=htmlspecialchars(addslashes($_POST['From']));
$Areas=htmlspecialchars(addslashes($_POST['Areas']));
$downId = $_POST['wb_download_id'];
if($Sex == 'man'){
	$Sex = '先生';
}else{
	$Sex = '女士';
}
// $file = "";
// $path = db::get_value('wb_blog_download', "Id = '{$downId}'",'Files');
// if($path){
// 	$files = str::json($path, 'decode');
// 	$file = $files[0]['path'];
// }
$data = array(
	'Name' => $Name.$Sex,
	'Phone' => $Phone,
	'Country' => $Country,
	'Email' => $Email,
	'Address' => $Address,
	'Areas' => $Areas,
	'Message' => $Message,
	'wb_download_id' => $downId,
	'AddTime' => c('time'),
	'Ip' => ip::get(),
);

db::insert('wb_download_feedback', $data);
// str::msg(l('您提交的信息已保存，请耐心等待回复，谢谢！','The information you submitted has been saved. Please be patient and wait for a reply. Thank you!'), 1);

str::msg(array('msg'=>l('您提交的信息已保存，请耐心等待回复，谢谢！','The information you submitted has been saved. Please be patient and wait for a reply. Thank you!'),'path'=>''), 1);

?>