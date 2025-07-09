<?php
	//d($_POST);
	$D = array(
		'Email'			=>	$_POST['Email'],
		'VCode'			=>	$_POST['VCode'],
		'Password'		=>	str::password($_POST['Password']),
		'EnterPassword'	=>	str::password($_POST['EnterPassword']),
	);

	$path = '/member/login/';
	$member_row=db::get_one('wb_member', "Email='{$D['Email']}'", 'Id,Email,UserName,Password');

	if($member_row){
		if(!$_POST['Type']){
			if ($D['VCode']!=$_SESSION['Sms'][$D['Email']]['code']) {
				str::msg(array('txt' => lang('member.register.code_tips')));
			}

			if($member_row){
				str::msg(array('txt' => ''), 2);
			}else{
				str::msg(array('txt' => lang('member.forgot.is_not_reg')), 0);
			}
		}else{
			if (!$_POST['Password']) {
				str::msg(array('txt' => lang('member.register.pwd_not_null')), 0);
			}

			if (!$_POST['EnterPassword']) {
				str::msg(array('txt' => lang('member.password.enter_new_pwd_not_null')), 0);
			}
			
			if ($member_row['Password'] == $D['Password']) {
				str::msg(array('txt' => lang('member.password.old_new_pwd')), 0);
			}

			if ($_POST['Password'] != $_POST['EnterPassword']) {
				str::msg(array('txt' => lang('member.password.pwd_match')), 0);
			}

			db::update('wb_member', "Email='{$D['Email']}'", array(
					'Password' => $D['Password']
				)
			);

			str::msg(array('txt' => lang('member.password.upd_success'), 'path' => $path), 1);
		}
	}else{
		str::msg(array('txt' => lang('member.forgot.is_not_reg')), 0);
	}
?>