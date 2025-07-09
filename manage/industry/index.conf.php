<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'List' => '名称',
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),

		'Attr' => array(
			'Type' => 'attr',
			'Args' => array(
				'IsSaleOut'=> language('{/global.sale_out/}'),
			),
			'List' => 1,
			'Search' => 1,
			'GroupRight' => 'attr',
		),
        
        'Data' => array(
            'Name' => '技术优势',
            'Tip' => '一张图片，推荐尺寸为 1020*520 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'title' => array(
					'Name' => '标题',
					'Type' => 'text',
				),
				'brief' => array(
					'Name' => '简介',
					'Type' => 'text',
				),
				'pic' => array(
					'Name' => '图片',
					'Type' => 'img',
				),
			),
			'Add' => 1,
		),

		'wb_application_id'  => array(
            'Name' => '应用案例',
			'Tip'  => '保存后请刷新一次',
            'Type' => '/manage/industry/index/_tool_catalog',
			'Sql'  => array('text',''),
			'Table'=> array('industry/application'),
			'Cfg'  => array(
				'ma'  => 'industry/application',
				'name'=> 'Name',
			),
			'IsExtId' => 1,
            'Group' => "关联",
        ),

		'wb_cases_id' => array(
			'Name' => '客户案例',
			'Tip' => '没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('blog/index&wb_blog_category_id=4'),
			'Cfg' => array(
				'ma' => "blog/index&wb_blog_category_id=4",
				'name' => 'Name',
			),
            'Group' => "关联",
		),
        'wb_products_id' => array(
			'Name' => '推荐机型',
			'Tip' => '没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('products/index'),
			'Cfg' => array(
				'ma' => "products/index",
				'name' => 'Name',
			),
            'Group' => "关联",
		),
        'wb_automation_id' => array(
			'Name' => '相关自动化',
            'Tip' => '前端仅展示3个,没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('factory/automation'),
			'Cfg' => array(
				'ma' => "factory/automation",
				'name' => 'Name',
			),
            'Group' => "关联",
		),
		'wb_blog_id' => array(
			'Name' => '相关资讯',
			'Tip' => '没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('blog/index'),
			'Cfg' => array(
				'ma' => "blog/index",
				'name' => 'Name',
			),
            'Group' => "关联",
		),

		'Picture' => array(
            'Name' => '封面图-列表',
			'Type' => 'image',
            'Tip' => '一张图，推荐尺寸为 1600*600 像素',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
				)
            ),
            'Group' => "图片",
		),
		'Pictures4' => array(
            'Name' => '封面图-列表(小)',
			'Type' => 'image',
            'Tip' => '展示在推荐模块，一张图，推荐尺寸为 377*260 像素',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
				)
			),
            'Group' => "图片",
		),
		'Pictures' => array(
            'Name' => '广告图',
			'Type' => 'image',
            'Tip' => '图一为PC端，推荐尺寸为 1920*960 像素；图二为移动端，推荐尺寸为 750*960 像素',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
				)
			),
            'Group' => "图片",
		),
		// 'Pictures2' => array(
        //     'Name' => '应用案例',
		// 	'Type' => 'image',
        //     'Tip' => '一张图，推荐尺寸为 1600*645 像素',
		// 	'Sql' => array('text',''),
		// 	'Cfg' => array(
		// 		'alt' => array(
		// 			'Name' => 'alt',
		// 			'Type' => 'text',
        //         ),
		// 		'title' => array(
		// 			'Name' => 'title',
		// 			'Type' => 'text',
		// 		)
		// 	),
        //     'Group' => "图片",
		// ),
        'Pictures3' => array(
            'Name' => '图标',
			'Type' => 'image',
            'Tip' => '一张图，推荐尺寸为 26*26 像素，格式为 svg',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
				)
			),
            'Group' => "图片",
		),
        'Seo'    => 1,
	)
);
return $db_config;
?>