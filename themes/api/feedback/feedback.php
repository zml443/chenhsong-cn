<?php

isset($c) || exit();

$VCode=htmlspecialchars(addslashes($_POST['VCode']));
$Areas=$_POST['Areas'];

if($VCode){
	if($VCode != $_SESSION['VCode']['contact']){
		str::msg(l('验证码不正确，请重新输入','The verification code is incorrect, please re-enter it'), 0);
	}
}else{
	str::msg(l('验证码不能为空','The verification code cannot be empty'), 0);
}

if(!$Areas){
	str::msg(l('请选择你关注的领域','Please select the field you are interested in'), 0);
}

$Name=htmlspecialchars(addslashes($_POST['Name']));
$Sex=htmlspecialchars(addslashes($_POST['Sex']));
$Phone=htmlspecialchars(addslashes($_POST['Phone']));
$Country=htmlspecialchars(addslashes($_POST['Country']));
$Email=htmlspecialchars(addslashes($_POST['Email']));
$Address=htmlspecialchars(addslashes($_POST['Address']));
$Message=htmlspecialchars(addslashes($_POST['Message']));
$From=htmlspecialchars(addslashes($_POST['From']));

if($Sex == 'man'){
	$Sex = '先生';
}else{
	$Sex = '女士';
}

if($From == 'industry'){
    $From = '行业方案';
}else if($From == 'service'){
    $From = '服务&支持';
}else if($From == 'products'){
    $From = '产品详情';
}else if($From == 'contact'){
    $From = '联系我们';
}

$Areas = implode(", ", $Areas);

$data = array(
	'Name' => $Name.$Sex,
	'Phone' => $Phone,
	'Country' => $Country,
	'Email' => $Email,
	'Address' => $Address,
	'Areas' => $Areas,
	'Message' => $Message,
	'From' => $From,
	'AddTime' => c('time'),
	'Ip' => ip::get(),
);

db::insert('wb_feedback', $data);
str::msg(l('您提交的信息已保存，请耐心等待回复，谢谢！','The information you submitted has been saved. Please be patient and wait for a reply. Thank you!'), 1);

?>