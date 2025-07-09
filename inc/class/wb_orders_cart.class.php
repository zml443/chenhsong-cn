<?php

class wb_orders_cart{
	// 获取当前用户的购物车数据
	public static function all_current($_ARG=array()){
		$wb_member_id = member("Id");
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = "session_id='".c('session_id')."' and wb_member_id=0";
		}
		if ($_ARG['BuyType']) {
			$where .= " and BuyType='".$_ARG['BuyType']."'";
		} else {
			$where .= " and BuyType='0'";
		}
		if (isset($_ARG['Allow'])) {
			$where .= " and Allow='".(int)$_ARG['Allow']."'";
		}
		$data = array(
			'weight_total' => 0,
			'weight_total_allow' => 0,
			'qty_total' => 0,
			'qty_total_allow' => 0,
			'price_total' => 0,
			'price_total_allow' => 0,
			'children' => array()
		);
		$res = db::query("select  * from wb_orders_cart where {$where}");
		$row = array();
		$products_price_id = '0';
		while ($v = db::result($res)) {
			$products_price_id .= ",".(int)$v['wb_products_id'];
			$row[] = $v;
		}
		$products_res = wb_products::ids(array(
			'id' => $products_price_id
		));
		$products = array();
		foreach ($products_res as $k => $v) {
			$products[$v['Id']] = $v;
		}
		unset($products_res);
		// 
		$update_bat = array();
		foreach ($row as $v) {
			$pro = $products[$v['wb_products_id']];
			$update = array();
			if (!$pro || $pro['IsSaleOut']) {
				// $update['IsSaleOut'] = 1;
				$v['IsSaleOut'] = 1;
				$v['Allow'] = 0;
			} else {
				$pro = wb_products::deal_with_price(array(
					'row' => $pro,
					'qty' => $v['Qty'],
					'wb_products_parameter_id' => $v['wb_products_parameter_id']
				));
				if ($pro['wb_products_parameter_id_buy']!=$v['wb_products_parameter_id']) {
					// $update['IsSaleOut'] = 1;
					$v['IsSaleOut'] = 1;
					$v['Allow'] = 0;
				} else if ($pro['Price']!=$v['Price']) {
					$update['Price'] = $pro['Price'];
					$v['Price'] = $pro['Price'];
				}
				$v['Stock'] = $pro['Stock'];
				$v['wb_products'] = $pro;
			}
			if (!$v['IsSaleOut']) {
				$data['qty_total'] += $v['Qty'];
				$data['weight_total'] += $v['Qty']*$v['Weight'];
				$data['price_total'] += $v['Qty']*$v['Price'];
				if ($v['Allow']) {
					$data['qty_total_allow'] += $v['Qty'];
					$data['weight_total_allow'] += $v['Qty']*$v['Weight'];
					$data['price_total_allow'] += $v['Qty']*$v['Price'];
				}
			}
			$v['Parameter'] = str::json($v['Parameter'], 'decode');
			$data['children'][] = $v;
			if ($update) {
				$update_bat[$v['Id']] = $update;
			}
		}
		if ($update_bat) {
			db::update_bat('wb_orders_cart', "Id", $update_bat);
		}
		return $data;
	}

	// 统计数
	public static function qty_current($_ARG=array()){
		$wb_member_id = member("Id");
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = "session_id='".c('session_id')."' and wb_member_id=0";
		}
		$where .= " and BuyType='".(int)$_ARG['BuyType']."'";
		if (isset($_ARG['Allow'])) {
			$where .= " and Allow='".(int)$_ARG['Allow']."'";
		}
		$res = db::result("select sum(Qty) as qty from wb_orders_cart where {$where}", 'qty');
		return (int)$res;
	}

	// 统计数
	public static function count_current($_ARG=array()){
		$wb_member_id = member("Id");
		if ($wb_member_id) {
			$where = "wb_member_id='{$wb_member_id}'";
		} else {
			$where = "session_id='".c('session_id')."' and wb_member_id=0";
		}
		$where .= " and BuyType='".(int)$_ARG['BuyType']."'";
		if (isset($_ARG['Allow'])) {
			$where .= " and Allow='".(int)$_ARG['Allow']."'";
		}
		$res = db::result("select count(*) as qty from wb_orders_cart where {$where}", 'qty');
		return (int)$res;
	}


	// 将游客的购物车添加到会员
	public static function tourist_put_in_member($_ARG=array()){
		$wb_member_id = member("Id");
		$session_id = c("session_id");
		if (!$wb_member_id) {
			return '';
		}
		$session_row = db::query("select * from wb_orders_cart where session_id='{$session_id}' and wb_member_id=0");
		$update_bat = array();
		$delete_ids = '0';
		while ($v=db::result($session_row)) {
			$one = db::get_one('wb_orders_cart', "wb_products_id='{$v['wb_products_id']}' and wb_products_parameter_id='{$v['wb_products_parameter_id']}' and wb_member_id='{$wb_member_id}'");
			$update_bat[$v['Id']] = array(
				'wb_member_id' => $wb_member_id
			);
			if ($one) {
				$delete_ids .= ','. $one['Id'];
			}
		}
		db::delete('wb_orders_cart', "Id in($delete_ids)");
		db::update_bat('wb_orders_cart', "Id", $update_bat);
	}
}
?>