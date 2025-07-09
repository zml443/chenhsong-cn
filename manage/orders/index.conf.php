<?php


return array(
	'add_to_edit' => 1,
	'dbc' => array(
		'OrderNumber' => array(
			// 'Name' => '{/orders.number/}',
			'Name' => '订单号',
			'Type' => 'randcode',
			// 'HasTable' => array('orders/index'), //订单号比较特殊，必须是唯一的，和其它表的订单号也是不相同的，字段名统一为 OrderNumber
			'Sql' => array('varchar(50)', ''),
			'NotNull' => 1,
			'IsRand' => array(
				'HasTable' => array('orders/index'),
				'Type' => 'number'
			),
			'Search' => '%',
			'List' => 1,
		),
		// 会员id
		'wb_member_id' => array(
			// 'Name' => '{/orders.member/}',
			'Name' => '顾客',
			'Type' => 'member',
			'Table' => 'member/index',
			'Sql' => array('int(11)', '0'),
			'NotNull' => 1,
			'List' => 1,
		),
		// 游客，需要记录session_id
	    'session_id' => array(
			'Sql' => array('varchar(32)', ''),
		),
		// 邮箱
	    'Email' => array(
			'Sql' => array('varchar(255)', ''),
			'List' => 0,
		),
		// 联系电话
	    'Tel' => array(
			'Sql' => array('varchar(50)', ''),
			'List' => 0,
		),
		// 
		'TotalPrice' => array(
			'Name' => '订单总额',
			'Type' => 'price',
			'Sql' => array('numeric(10,2)', '0.00'),
			'EditShow' => 1,
			'List' => 1,
		),
		// 
		'Price' => array(
			'Type' => 'price',
			'Sql' => array('numeric(10,2)', '0.00'),
			'Search' => 1,
		),
		// 
		'Qty' => array(
			'Type' => 'int',
			'Sql' => array('int(11)', '0'),
		),
		// 
		'Free' => array(
			'Type' => 'free',
			'Field' => array(
				'FreeType' => array('Sql'=>array('varchar(2)','0')),
				'FreeDiscount' => array('Sql'=>array('numeric(10,2)','1.00')),
				'FreeMoney' => array('Sql'=>array('numeric(10,2)','0.00')),
			),
		),
		// 积分抵消价格
		'IntegralPrice' => array(
			'Type' => 'price',
			'Sql' => array('numeric(10,2)', '0.00'),
		),
		// 支付
		'Pay' => array(
			// 'Name' => '{/orders.pay.name/}',
			'Name' => '付款状态',
			'Type' => 'wb_orders_pay',
			'Field' => array(
				'PayAdditionalFee' => array('Sql'=>array('numeric(10,2)','0.00')),
				'Payment' => array('Sql'=>array('varchar(20)','')),
				'PayTime' => array('Sql'=>array('int(11)','0')),
			),
			'Search' => 1,
			'List' => 1,
		),
		// 重量
		'Weight' => array(
			'Type' => 'weight',
			'Sql' => array('numeric(10,3)', '0.00'),
		),
		// 包裹费用
		'PackingPrice' => array(
			'Type' => 'price',
			'Sql' => array('numeric(10,2)', '0.00'),
		),
		// 发货
		'Shipping' => array(
			'Table' => 'shipping/index', // 选择运货方式
			'Type' => 'wb_orders_shipping', // 计算运费，需要配合orders/shipping_address
			'Field' => array(
				'ShippingType' => array('Sql'=>array('varchar(100)','')), //配送方式
				'ShippingPrice' => array('Sql'=>array('numeric(10,2)','0.00')),
				'ShippingAddressType' => array('Sql'=>array('varchar(20)','')), // country   china
				'ShippingTime' => array('Sql'=>array('int(11)','0')), // 发货时间
				'ReceiveTime' => array('Sql'=>array('int(11)', 0)), //收到时间
			),
		),
		// 状态
		'Status' => array(
			'Name' => '订单状态',
			'Type' => 'wb_orders_status',
			'Table'=> 'orders/shipping_info', //收货状态需要记录发货信息
			'Field'=> array(
				'Status' => array('Sql'=>array('varchar(20)','unpay')),
				'RechangeAllow' => array('Sql'=>array('varchar(2)','')), // N Y
				'RechangeType' => array('Sql'=>array('varchar(50)','')),
				'RechangeStatus' => array('Sql'=>array('varchar(2)','')),
				'RechangeText' => array('Sql'=>array('text','')),
				'RechangeTime' => array('Sql'=>array('int(11)','0')),
				'RechangePicture' => array('Sql'=>array('text','')),
				'RefundAllow' => array('Sql'=>array('varchar(2)','')), // N Y
				'RefundType' => array('Sql'=>array('varchar(50)','')),
				'RefundStatus' => array('Sql'=>array('varchar(2)',0)),
				'RefundText' => array('Sql'=>array('text','')),
				'RefundTime' => array('Sql'=>array('int(11)','0')),
				'CancelStatus' => array('Sql'=>array('int(1)',0)), //取消原因类型
				'CancelType' => array('Sql'=>array('varchar(50)','')), //取消原因类型
				'CancelText' => array('Sql'=>array('text','')), //取消原因
				'CancelTime' => array('Sql'=>array('int(11)', 0)),
				'CompleteTime' => array('Sql'=>array('int(11)', 0)), //完成时间
			),
			'List' => 1,
		),
		// 订单产品
		'Products' => array(
			'Name' => '产品',
			'Table' => 'orders/products',
			'List' => 1,
		),
		// 判断订单产品是否有评论
		'IsProductsComment' => array(
			'Sql' => array('int(1)', '0')
		),
		// 发票
		'Invoice' => array(
			'Table' => 'orders/invoice',
		),
		// 备注
		'Message' => array(
			'Sql'  => array('text', ''),
		),
        'Ip' => array(
            'Sql' => array('varchar(15)', ''),
        ),
		// 为了帮助生成一个购物车的数据表
		'购物车' => array(
			'Table'=> 'orders/cart',
		),
	),
);