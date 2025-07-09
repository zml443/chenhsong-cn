<?php

class price {
	/**
	 * 货币类型，并且转换汇率
	 * @param {float} $price 价钱
	 * @param {string} 返回类型 默认0：返回汇率符号+价格，1：返回汇率符号，2：返回两位小数点的价格
	 * @return {string|float}
	 */
	public static $rate_current = array();
	public static function rate ($price=0, $type=0) {
		if (!self::$rate_current) {
			if ($_SESSION['exchange_rate_id']) {
				$where = "Id='{$_SESSION['exchange_rate_id']}'";
			} else {
				$where = "`Default`=1";
			}
			self::$rate_current = db::result("select Ico,Rate from wb_site_rate where $where");
		}
		$row = self::$rate_current;
		$price = ((float)$price)*$row['Rate'];
		if (0) {
			$price = floatval($price);
		} else {
			$price = sprintf("%.2f", $price);
		}
		if($type==1) {
			return $row['Ico'];
		} else if($type==2) {
			return $price;
		} else {
			return $row['Ico'].$price;
		}
	}
	

	/**
	 * 订单价格
	 * @param {array} $order 订单数据
	 * @return {float}
	 */
	public static function orders ($order) {
		return ($order['Price']*$order['FreeDiscount']+$order['ShippingPrice'])*(1+$order['PayAdditionalFee']/100) - $order['FreeMoney'] - $order['IntegralPrice'];
	}
}