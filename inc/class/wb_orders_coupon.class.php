<?php

class wb_orders_coupon{
	// 获取当前用户的优惠券 - 且订单可用
	public static function can_use_current($_ARG=array()){
		$wb_member_id = member("Id");
		$price = (float)$_ARG['price'];
		$time = c('time');
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = '0';
		}
		$where .= " and EfTime1>$time and UseQty>0 and FullMoney<=$price";
		$res = db::query("select * from wb_orders_coupon where {$where}");
		$row = array();
		while ($v = db::result($res)) {
			$row[] = $v;
		}
		return $row;
	}

	// 获取当前用户的优惠券
	public static function all_current($_ARG=array()){
		$wb_member_id = member("Id");
		$price = (float)$_ARG['price'];
		$time = c('time');
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = '0';
		}
		$where .= " and EfTime1>$time and UseQty>0";
		$res = db::query("select * from wb_orders_coupon where {$where}");
		$row = array();
		while ($v = db::result($res)) {
			$row[] = $v;
		}
		return $row;
	}

	// 获取单个可用优惠券
	public static function one($_ARG=array()){
		$wb_member_id = member("Id");
		$id = (int)$_ARG['id'];
		$price = (float)$_ARG['price'];
		$number = $_ARG['number'];
		if ($id) {
			$where = "Id='{$Id}'";
		} else if ($number) {
			$where = "Name='{$number}'";
		} else {
			$where = '0';
		}
		$row = db::result("select * from wb_orders_coupon where {$where}");
		if (!$row) {
			return array();
		}
		if ($row['UseQty']<=0) {
			return array();
		}
		if ($row['wb_member_id'] && $row['wb_member_id']!=$wb_member_id) {
			return array();
		}
		if ($row['EfTime1']<c('time') || $row['EfTime0']>c('time')) {
			return array();
		}
		return $row;
	}
}
?>