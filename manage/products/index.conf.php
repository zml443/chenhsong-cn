<?php

// index.conf.php

$db_config = array(
	// 'open_copy' => 1, //草稿功能
	'dbc' => array(
		'Language' => 1,
		// 'IsUnpublished' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
			'Search' => '%',
		),
		'Model' => array(
			'Name' => '型号',
			'Type' => 'text',
			'Sql' => array('varchar(200)',''),
		),
		'BriefDescription' => array(
			'Name' => language('{/orders.products_description/}'),
			'Type' => 'textarea',
			'Sql' => array('text','')
		),
		'Brief' => array(
			'Name' => "说明",
			'Type' => 'textarea',
			'Sql' => array('text','')
		),
		
        'Data' => array(
            'Name' => '核心价值',
			'Tip' => '一张图片，推荐尺寸控制在 75*75 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'icon' => array(
					'Name' => '图标',
					'Type' => 'img',
				),
				'name' => array(
					'Name' => '文本',
					'Type' => 'textarea',
				),
				'brief' => array(
					'Name' => '文本2',
					'Type' => 'textarea',
				),
			),
			'Add' => 1,
		),

		'Data2' => array(
            'Name' => '技术优势',
			'Tip' => '一张图片，推荐尺寸控制在 1496*861 像素',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'pic' => array(
					'Name' => '图片',
					'Type' => 'img',
				),
				'name' => array(
					'Name' => '文本',
					'Type' => 'text',
				),
				'brief' => array(
					'Name' => '文本2',
					'Type' => 'textarea',
				),
			),
			'Add' => 1,
		),
		
        'wb_cases_id'  => array(
            'Name' => '应用案例',
			'Tip'  => '保存后请刷新一次',
            'Type' => '/manage/products/index/_tool_catalog',
			'Sql'  => array('text',''),
			'Table'=> array('products/cases'),
			'Cfg'  => array(
				'ma'  => 'products/cases',
				'name'=> 'Name',
			),
			'IsExtId' => 1
        ),
		'wb_industry_id' => array(
			'Name' => '适用行业',
			'Tip' => '没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('industry/index'),
			'Cfg' => array(
				'ma' => "industry/index",
				'name' => 'Name',
			),
            'Group' => '关联',
		),
		'wb_blog_id' => array(
			'Name' => '客户案例',
			// 'Tip' => '没有勾选默认显示最新的6个',
			'Tip' => '没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('blog/index&wb_blog_category_id=4'),
			'Cfg' => array(
				'ma' => "blog/index&wb_blog_category_id=4",
				'name' => 'Name',
			),
            'Group' => '关联',
		),
		'wb_automation_id' => array(
			'Name' => '相关自动化',
			'Tip' => '没有勾选不显示',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('factory/automation'),
			'Cfg' => array(
				'ma' => "factory/automation",
				'name' => 'Name',
			),
            'Group' => '关联',
		),

		'Pictures' => array(
			'Name' => '产品图集',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
					'Lang' => 1
				),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
					'Lang' => 1
				)
			),
			'Group' => '图片',
		),
		'Pictures2' => array(
			'Name' => '详情页背景图',
			'Tip' => '一张图片，推荐尺寸为 1920*960 像素，图二为移动端，推荐尺寸为 750*960 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Group' => '图片',
		),
		
		'wb_products_category_id' => array(
			'Name' => language('{/global.category/}'),
			'Type' => 'category',
			'Table' => 'products/category',
			'Sql' => array('varchar(200)', '0'),
			// 'Add' => 1,
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
		),
		'Attr' => array(
			'Type' => 'attr',
			'Args' => array(
				'IsSaleOut'=> language('{/global.sale_out/}'),
				// 'IsHot'=> language('{/global.is_hot/}'),
			),
			'List' => 1,
			'Search' => 1,
			'GroupRight' => 'attr',
		),
		

		'Seo' => 1,
		'data_number_views' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_day' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_week' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_views_month' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_collection' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_sell' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_sell_day' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_sell_week' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_sell_month' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_comment' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_comment_day' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_comment_week' => array(
			'Sql' => array('int(11)', 0)
		),
		'data_number_comment_month' => array(
			'Sql' => array('int(11)', 0)
		),

		/*
			'_where_extid_add' => array(
				'Type' => 'where_extid',
				'GroupRight' => 'attr',
				'UnSet' => !a('wb_products_search')
			),
			'Star' => array(
				'Sql' => array('numeric(3,1)', '10.0')
			),
			'PageUrl' => array(
				'Type' => 'pageurl',
				'Tip' => language('{/notes.custom_url/}'),
				'Sql' => array('varchar(200)', ''),
			),
			'wb_products_brand_id' => array(
				'Type' => 'category',
				'Table' => 'products/brand',
				'Sql' => array('int(10)', '0'),
				'GroupRight' => 'attr',
				'List' => 'name',
				'Search' => 1,
				'UnSet' => !g('app_store.products.wb_products_brand')
			),
			'wb_products_parameter' => array(
				'Name' => language('{/orders.products_parameter/}'),
				'Type' => '/manage/products/index/_tool_parameter',
				'Group' => 'parameter',
				// 'GroupTip' => '分组的提示语',
				'Field'=> array(
					'ProPriceType' => array('Sql'=>array('int(1)','0')),
					'wb_products_parameter' => array('Sql'=>array('text','')),
					'wb_products_parameter_price' => array('Sql'=>array('text','')),
					'wb_products_parameter_min_price' => array('Sql'=>array('numeric(10,2)', '0.00')), //'临时价格，用于记录产品属性的最小价格',
					'wb_products_parameter_min_original_price' => array('Sql'=>array('numeric(10,2)', '0.00')), //'临时价格，用于记录产品属性的最小价格',
					'wb_products_parameter_min_cost_price' => array('Sql'=>array('numeric(10,2)', '0.00')), //'临时价格，用于记录产品属性的最小价格',
					'wb_products_parameter_max_price' => array('Sql'=>array('numeric(10,2)', '0.00')), //'临时价格，用于记录产品属性的最大价格',
					'wb_products_parameter_max_original_price' => array('Sql'=>array('numeric(10,2)', '0.00')), //'临时价格，用于记录产品属性的最小价格',
					'wb_products_parameter_max_cost_price' => array('Sql'=>array('numeric(10,2)', '0.00')), //'临时价格，用于记录产品属性的最小价格',
					'wb_products_parameter_total_stock' => array('Sql'=>array('int(11)', '0')), //'总库存',
					'OriginalPrice' => array('Sql'=>array('numeric(10,2)', '0.00')),
					'CostPrice' => array('Sql'=>array('numeric(10,2)', '0.00')),
					'Price' => array('Sql'=>array('numeric(10,2)', '0.00')),
					'Stock' => array('Sql'=>array('int(11)', '0')),
					'Weight' => array('Sql'=>array('numeric(10,3)', '0.000')),
					'SKU' => array('Sql'=>array('varchar(100)', '')),
				),
				'UnSet' => c('HostTag')!='shop'
			),
			'Style' => array(
				'Type' => 'json',
				'Sql' => array('text',''),
				'Cfg' => array(
					'name' => array(
						'Name' => language('{/dbs.field.Name/}'),
						'Type' => 'text',
					),
					'type' => array(
						'Name' => language('{/dbs.field.Type/}'),
						'Type' => 'style',
						'Args' => array(
							array(
								'label' => '风格1',
								'value' => 'style',
								'image' => 'x',
								'url' => '/manage/?ma=blog/index&wb_products_id={{id}}&_alert_side_=1',
							),
							array(
								'label' => '风格2',
								'value' => 'style2',
								'image' => 'z',
								'url' => '/manage/?ma=member/index&wb_products_id={{id}}&_alert_side_=1',
							),
						),
					),
				),
				'Add' => 1
			),
			'Tag' => array(
				'Type' => 'tag',
				'Sql' => array('varchar(255)',''),
				'GroupRight' => 'tag',
			),
			'Editor' => array(
				// 'Name' => language('{/orders.products_editor/}'),
				'Type' => 'Editor',
				// 'Table' => 'products/editor',
				'Url' => array(
					array(
						'name' => language('{/global.editor/}'),
						'url' => '?ma=products/editor',
						'total' => '?ma=products/editor&l=total',
					)
				),
				'ExtId' => 1,
				'Group' => 'editor',
			),
		*/
	),
);

return $db_config;