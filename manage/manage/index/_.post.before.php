<?php
 function_exists('c') || exit;


if (c('manage.type')!='normal') {
	exit(str::json(array(
		'ret' => 0,
		'msg' => '权限不够',
	)));
}

// 自己的权限不能改
if (manage('Id')==$this->before_row['Id']) {
	unset($_POST['Level'], $_POST['Permit']);
}
$_POST['PermitStr'] = str::ary_splice($_POST['Permit']);
// 不是超级管理员只能添加普通管理员
if (manage('Level')!=1) {
	$_POST['Level'] = 2;
	// 检查一下权限是否符合
	// str::ary_splice($_POST['Permit']);
	$permit_ary = explode(',', $_POST['PermitStr']);
	$permit_key = manage('Level')==1?'reset':'reset_cur';
	foreach ($permit_ary as $k => $v) {
		if ($v && !p('manage.permit.'.$permit_key.'.'.$v)) {
			str::msg('权限错了', 0);
		}
	}
}

if ($this->before_row['IsLock'] && manage('Id')!=$this->before_row['Id']) {
	str::msg('权限不足', 0);
}

// 添加
// 对接联雅云官网
if ($this->is_add && c('IsLYYMember')) {
	$res = curl::api(c('LYYwebsite.member.api'), c('LYYwebsite.member.key'), array(
		'ApiName' => 'children',
		'HostName' => c('HostName'),
		'UserName' => $_POST['UserName'],
		'Password' => str::password($_POST['Password']),
	));
	$res = str::json($res, 'decode');
	if ($res['ret']==0) {
		exit(str::json(array(
			'msg' => '添加失败',
			'ret' => 0
		)));
	} else if ($res['ret']==2)  {
		exit(str::json(array(
			'msg' => '账号重复',
			'ret' => 0
		)));
	}
}

// 修改
// 对接联雅云官网
if ($this->is_mod && $_POST['Password'] && c('IsLYYMember')) {
	$res = curl::api(c('LYYwebsite.member.api'), c('LYYwebsite.member.key'), array(
		'ApiName' => 'password',
		'HostName' => c('HostName'),
		'UserName' => $this->before_row['UserName'],
		'Password' => str::password($_POST['Password']),
	));
	$res = str::json($res, 'decode');
	if ($res['ret']!=1) {
		exit(str::json(array(
			'msg' => '修改失败',
			'ret' => 0
		)));
	}
}

