<?php
// 订单配置
m('wb_orders', array(
	'status' => array(
		'unpay' => '未付款',
		'pay' => '已付款',
		'wait' => '待发货',
		'unshipping' => '未发货',
		'shipping' => '已发货',
		'received' => '已收到',
		'finished' => '已完成',
	),
	'rechange' => array(
		'1' => '换货',
		'2' => '退货',
	),
	'coupon' => array(
		'0' => '减现金',
		'1' => '折扣',
	),
	'pay' => array(
		'alipay' => array(
			'name' => '支付宝支付',
			'url' => '/api/pay/alipay/',
			'popup' => '/api/pay/alipay/',
			'mini_pic' => '/images/pay/alipay/mini.png',
			'brief' => '選擇後，您將被重定向到微信支付',
		),
		'wxpay' => array(
			'name' => '微信支付',
			'url' => '/api/pay/wxpay/',
			'popup' => '/api/pay/wxpay/',
			'mini_pic' => '/images/pay/wxpay/mini.png',
			'brief' => '選擇後，您將被重定向到微信支付',
		),
		'unipay' => array(
			'name' => '银联支付',
			'url' => '/api/pay/unipay/',
			'popup' => '/api/pay/unipay/',
			'mini_pic' => '/images/pay/unipay/mini.png',
			'brief' => '選擇後，您將被重定向到微信支付',
		),
		/*'offline' => array(
			'name' => '线下支付',
		),*/
	),
	'cancel_type' => array(
		'error' => '我落錯了單',
		'other_web_goods' => '我在其他網站上找到了一些不錯的商品',
		'other_goods' => '我想選擇另一種產品',
		'overbooked' => '我多訂了一份',
		'too_long' => '我等得太久了',
		'other' => '其他原因',
	),
));
// 会员配置
m('wb_member', array(
	'gender' => array(
		'A' => '保密',
		'B' => '男',
		'G' => '女',
	),
	'level' => array(
        '1' => '白金會員',
        '2' => '黃金會員',
        '3' => '鑽石會員',
    ),
));
// 自定义页面
// 语言包在 /manage/__/lang/cn/dbs.php 那个文件
// m('ZiDingYiYeMian', array('products', 'case', 'team', 'about', 'contact-us', 'server', 'blog'));
m('ZiDingYiYeMian', array('smart', 'megacloud', 'mold', 'automation', 'network', 'service', 'download', 'about', 'technology', 'production', 'responsibility', 'invest', 'contact'));
?>