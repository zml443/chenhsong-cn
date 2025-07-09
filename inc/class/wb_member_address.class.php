<?php

class wb_member_address{
	// 普通对外字段整理
	public static function fields($v){
		$v['Name'] = str::real_name($v['FirstName'], $v['LastName']);
		return $v;
	}
	// 当前用户的地址信息
	public static function limit_current($_ARG=array()){
		$wb_member_id = member("Id");
		$pg = (int)$_ARG['pg']?:1;
		$limit = (int)$_ARG['limit']?:9;
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = '0';
		}
		if ($_ARG['Type']) {
			$where = " and Type='{$_ARG['Type']}'";
		}
		$total = db::get_row_count('wb_member_address', $where);
		$res = db::query("
			select * from wb_member_address
			where {$where}
			order by IsDefault desc,Id desc
			limit ".(($pg-1)*$limit).", {$limit}
		");
		$row = array();
		while ($v = db::result($res)) {
			$row[] = self::fields($v);
		}
		$data = array(
			'limit' => $limit,
			'total' => $total,
			'children' => $row
		);
		$data['is_has_data'] = $data['limit']*$pg < $data['total'];
		return $data;
	}

	// 获取当前用户的默认地址
	public static function default_current($_ARG=array()){
		$wb_member_id = member("Id");
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = '0';
		}
		/*if ($_SESSION['wb_member_address_id_current']) {
			$where .= " and Id='".(int)$_SESSION['wb_member_address_id_current']."'";
		}*/
		if ($_ARG['Type']=='billing') {
			$where .= " and Type='billing'";
		} else {
			$where .= " and Type='shipping'";
		}
		$row = db::result("select * from wb_member_address where {$where} order by IsDefault desc limit 0,1");
		if ($row) {
			$row = self::fields($row);
		}
		return $row;
	}

	// 获取当前用户的默认地址
	public static function one_current($_ARG=array()){
		$wb_member_id = member("Id");
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = '0';
		}
		$where .= " and Id='".(int)$_ARG['id']."'";
		$row = db::result("select * from wb_member_address where {$where} limit 0,1");
		if ($row) {
			$row = self::fields($row);
		}
		return $row;
	}
}
?>