<?php
class cart_api {
	public static $wb_member_id = 0;
	public static $session_id = '';
	public static $Qty = 1;
	public static $BuyType = 0; // 立即购买
	public static $products = array(); // 购买产品
	public static $repeat_cart = array(); // 购物车里面的重复产品
	public static $where = ''; // 购物车必要条件

	// 初始化
	public static function init(){
		self::$wb_member_id = (int)member('Id');
		self::$session_id = c('session_id');
		self::$Qty = (int)$_POST['Qty']>0?(int)$_POST['Qty']:1;
		if ((int)$_POST['BuyType']) {
			self::$BuyType = str::rand();
		} else {
			self::$BuyType = 0;
		}
		if (self::$wb_member_id) {
			self::$where = "wb_member_id='".self::$wb_member_id."'"; // 购物车必要条件
		} else {
			self::$where = "session_id='".self::$session_id."'"; // 购物车必要条件
		}

		// 设置购买产品
		self::set_products();

		// 立即购买时，删除过期的购物
		self::delete_expires_cart();

		// 设置重复购物
		self::set_repeat_cart();
		if (self::$repeat_cart) {
			self::update();
		} else {
			self::insert();
		}
		$return_result = array(
			'msg' => '添加成功',
			'ret' => 1
		);
		if (self::$BuyType) {
			$return_result['url'] = '/cart/buynow.html?BuyType='.self::$BuyType;
		}
		exit(str::json($return_result));
	}

	// 获取产品
	public static function set_products(){
		self::$products = wb_products::price(array(
			'id' => (int)$_POST['wb_products_id'],
			'qty' => self::$Qty,
			'wb_products_parameter_id' => $_POST['wb_products_parameter_id']
		));
		// 产品下架
		if (!self::$products || self::$products['IsSaleOut']) {
			str::msg('商品已下架');
		}
		// 库存检查
		if (self::$products['Stock']<self::$Qty) {
			str::msg(lang('cart.qty_invalid'));
		}
		// 属性检查
		if (self::$products['ProPriceType']==1 && !self::$products['wb_products_parameter_id_buy']) {
			str::msg('请选择属性');
		}
	}

	// 删除以前过期的 立即购买的 产品
	public static function delete_expires_cart(){
		if(self::$BuyType && self::$BuyType!='0'){
			db::delete('wb_orders_cart', self::$where." and BuyType='".self::$BuyType."'");
		}
	}

	// 购物车里的重复产品
	public static function set_repeat_cart(){
		$where = self::$where." and wb_products_id='".self::$products['Id']."' and wb_products_parameter_id='".self::$products['wb_products_parameter_id_buy']."' and BuyType='".self::$BuyType."'";
		self::$repeat_cart = db::get_one('wb_orders_cart', $where);
	}

	// 更新购物
	public static function update(){
		$Qty = self::$Qty + self::$repeat_cart['Qty'];
		$Qty<=self::$products['Stock'] || $Qty = self::$products['Stock'];
		db::update('wb_orders_cart', "Id='".self::$repeat_cart['Id']."'", array(
			'Qty' => $Qty,
			'Price' => (float)self::$products['Price'],
			'AddTime' => c('time')
		));
	}

	// 插入购物车
	public static function insert(){
		db::insert('wb_orders_cart', array(
			'Name' => addslashes(self::$products['Name']),
			'Category' => addslashes(self::$products['Category']),
			'Href' => addslashes(self::$products['Href']),
			'Picture' => addslashes(self::$products['Picture']['path']),
			'wb_member_id' => self::$wb_member_id,
			'session_id' => self::$session_id,
			'Parameter' => str::code(str::json(self::$products['wb_products_parameter_buy']),'addslashes'),
			'SKU' => addslashes(self::$products['SKU']),
			'wb_products_id' => self::$products['Id'],
			// 'wb_products_parameter_id' => self::$products['wb_products_parameter_id'],
			'wb_products_parameter_id' => self::$products['wb_products_parameter_id_buy'],
			'Price' => (float)self::$products['Price'],
			'Qty' => self::$Qty,
			'Allow' => 1,
			'BuyType' => self::$BuyType,
			'AddTime' => c('time'),
			'Weight' => (float)self::$products['Weight'],
			// 'UnPrice' => self::$products['UnPrice'],
		));
	}
}

// 初始化
cart_api::init();