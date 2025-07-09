<?php
class cart_api {
	public static $wb_member_id = 0;
	public static $session_id = '';
	public static $Id = 0;
	public static $Qty = 0;
	public static $cart = array();
	public static $products = array();
	public static $where = ''; // 购物车必要条件

	// 初始化
	public static function init(){
		self::$Id = (int)$_POST['Id'];
		self::$Qty = (int)$_POST['Qty']>0?(int)$_POST['Qty']:1;
		self::$wb_member_id = (int)member('Id');
		self::$session_id = c('session_id');
		if (self::$wb_member_id) {
			self::$where = "wb_member_id='".self::$wb_member_id."'"; // 购物车必要条件
		} else {
			self::$where = "session_id='".self::$session_id."'"; // 购物车必要条件
		}
	}

	// 购物车数据
	public static function set_cart(){
		$where = self::$where." and Id='".self::$Id."'";
		self::$cart = db::get_one('wb_orders_cart', $where);
		if (self::$cart) {
			self::$products = wb_products::price(array(
				'id' => self::$cart['wb_products_id'],
				'qty' => self::$Qty,
				'wb_products_parameter_id' => self::$cart['wb_products_parameter_id']
			));
			if (!self::$products || self::$products['IsSaleOut'] || self::$products['wb_products_parameter_id_buy']!=self::$cart['wb_products_parameter_id']) {
				str::msg('商品已下架，请重新选择');
			}
		}
	}

	// 更新购物
	public static function update(){
		self::$Qty<=self::$products['Stock'] || self::$Qty = self::$products['Stock'];
		db::update('wb_orders_cart', "Id='".self::$cart['Id']."'", array(
			'Qty' => self::$Qty,
			'Price' => (float)self::$products['Price'],
		));
	}
}

// 初始化
cart_api::init();

// 设置
cart_api::set_cart();
if (!cart_api::$cart) {
	str::msg('', 1);
}

// 修改
cart_api::update();

str::msg('操作成功', 1);