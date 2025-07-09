<?php

// 身份验证
$VCodeID = $_SESSION['VCode']['ID'];
if (!$VCodeID || $VCodeID!=$_POST['VCodeID']) {
	str::msg(lang('notes.resubmit').'--'.$VCodeID, 0);
}
unset($_SESSION['VCode']['ID']);

$time = time();

// 判断为邮箱-邮箱操作
if (strstr($_POST['sms'], '@')) {

	$Email = $_POST['sms'];
	$SC = $_SESSION['Sms'][$Email] = array(
		'email'	=>	$Email,
		'code'	=>	rand(100000,999999),
		'time'	=>	$time + 300
	);
	$company = g(ln('set.contact.company'));
	$email_con = str_replace('%code%', $SC['code'], lang('notes.code_tips'));
	$sms = ly200::sendmail($SC['email'], "【{$company}】", $email_con);
	if ($sms['ret'] == 1) {
		str::msg(lang('notes.email_tips'),1);
	} else {
		str::msg('失败',0);
	}
}


// 手机号操作
else {
	$Phone = $_POST['sms'];
	$SC = $_SESSION['Sms'][$Phone] = array(// SESSION记录
		'phone'	=>	$Phone,
		'code'	=>	rand(100000,999999),
		'time'	=>	$time + 300
	);
	$company = g(ln('set.contact.company'));
	$phone_con = str_replace('%code%', $SC['code'], lang('notes.code_tips'));
	$sms = ly200::send_sms($SC['phone'], $phone_con, "【{$company}】");
	if ($sms['code'] == '0') {
		str::msg(lang('notes.phone_tips'), 1);
	} else {
		$phone_err = str_replace('%code%', $SC['code'], lang('notes.phone_err'));
		str::msg($phone_err, 0);
	}
	
}