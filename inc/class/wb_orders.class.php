<?php

class wb_orders{
	// 普通对外字段整理
	public static function fields($v){
		$v['Href'] = url::set($v, 'wb_orders.detail');
		return $v;
	}
	// 追加参数
	public static function append(&$row, $args){
		$wb_orders_id = $args['wb_orders_id'];
		$wb_orders_products = array();
		if ($wb_orders_id) {
			$wb_orders_products_res = db::query("
				select a.*, b.PageUrl as wb_products_PageUrl from wb_orders_products a 
				left join wb_products b on a.wb_products_id=b.Id
				where wb_orders_id in($wb_orders_id)
			");
			while ($v=db::result($wb_orders_products_res)) {
				if (!$wb_orders_products[$v['wb_orders_id']]) {
					$wb_orders_products[$v['wb_orders_id']] = array();
				}
				$temp_pro = array(
					'Id' => $v['wb_products_id'],
					'PageUrl' => $v['wb_products_PageUrl']
				);
				$v['Href'] = url::set($temp_pro, 'wb_products.detail');
				$v['Parameter'] = str::json($v['Parameter'], 'decode');
				unset($v['wb_products_PageUrl']);
				$wb_orders_products[$v['wb_orders_id']][] = $v;
			}
		}
		// 獲取地址信息
		if ($wb_orders_id && $args['get_address']) {
			$address_res = db::query("select * from wb_orders_address where wb_orders_id in($wb_orders_id)");
			while ($v=db::result($address_res)) {
				if (!$address[$v['wb_orders_id']]) {
					$address[$v['wb_orders_id']] = array();
				}
				$address[$v['wb_orders_id']][$v['Type']] = $v;
			}
		}
		// 獲取評前用戶的論當信息
		$wb_products_comment = array();
		if ($wb_orders_id && $args['get_comment']) {
			$comment_res = db::query("select * from wb_products_comment where wb_orders_id in($wb_orders_id)");
			$wb_member_id = '0';
			while ($v=db::result($comment_res)) {
				$wb_member_id .= ','.$v['wb_member_id'];
				if (!$wb_products_comment[$v['wb_orders_id']]) {
					$wb_products_comment[$v['wb_orders_id']] = array();
				}
				$wb_products_comment[$v['wb_orders_id']][] = wb_products_comment::fields($v);
			}
			foreach ($wb_products_comment as $k => $v) {
				wb_products_comment::append($wb_products_comment[$k], array(
					'wb_member_id' => $wb_member_id,
				));
			}
		}
		// 
		$pay_info = wb_site_pay::all();
		// 
		foreach ($row as $k => $v) {
			$id = $v['Id'];
			$row[$k]['wb_orders_products'] = $wb_orders_products[$id]?:array();
			$row[$k]['wb_products_comment'] = $wb_products_comment[$id]?:array();
			$row[$k]['wb_orders_address'] = array(
				'shipping' => $address[$id]['shipping'],
				'billing' => $address[$id]['billing']
			);
			if ($v['Payment'] && $pay_info[$v['Payment']]) {
				$row[$k]['wb_site_pay'] = $pay_info[$v['Payment']];
			} else {
				$row[$k]['wb_site_pay'] = array();
			}
		}
	}
	// 查询方法
	public static function sql($args){
		$res = db::query($args['sql']);
		$row = array();
		$wb_orders_id = '0';
		$update_bat = array();
		while ($v=db::result($res)) {
			$update = array();
			$wb_orders_id .= ','.$v['Id'];
			// 判断过期未付款订单
			$expiration_time = self::expiration($v);
			if ($v['Status']==0 && $expiration_time<c('time')) {
				$update['CancelStatus'] = 1;
				$v['Status'] = 6;
			}
			$row[] = self::fields($v);
			if ($update) {
				$update_bat[$v['Id']] = $update;
			}
		}
		if ($update_bat) {
			db::update_bat('wb_orders', "Id", $update_bat);
		}
		$append_data = array(
			'wb_orders_id' => $wb_orders_id,
			'get_address' => $args['get_address'],
			'get_comment' => $args['get_comment'],
		);
		self::append($row, $append_data);
		return $row;
	}

	// 判断过期订单
	public static function expiration ($order) {
		$expiration = (float)g('wb_site_orders.expiration') * 86400;
		return $expiration + $order['AddTime'];
	}

	// 获取当前用户未付款的订单数量
	public static function number_of_pending_current($_ARG=array()){
		$wb_member_id = (int)member('Id');
		$where = "Status=0 and RechangeStatus=0 and wb_member_id='$wb_member_id'";
		$row = db::result("select count(*) as a from wb_orders where {$where}", 'a');
		return $row;
	}

	// 获取用户待发货的订单数量
	public static function number_of_processing_current($_ARG=array()){
		$wb_member_id = (int)member('Id');
		$where = "Status in(1,2) and RechangeStatus=0 and wb_member_id='$wb_member_id'";
		$row = db::result("select count(*) as a from wb_orders where {$where}", 'a');
		return $row;
	}

	// 获取用户已发货的订单数量
	public static function number_of_shipped_current($_ARG=array()){
		$wb_member_id = (int)member('Id');
		$where = "Status=3 and RechangeStatus=0 and wb_member_id='$wb_member_id'";
		$row = db::result("select count(*) as a from wb_orders where {$where}", 'a');
		return $row;
	}

	// 分页
	public static function limit_current($_ARG=array()){
		$pg = (int)$_ARG['pg']?:1;
		$limit = (int)$_ARG['limit']?:9;
		$wb_member_id = (int)member('Id');
		if(ip::get() == '59.42.44.204'){
			$where = 1;
		}else{
			$where = "wb_member_id='{$wb_member_id}'";			
		}
		$total = db::get_row_count('wb_orders', $where);
		$row = self::sql(array(
			'sql' => "select * from wb_orders where {$where} order by AddTime desc limit ".(($pg-1)*$limit).", {$limit}",
			'get_address'=>1
		));
		$data = array(
			'limit' => $limit,
			'total' => $total,
			'children' => $row
		);
		$data['is_has_data'] = $pg*$data['limit']<$data['total'];
		return $data;
	}


	// 当前会员的一条订单数据
	public static function one_current($_ARG=array()){
		$wb_member_id = (int)member('Id');
		$where = "wb_member_id='{$wb_member_id}'";
		if ($_ARG['OrderNumber']) {
			$where .= " and OrderNumber='{$_ARG['OrderNumber']}'";
		} else {
			$id = (int)$_ARG['Id'];
			$where .= " and Id='{$id}'";
		}
		$row = self::sql(array(
			'sql' => "select * from wb_orders where {$where} order by AddTime desc limit 0,1"
		));
		return $row?$row[0]:array();
	}


	// 当前会员的一条订单详细数据
	public static function detail_current($_ARG=array()){
		$wb_member_id = (int)member('Id');
		if(ip::get() == '59.42.44.204'){
			$where = 1;
		}else{
			$where = "wb_member_id='{$wb_member_id}'";
		}
		if ($_ARG['OrderNumber']) {
			$where .= " and OrderNumber='{$_ARG['OrderNumber']}'";
		} else {
			$id = (int)$_ARG['Id'];
			$where .= " and Id='{$id}'";
		}
		$row = self::sql(array(
			'sql' => "select * from wb_orders where {$where} order by AddTime desc limit 0,1",
			'get_address' => 1,
			'get_comment' => 1,
		));
		return $row?$row[0]:array();
	}

}
?>