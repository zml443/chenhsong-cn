<?php
$db_conf = array(
	'edit_to_flush' => 1,
	'add_to_edit' => 1, //添加完成跳转到编辑页
	'dbc' => array(
		// 
		'Name' => array(
			'Name' => language('{/dbs.field.coupon_code/}'),
	        'Type' => '/manage/orders/coupon/_tool_memberId',
	        'Sql'  => array('varchar(20)','0'),
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'NameCombined' => array(
					'Sql' => array('int(1)','0'),
					'NotNull' => 0
				),
	        ),
			'NotNull' => 1,
			'NotRepeat' => 1,
			'AddSave' => 1
		),
	    'EfTime' => array(
	        'Type' => '/manage/orders/coupon/_tool_deadline',
	        'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'EfTimeType' => array('Sql' => array('varchar(20)','')),
	        	'EfTime0' => array('Sql' => array('int(11)','0')),
	        	'EfTime1' => array('Sql' => array('int(11)','0')),
	        	'EfTimeNumber' => array('Sql' => array('int(11)','0')),
	        	'EfTimeUnit' => array('Sql' => array('varchar(10)','')),
	        ),
	        'List' => 1,
		),

		'适用规则列表展示' => array(
		    'Name' => language('{/panel.Applicability/}'),
		    'Type' => '/manage/orders/coupon/_list_full_sale',
		    'List' => 1,
		),
		// 
		'SendType' => array(
			'Name' => '投放方式',
		    'Type' => '/manage/orders/coupon/_tool_sendType',
			'Sql' => array('varchar(20)','self'), //self手动发送、system系统发送
			'Group' => language('{/dbs.group.ScopeOfUse/}'),
			'AddSave' => 1,
		),
	    'Member' => array(
			'Name' => language('{/dbs.field.ApplicableCustomers/}'),
	        'Type' => 'member2',
	        'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'MemberType' => array('Sql' => array('varchar(30)','')),
	        	'MemberGroupType' => array('Sql' => array('varchar(100)','')),
	        	'MemberTag' => array('Sql' => array('text','')),
	        	'MemberId' => array('Sql' => array('text','')),
	        ),
			'Group' => language('{/dbs.group.ScopeOfUse/}'),
	        // 'List' => 1,
		),
		'GetRule' => array(
			'Name' => '领取方式',
	        'Type' => 'radio2',
			'Tip' => '优惠劵显示在会员中心的优惠劵栏目',
			'Sql' => array('varchar(30)',''),
			'Args' => array(
				'register' => array('text' => '完成会员注册'),
				'login' => array('text' => '登录成功'),
				'comment' => array('text' => '顾客评论成功'),
				'receive' => array('text' => '顾客确认收货'),
				'complete' => array(
					'text' => '订单状态已完成',
					'tip' => "包含以下环节：\n1、顾客确认收货\n2、商家将订单状态改为已完成\n3、设置时间系统自动完成订单"
				)
			),
			'Group' => language('{/dbs.group.ScopeOfUse/}'),
	        // 'List' => 1,
		),
		// 
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
		// 
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
		// 
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
		// 
		'DistributionQty' => array(
			'Class'=> 'w2',
			// 'Name' => '发放量',
	        'Type' => '/manage/orders/coupon/_tool_inputQty',
	        'Sql' => array('int(11)',''),
			'Field' => array(
	            // 字段名可以改，但是顺序不能乱
				'DistributionQtyType' => array('Sql'=>array('int(1)','0')),
				'DistributionQtyEd' => array('Sql'=>array('int(11)','0')), //已被领取过的数量
			),
			'Group' => language('{/dbs.group.UsageRules/}'),
	        'List' => 1,
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
		'编辑概览' => array(
		    'Type' => '/manage/orders/coupon/_edit_overview',
		    'AddHide' => 1,
		    'GroupRight' => language('{/dbs.group.Overview/}'),
		),
		'关联表' => array(
		    'Table' => array('orders/coupon_member'),
		)
	),
);


return $db_conf;