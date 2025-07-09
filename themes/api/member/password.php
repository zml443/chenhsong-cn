<?php

isset($c) || exit();

$OldPassword = str::password($_POST['OldPassword']);
$NewPassword = str::password($_POST['NewPassword']);

$wb_member_id = member('Id');

if(!$_POST['OldPassword']){
	str::msg(array('txt' => lang('member.password.old_pwd_not_null')), 0);
}
if(!$_POST['NewPassword']){
	str::msg(array('txt' => lang('member.password.new_pwd_not_null')), 0);
}

$member_row=db::get_one('wb_member', "Id='{$wb_member_id}' and Password='{$OldPassword}'");

if(!$member_row){
	str::msg(array('txt' => lang('member.password.no_member')), 0);
}

if ($member_row){
	db::update('wb_member', "Id='{$wb_member_id}'", array(
			'Password'	=>	$NewPassword
		)
	);
	unset_member();
	str::msg('密码已修改,请重新登录!', 1);
}else{
	str::msg('旧密码错误', 0);
}

?>