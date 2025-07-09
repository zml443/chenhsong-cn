<?php

if (strstr($_POST['UserName'], '@')) {
	$Email = $_POST['UserName'];
} else {
	$Mobile = $_POST['UserName'];
}

$Password = str::password($_POST['Password']);

if ($Email) {
	$member = db::get_one('wb_member',"Email='{$Email}' and Password='{$Password}'");
	$member || str::msg(lang('member.login.error'));
} else if ($Mobile) {
	$member = db::get_one('wb_member',"Mobile='{$Mobile}' and Password='{$Password}'");
	$member || str::msg(lang('member.login.error'));
} else {
	str::msg('请输入正确的账号');
}

if ($member['IsLoginLock']) {
	str::msg('账号登录未开通');
}

if ((int)$_POST['IsRemember']) {
	setcookie("MemberId", $member['Id'], time()+3600*24*7, '/');
}
member('', $member);

db::update('wb_member', "Id='{$member['Id']}'", array(
	'LastLoginIp' => ip::get(),
	'LastLoginTime' => c('time'),
	'data_number_login' => $member['data_number_login']+1,
));

// 将游客的购物车放入会员里面
wb_orders_cart::tourist_put_in_member();

log::member('login', '会员登录');

str::msg(lang('member.login.success'), 1);
?>