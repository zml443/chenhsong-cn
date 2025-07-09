<?php

$db_config = array(
	// 'open_copy' => 0, //开启草稿功能
	'dbc' => array(
		'Language' => 1,
		// 'IsUnpublished' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Url' => array(
			'Name' => '外链',
			'Tip'  => '外链优先',
			'Type' => 'text',
			'Sql' => array('text', ''),
		),
		// 'PageUrl' => array(
		// 	'Type' => 'pageurl',
		// 	'Tip' => language('{/notes.custom_url/}'),
		// 	'Sql' => array('varchar(200)', ''),
		// ),
		'wb_blog_category_id' => array(
			'Name' => '类别',
			'Type' => 'category',
			'Table'	=> 'blog/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
		),
		'Attr' => array(
		    'Type' => 'attr',
		    'Args' => array(
		        'IsHot'=> language('{/global.is_hot/}'),
		        'IsIndex'=> language('{/global.is_index/}'),
		        'IsSaleOut'=> '下架',
		    ),
		    'List' => 1,
		    'Search' => 1,
		    'GroupRight' => 'attr',
		),
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)'),
		),

		'wb_blog_id' => array(
			'Name' => '相关资讯',
			'Tip' => '没有勾选默认显示同分类最新的5个',
			'Type' => 'bind',
			'Sql' => array('text',''),
			'Table' => array('blog/index'),
			'Cfg' => array(
				'ma' => "blog/index",
				'name' => 'Name',
			),
            'Group' => "关联",
		),
		// 'wb_products_id' => array(
		// 	'Name' => '推荐产品',
		// 	'Tip' => '没有勾选默认显示最新的4个',
		// 	'Type' => 'bind',
		// 	'Sql' => array('text',''),
		// 	'Table' => array('products/index'),
		// 	'Cfg' => array(
		// 		'ma' => "products/index",
		// 		'name' => 'Name',
		// 	),
        //     'Group' => "关联",
		// ),
		// 'wb_industry_id' => array(
		// 	'Name' => '推荐方案',
		// 	'Tip' => '没有勾选默认显示最新的4个',
		// 	'Type' => 'bind',
		// 	'Sql' => array('text',''),
		// 	'Table' => array('industry/index'),
		// 	'Cfg' => array(
		// 		'ma' => "industry/index",
		// 		'name' => 'Name',
		// 	),
        //     'Group' => "关联",
		// ),

		'Pictures' => array(
			'Name' => '封面图',
			'Tip' => '建议尺寸为 506*346 像素',
			'Type' => 'image',
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
		),
		'Picture' => array(
			'Name' => '热门',
			'Tip' => '建议尺寸为 1050*575 像素，不传，默认显示 封面图',
			'Type' => 'image',
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
			'List' => 0
		),
		'Video' => array(
			'Name' => '视频',
			'Type' => 'image',
			'Sql' => array('text',''),
		),
		'Seo' => 1,
		
		'Detail' => array(
			'Type' => 'editor',
		),
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
	)
);
return $db_config;
?>