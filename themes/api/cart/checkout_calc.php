<?php
class checkout_calc_api {
	public static $wb_member_id = 0;
	public static $session_id = '';
	public static $where = ''; // 购物车必要条件
	public static $coupon = array(); // 优惠券
	public static $shipping = array(); // 运费
	public static $cart = array(); // 购物车统计
	public static $result = array(
		'price_total_allow' => 0,
		'weight_total_allow' => 0,
		'price_real_allow' => 0,
		'price_shipping' => 0,
		'price_coupon' => 0,
		'price_packing' => 0,
	);

	// 初始化
	public static function init(){
		self::$wb_member_id = (int)member('Id');
		self::$session_id = c('session_id');
		if (self::$wb_member_id) {
			self::$where = "wb_member_id='".self::$wb_member_id."'"; // 购物车必要条件
		} else {
			self::$where = "session_id='".self::$session_id."'"; // 购物车必要条件
		}
		// 
		self::set_cart();
		self::set_coupon();
		self::set_shipping();
		self::$result['price_real_allow'] = self::$result['price_total_allow'] - self::$result['price_coupon'] + self::$result['price_shipping'];
		// 
		self::$result['price_total_allow'] = price::rate(self::$result['price_total_allow'],2);
		self::$result['price_real_allow'] = price::rate(self::$result['price_real_allow'],2);
		self::$result['price_shipping'] = price::rate(self::$result['price_shipping'],2);
		self::$result['price_coupon'] = price::rate(self::$result['price_coupon'],2);
		self::$result['weight_total_allow'] = floatval(self::$result['weight_total_allow']);
		// 
		str::msg(self::$result, 1);
	}

	// 购物车
	public static function set_cart(){
		$BuyType = (int)$_POST['BuyType'];
		self::$cart = db::result("select sum(Weight*Qty) as weight_total_allow, sum(Price*Qty) as price_total_allow from wb_orders_cart where ".self::$where." and BuyType='".$BuyType."' and Allow=1");
		self::$result['price_total_allow'] = self::$cart['price_total_allow'];
		self::$result['weight_total_allow'] = self::$cart['weight_total_allow'];
	}

	// 优惠券
	public static function set_coupon(){
		self::$coupon = db::get("wb_orders_coupon::can_use", array(
			'number' => $_POST['wb_orders_coupon_name']
		));
		if (self::$coupon && self::$coupon['FullMoney']<=self::$result['price_total_allow']) {
			if (self::$coupon['FreeType']) {
				self::$result['price_coupon'] = self::$cart['price_total_allow'] * self::$coupon['FreeDiscount'];
			} else {
				self::$result['price_coupon'] = self::$coupon['FreeMoney'];
			}
		}
	}

	// 运费
	public static function set_shipping(){
		$wb_member_address_id = (int)$_POST['wb_member_address_id'];
		if ($wb_member_address_id) {
			$address = db::result("select * from wb_member_address where wb_member_id='".self::$wb_member_id."' and Id='{$wb_member_address_id}'");
			$country = $address['Country'];
			$province = $address['Province'];
		} else {
			$country = $_POST['ShippingCountry'];
			$province = $_POST['ShippingProvince'];
		}
		self::$shipping = db::get("wb_shipping::one_price", array(
			'weight' => self::$cart['weight_total_allow'],
			'price' => self::$cart['price_total_allow'],
			'wb_shipping_id' => (int)$_POST['wb_shipping_id'],
			'country' => $country,
			'province' => $province,
		));
		if (self::$shipping) {
			self::$result['price_shipping'] = self::$shipping['Price'];
		}
	}
}

checkout_calc_api::init();
?>