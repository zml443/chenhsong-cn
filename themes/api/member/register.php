<?php
$data = array(
	'LastName'		=>	$_POST['LastName'],
	'FirstName'		=>	$_POST['FirstName'],
	'Email'			=>	$_POST['Email'],
	'Mobile'		=>	$_POST['Mobile'],
	'UserAddress'	=>	$_POST['UserAddress'],
	'Password'		=>	$_POST['Password']?str::password($_POST['Password']):'',
	'ExamineStatus' => 'Y',
	'AddTime'		=>	c('time'),
	'Ip'			=>	ip::get()
);

/*foreach((array)$data as $k=>$v){
	if(!$v){
		str::msg(lang('member.register.form_empty'));
	}
}*/


if(!check::email($data['Email'])){
	str::msg(lang('member.register.error.email_format'));
}
if(!check::phone($data['Mobile'])){
	str::msg(lang('member.register.error.mobile_format'));
}

$has = db::get_row_count('wb_member',"Email='{$data['Email']}'");
if ($has) {//已注冊
	str::msg(lang('member.register.error.email'));
}

$has = db::get_row_count('wb_member',"Mobile='{$data['Mobile']}'");
if ($has) {//已注冊
	str::msg('手机号码已被注册');
}

$data['Id'] = db::insert('wb_member', $data);
$member = db::get_one('wb_member', "Id='{$data['Id']}'");
member('', $member);

// 将游客的购物车放入会员里面
wb_orders_cart::tourist_put_in_member();

log::member('register', '注册会员');
str::msg(lang('member.register.success'), 1);

?>