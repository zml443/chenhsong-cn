<?php
return array(
	'dbc' => array(
		// 
		'Name' => array(
			'Name' => '活动名称',
			'Tip' => '仅后台可见',
	        'Type' => 'text',
			'NotNull' => 0,
	        'Sql' => array('varchar(255)',''),
			'NotRepeat' => 1,
		),
	    'EfTime' => array(
			'Name' => language('{/dbs.field.EfTime/}'),
	        'Type' => 'deadline',
	        'Field' => array(
	            // 字段名可以改，但是顺序不能乱
	        	'EfTime0' => array('Sql' => array('int(11)','0')),
	        	'EfTime1' => array('Sql' => array('int(11)','0')),
	        ),
	        'List' => 1,
		),
		'Time' => array(
            'Name' => '显示时间',
            'Type' => '/manage/notice/index/_tool_time',
            'Sql' => array('int(11)', '0'),
            'EditShow' => 1,
        ),
		'DisplayPage' => array(
            'Name' => '显示页面',
            'Type' => 'checkbox',
            'Sql' => array('int(11)', '0'),
			'Args' => array('首页','产品列表','产品详细页','自定义页面','会员中心','支付成功页'),
            'EditShow' => 1,
        ),
		'Frequency' => array(
            'Name' => '显示频率',
            'Type' => 'radio2',
            'Sql' => array('int(11)', '0'),
			'Args' => array('每周显示一次','每次进入网站显示'),
            'EditShow' => 1,
        ),


		'UseCopupon' => array(
            'Name' => '使用优惠券',
            'Type' => 'select',
            'Sql' => array('int(11)', '0'),
			'Args' => array('L2G4Y2QO','TEB3EJZ3'),
        ),


		'Style' => array(
            'Name' => '风格',
            'Tip' => '以下是风格示意图，实际效果请点击下方“预览”按钮。',
            'Type' => '/manage/notice/index/_tool_style',
            'Sql' => array('varchar(30)', ''),
			'Group' => '内容样式',
        ),


		'Title' => array(
            'Name' => '标题',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
            'EditShow' => 1,
			'Group' => '内容样式',
        ),
		'Brief' => array(
            'Name' => '文案',
            'Type' => 'text',
            'Sql' => array('varchar(200)', ''),
			'Group' => '内容样式',
        ),
		'PcImage' => array(
            'Name' => 'PC端图片',
			'Tip' => '图片建议尺寸：500*500像素',
            'Type' => 'image',
			'Sql' => array('text',''),
			'Group' => '内容样式',
        ),
		'AppImage' => array(
            'Name' => '移动端图片',
            'Tip' => '图片建议尺寸：500*500像素',
            'Type' => 'image',
			'Sql' => array('text',''),
			'Group' => '内容样式',
        ),
	),
);