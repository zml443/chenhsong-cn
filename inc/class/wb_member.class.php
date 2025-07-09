<?php

class wb_member{
	// 非登录状态时跳转
	public static function login_or_not(){
		if(!member('Id')){
			js::location('/member/login/');
		}
	}

	// 普通对外字段整理
	public static function fields($v){
		$v['Face'] || $v['Face'] = g('wb_member_set.face');
		if (!$v['UserName']) {
			if ($v['Name']) {
				$v['UserName'] = $v['Name'];
			} else if ($v['Email']) {
				$v['UserName'] = str::hide_email($v['Email']);
			} else {
				$v['UserName'] = substr_replace($v['Mobile'], '*****', 3, -4);
			}
		}
		return $v;
	}

	// 当前用户的信息
	public static function current($_ARG=array()){
		$wb_member_id = member("Id");
		if ($wb_member_id) {
			$where = "Id='{$wb_member_id}'";
		} else {
			return array();
		}
		$row = db::result("select * from wb_member where {$where}");
		if ($row) {
			$row = self::fields($row);
		}
		return $row;
	}

}
?>