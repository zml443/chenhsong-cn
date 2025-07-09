<?php
$db_conf = array(
	'dbc' => array(
		'wb_member_id' => array(
	        'Sql'  => array('int(1)','0'),
		),
		'wb_orders_coupon_id' => array(
	        'Sql'  => array('int(1)','0'),
		),
		'Name' => array(
			'Name' => language('{/dbs.field.coupon_code/}'),
	        'Type' => '/manage/orders/coupon/_tool_memberId',
	        'Sql'  => array('varchar(20)','0'),
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'NameCombined' => array('Sql' => array('int(1)','0')),
	        ),
			'NotNull' => 1,
			'NotRepeat' => 1,
			'AddSave' => 1
		),
	    'EfTime' => array(
	        'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'EfTime0' => array('Sql' => array('int(11)','0')),
	        	'EfTime1' => array('Sql' => array('int(11)','0')),
	        ),
		),
		'UsePro' => array(
			// 'Name' => '适用产品',
	        'Type' => 'products',
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'UseProType' => array('Sql' => array('varchar(30)','')),
	        	'UseProId' => array('Sql' => array('text','')),
	        	'UseProCategory' => array('Sql' => array('varchar(100)','')),
	        	'UseProDetailShow' => array('Sql' => array('int(1)','0')),
	        ),
			'Group' => language('{/dbs.group.ScopeOfUse/}'),
	        // 'List' => 1,
		),
		'Free' => array(
			// 'Name' => language('{/orders.free/}'),
			'Type' => 'free',
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'FreeType' => array('Sql'=>array('varchar(10)','0')),
				'FreeDiscount' => array('Sql'=>array('int(10)', 0)),
				'FreeMoney' => array('Sql'=>array('numeric(10,2)', '0.00')),
			),
			'Group' => language('{/dbs.group.CouponType&ConditionsForUse/}'),
	        // 'List' => 1,
		),
	    'Full' => array(
			// 'Name' => language('{/orders.coupon_where/}'),
	        'Type' => '/manage/orders/coupon/_tool_useRule',
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'FullType' => array('Sql'=>array('varchar(10)','')),
				'FullNumber' => array('Sql'=>array('int(11)', '0')),
				'FullMoney' => array('Sql'=>array('numeric(10,2)', '0.00')),
			),
			'Group' => language('{/dbs.group.CouponType&ConditionsForUse/}'),
	        // 'List' => 1,
		),
		'UseQty' => array(
			'Class'=> 'w2',
			// 'Name' => '每人使用次数',
	        'Type' => '/manage/orders/coupon/_tool_useQty',
	        'Sql' => array('int(11)',''),
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'UseQtyType' => array('Sql'=>array('int(1)','0')),
			),
			'Group' => language('{/dbs.group.UsageRules/}'),
	        'List' => 1,
		),
		'IsUesd' => array(
			'Name' => '是否使用',
		    'Type' => '/manage/orders/coupon/_tool_sendType',
			'Sql' => array('int(1)','0'),
		),
	),
);


return $db_conf;