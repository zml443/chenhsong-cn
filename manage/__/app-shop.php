<?php
return array(
	// 默认栏
	'_' => array(
		'wb_products' => 1,
	),
	// 展示栏
	'products' => array(
		// 产品
		'wb_products' => array(
			'used' => 1, //默认使用
			'key' => 'products',
			'children' => array(
				'wb_products_search' => array(
					'key' => 'products.search',
				),
				// 产品评论
				'wb_products_comment' => array(
					'key' => 'products.comment',
				),
				// 产品品牌
				'wb_products_brand' => array(
					'key' => 'products.brand',
				),
			),
		),
	),
	'other' => array(
		// 问答
		'wb_faq' => array(
			'key' => 'app.faq',
		),
		// 在线客服
		'wb_service' => array(
			'key' => 'app.service',
		),
		// 服务
		'wb_server' => array(
			'key' => 'app.server',
		),
		// 分公司
		'wb_join_branches' => array(
			'key' => 'app.branches',
		),
		// 博客
		'wb_blog' => array(
			'key' => 'app.blog',
		),
		// 发展历程
		'wb_history' => array(
			'key' => 'app.history',
		),
		/*// 企业文化
		'wb_corporate_culture' => array(
			'key' => 'app.culture',
		),*/
		// 合作伙伴
		'wb_partner' => array(
			'key' => 'app.partner',
		),
		// 合作伙伴
		'wb_links' => array(
			'key' => 'app.links',
		),
		// 下载
		'wb_download' => array(
			'key' => 'app.download',
		),
		// 酒店
		'wb_hotel' => array(
			'key' => 'app.hotel',
		),
	),
);