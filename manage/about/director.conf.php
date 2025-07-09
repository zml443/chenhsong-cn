<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
            'Class' => 'w2'
		),
        'Job' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
            'Class' => 'w2'
		),
		'Brief' => array(
			'Type' => 'text',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'BriefDescription2' => array(
            'Name' => '详情页-介绍',
            'Tip' => "橙色字体，用span标签包住",
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),

		'Job2' => array(
			'Name' => '职位',
			'Type' => 'textarea',
			'Sql' => array('varchar(500)'),
			'Lang' => 1,
			'Group' => '个人荣誉',
		),
		'wb_glory_id'  => array(
            'Name' => '荣誉',
			'Tip'  => '保存后请刷新一次',
            'Type' => '/manage/about/index/_tool_catalog',
			'Sql'  => array('text',''),
			'Table'=> array('about/glory'),
			'Cfg'  => array(
				'ma'  => 'about/glory',
				'name'=> 'Name',
			),
			'Group' => '个人荣誉',
        ),
		'wb_service_id'  => array(
            'Name' => '社会服务',
			'Tip'  => '保存后请刷新一次',
            'Type' => '/manage/about/index/_tool_catalog',
			'Sql'  => array('text',''),
			'Table'=> array('about/service'),
			'Cfg'  => array(
				'ma'  => 'about/service',
				'name'=> 'Name',
			),
			'Group' => '个人荣誉',
        ),
        
        'Data' => array(
            'Name' => '介绍',
			'Tip' => '一张图片，推荐尺寸为 743*auto 像素；橙色字体，用span标签包住',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'pic' => array(
					'Name' => '图片',
					'Type' => 'img',
				),
				'pictxt' => array(
					'Name' => '图片介绍',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'name' => array(
					'Name' => '文本1',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'txt' => array(
					'Name' => '文本2',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
            'Count' => 2,
			'Group' => '介绍',
		),

        'Data2' => array(
            'Name' => '生平',
			'Tip' => '',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'name' => array(
					'Name' => '文本1',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'txt' => array(
					'Name' => '文本2',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
			'Group' => '生平',
		),

        // 'Data3' => array(
        //     'Name' => '图文介绍',
		// 	'Tip' => '一张图片，推荐尺寸为 376*282 像素',
		// 	'Type' => 'json',
		// 	'Sql' => array('text',''),
		// 	'Cfg' => array(
		// 		'pic' => array(
		// 			'Name' => '图片',
		// 			'Type' => 'img',
		// 		),
		// 		'txt' => array(
		// 			'Name' => '文本',
		// 			'Type' => 'text',
        //             'Lang' => 1,
		// 		),
		// 	),
		// 	'Add' => 1,
		// ),
        'wb_director_id'  => array(
            'Name' => '图文列表',
			'Tip'  => '保存后请刷新一次',
            'Type' => '/manage/about/index/_tool_catalog',
			'Sql'  => array('text',''),
			'Table'=> array('about/list'),
			'Cfg'  => array(
				'ma'  => 'about/list',
				'name'=> 'Name',
			),
			'GroupRight' => '图文列表',
        ),

		// 'wb_honor_id'  => array(
        //     'Name' => '个人荣誉',
		// 	'Tip'  => '保存后请刷新一次',
        //     'Type' => '/manage/about/index/_tool_catalog',
		// 	'Sql'  => array('text',''),
		// 	'Table'=> array('about/glory'),
		// 	'Cfg'  => array(
		// 		'ma'  => 'about/glory',
		// 		'name'=> 'Name',
		// 	),
		// 	'GroupRight' => '个人荣誉',
        // ),

        
        'IsPic' => array(
            'Name' => '铭记-图文展示',
            'Type' => 'open',
            'Sql' => array('int(1)', '0'),
			'Group' => '铭记',
        ),
        'Data4' => array(
            'Name' => '铭记',
			'Tip' => '图一推荐尺寸为 799*543 像素，图二推荐尺寸为 84*403 像素；橙色字体，用span标签包住',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'pic' => array(
					'Name' => '大图',
					'Type' => 'img',
				),
                'pic2' => array(
					'Name' => '小图',
					'Type' => 'image',
					'Lang' =>  1
				),
				'txt' => array(
					'Name' => '文本',
					'Type' => 'textarea',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
			'Count' => 1,
			'Group' => '铭记',
		),

        'Pictures' => array(
            'Name'=>'封面图',
			'Tip' => '一张图片，推荐尺寸控制在 700*857 像素内',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
					'Lang' => 1,
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
					'Lang' => 1,
				)
            ),
            'Group' => '图片',
		),
        'Picture' => array(
			'Tip' => '位置在最后一个模块；一张图片，推荐尺寸为 1920*780 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
					'Lang' => 1,
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
					'Lang' => 1,
				)
            ),
            'Group' => '图片',
		),

		
	),
);
return $db_config;
?>