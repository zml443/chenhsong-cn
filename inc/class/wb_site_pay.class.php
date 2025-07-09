<?php

class wb_site_pay{
	// 获取所有支付方式的信息
	public static function all($_ARG=array()){
		$pay = array(
			'alipay' => array(
				'name' => '支付宝支付',
				'open' => 1,
				'url' => '/api/pay/alipay/?OrderNumber={OrderNumber}',
				'popup' => '/api/pay/alipay/?OrderNumber={OrderNumber}',
				'mini_pic' => '/images/pay/alipay/mini.png',
				'brief' => '選擇後，您將被重定向到微信支付',
			),
			'wxpay' => array(
				'name' => '微信支付',
				'open' => 1,
				'url' => '/api/pay/wxpay/?OrderNumber={OrderNumber}',
				'popup' => '/api/pay/wxpay/?OrderNumber={OrderNumber}',
				'mini_pic' => '/images/pay/wxpay/mini.png',
				'brief' => '選擇後，您將被重定向到微信支付',
			),
			'unipay' => array(
				'name' => '银联支付',
				'open' => 1,
				'url' => '/api/pay/unipay/?OrderNumber={OrderNumber}',
				'popup' => '/api/pay/unipay/?OrderNumber={OrderNumber}',
				'mini_pic' => '/images/pay/unipay/mini.png',
				'brief' => '選擇後，您將被重定向到微信支付',
			),
		);
		return $pay;
	}
}
?>