<?php
class checkout_api {
	public static $wb_orders_id = 0;
	public static $OrderNumber = '';
	public static $coupon = array(); // 优惠券
	public static $shipping = array(); // 运费
	public static $cart = array(); // 购物车统计
	public static $address = array(
		'Shipping' => array(),
		'Billing' => array()
	);

	// 初始化
	public static function init(){
		// 地址
		self::set_address();
		// 购物车
		self::set_cart();
		// 优惠券
		self::set_coupon();
		// 运费
		self::set_shipping();
		// 插入订单
		self::insert();
		// 当会员没有地址的时候,将此地址收录到默认
		self::insert_member_address();
		// 
		exit(str::json(array(
			'msg' => '',
			'OrderNumber' => self::$OrderNumber,
			'ret' => 1
		)));
	}

	// 购物车
	public static function set_cart(){
		self::$cart = wb_orders_cart::all_current(array(
			'BuyType' => $_POST['BuyType'],
			'Allow' => 1
		));
		if (self::$cart['qty_total_allow']==0) {
			str::msg('请选择购买物品');
		}
	}

	// 优惠券
	public static function set_coupon(){
		self::$coupon = wb_orders_coupon::one(array(
			'number' => $_POST['wb_orders_coupon_name']
		));
		if (self::$coupon && self::$coupon['FullMoney']<=self::$cart['price_total_allow']) {
			if (self::$coupon['FreeType']) {
				self::$cart['price_coupon'] = self::$cart['price_total_allow'] * self::$coupon['FreeDiscount'];
			} else {
				self::$cart['price_coupon'] = self::$coupon['FreeMoney'];
			}
		}
	}

	// 运费
	public static function set_shipping(){
		$country = self::$address['Shipping']['Country'];
		$province = self::$address['Shipping']['Province'];
		self::$shipping = wb_shipping::one_price(array(
			'weight' => self::$cart['weight_total_allow'],
			'price' => self::$cart['price_total_allow'],
			'wb_shipping_id' => (int)$_POST['wb_shipping_id'],
			'country' => $country,
			'province' => $province,
		));
		if (self::$shipping) {
			self::$cart['price_shipping'] = self::$shipping['Price'];
		} else {
			str::msg('请选择配送方式');
		}
	}

	// 地址录入
	public static function set_address(){
		$wb_member_id = (int)member('Id');
		$wb_member_address_id = (int)$_POST['wb_member_address_id'];
		$wb_member_billing_id = (int)$_POST['wb_member_billing_id'];
		if ($wb_member_id && $wb_member_address_id) {
			$dizi['Shipping'] = str::code(db::get_one('wb_member_address', "wb_member_id='{$wb_member_id}' and Type='shipping' and Id='{$wb_member_address_id}'"), 'addslashes');
			$dizi['Billing'] = str::code(db::get_one('wb_member_address', "wb_member_id='{$wb_member_id}' and Type='billing' and Id='{$wb_member_billing_id}'"), 'addslashes');
			foreach (self::$address as $k => $v) {
				self::$address[$k] = array(
					// 'Name' => $dizi[$k]['Name'],
					'Gender' => $dizi[$k]['Gender'],
					'FirstName' => $dizi[$k]['FirstName'],
					'LastName' => $dizi[$k]['LastName'],
					'Address' => $dizi[$k]['Address'],
					'Country' => $dizi[$k]['Country'],
					'Province' => $dizi[$k]['Province'],
					'City' => $dizi[$k]['City'],
					'Town' => $dizi[$k]['Town'],
					'Postcode' => $dizi[$k]['Postcode'],
					'Phone' => $dizi[$k]['Phone'],
					'Email' => $dizi[$k]['Email'],
					'Type' => strtolower($k),
				);
			}
		} else {
			foreach (self::$address as $k => $v) {
				self::$address[$k] = array(
					// 'Name' => $_POST[$k.'Name'],
					'FirstName' => $_POST[$k.'FirstName'],
					'LastName' => $_POST[$k.'LastName'],
					'Address' => $_POST[$k.'Address'],
					'Country' => $_POST[$k.'Country'],
					'Province' => $_POST[$k.'Province'],
					'City' => $_POST[$k.'City'],
					'Town' => $_POST[$k.'Town'],
					'Postcode' => $_POST[$k.'Postcode'],
					'Phone' => $_POST[$k.'Phone'],
					'Email' => $_POST[$k.'Email'],
					'Type' => strtolower($k),
				);
			}
		}
		if (!self::$address['Shipping']['Email'] && !self::$address['Shipping']['Phone']) {
			str::msg('请填写联系信息');
		}
		if (!self::$address['Shipping']['Country'] && !self::$address['Shipping']['Province'] && !self::$address['Shipping']['Address']) {
			str::msg('地址有误');
		}
		if (!$_POST['OpenBilling']) {
			self::$address['Billing'] = self::$address['Shipping'];
			self::$address['Billing']['Type'] = 'billing';
		}
	}

	// 当会员没有地址的时候,将此地址收录到默认
	public static function insert_member_address(){
		$wb_member_id = (int)member('Id');
		foreach (self::$address as $k => $v) {
			$length = db::get_row_count('wb_member_address', "wb_member_id='{$wb_member_id}' and Type='{$v['Type']}'");
			if ($length==0) {
				$v['wb_member_id'] = $wb_member_id;
				$v['IsDefault'] = 1;
				db::insert('wb_member_address', $v);	
			}
		}
	}

	// 插入订单
	public static function insert(){
		if ($_POST['Email'] || $_POST['Tel']) {
			$Email = $_POST['Email'];
			$Tel = $_POST['Tel'];
		} else {
			$Email = member('Email');
			$Tel = member('Phone');
		}
		$orders = array(
			'OrderNumber'			=> db::randcode('wb_orders', 'OrderNumber'),
			'wb_member_id'			=> member('Id'),
			'session_id'			=> c('session_id'),
			'Price'					=> (float)self::$cart['price_total_allow'],	//总价格
			'Qty'					=> (float)self::$cart['qty_total_allow'],	//总数量
			'Weight'				=> (float)self::$cart['weight_total_allow'],	//总重量
			'IntegralPrice'			=> (float)self::$cart['price_integral'],	//积分抵扣
			'FreeDiscount'			=> 1,
			'FreeMoney'				=> 0,
			'PayAdditionalFee'		=> 0,	//手续费
			'Payment'				=> $_POST['Payment'],  //支付方式
			'PayTime'				=> 0,	//支付时间
			'ShippingType'			=> self::$shipping['Name'],	//配送方式id
			'ShippingPrice'			=> (float)self::$cart['price_shipping'],	//运费
			'AddTime'				=> c('time'),
			'EditTime'				=> c('time'),
			'Ip'					=> ip::get(),
			'Status'				=> 0,
			'Email'					=> $Email,
			'Tel'					=> $Tel,
			'Message'				=> $_POST['Message'],  //订单留言备注
		);
		if (self::$coupon) {
			$orders['FreeType'] = self::$coupon['FreeType'];
			$orders['FreeDiscount'] = self::$coupon['FreeType']==1?self::$coupon['FreeDiscount']:1;
			$orders['FreeMoney'] = self::$coupon['FreeType']==1?0:self::$coupon['FreeMoney'];
		}
		$orders['TotalPrice'] = price::orders($orders);
		self::$wb_orders_id = db::insert('wb_orders', $orders);
		self::$OrderNumber = $orders['OrderNumber'];
		// 录入地址
		$wb_member_id = (int)member('Id');
		foreach (self::$address as $k => $v) {
			$v['wb_orders_id'] = self::$wb_orders_id;
			db::insert('wb_orders_address', $v);
		}
		// 修改优惠券使用次数
		if (self::$coupon) {
			db::update('wb_orders_coupon',"Id='".self::$coupon['Id']."'",array(
				'UseQty'	=> self::$coupon['UseQty']-1,
			));
		}
		// 产品录入
		$cart_id = '0';
		foreach (self::$cart['children'] as $v) {
			if ($v['IsSaleOut']) {
				continue;
			}
			$cart_id .= ",".$v['Id'];
			$img_path = img::cut($v['Picture'], 100, 100, 0, 0, c('orders_file').date('/Ymd/',c('time')).basename($v['Picture']));
			db::insert('wb_orders_products', array(
				'wb_orders_id'	=> self::$wb_orders_id,
				'wb_products_id'=> (int)$v['wb_products_id'],
				'Category'		=> addslashes($v['Category']),
				'Parameter'		=> addslashes(str::json($v['Parameter'])),
				'wb_products_parameter_id' => addslashes($v['wb_products_parameter_id']),
				'Name'			=> addslashes($v['Name']),
				'SKU'			=> addslashes($v['SKU']),
				'Weight'		=> (float)$v['Weight'],
				'Picture'		=> addslashes($img_path),
				'Price'			=> (float)$v['Price'],
				'Qty'			=> (int)$v['Qty'],
				'Remark'		=> addslashes($v['Remark'])
			));
		}
		//删除购物车的物品
		db::delete('wb_orders_cart', "Id in({$cart_id})");
	}
	// 
}

checkout_api::init();
?>