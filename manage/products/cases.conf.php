<?php

$db_config = array(
	'dbc' => array(
		// 'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
		),
		'Model' => array(
			'Name' => '机型',
			'Type' => 'text',
			'Sql' => array('varchar(200)',''),
		),
		'wb_products_id' => array(
			'Type' => 'bind-id',
			'Sql'   => array('int(11)','0'),
		),
        'Pictures' => array(
            'Name'=>'封面图',
			'Tip' => '一张图片，推荐尺寸控制在 271*255 像素',
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
        'Data' => array(
            'Name' => '数值',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'name' => array(
					'Name' => '名称',
					'Type' => 'text',
				),
				'brief' => array(
					'Name' => '参数',
					'Type' => 'text',
				),
			),
			'Add' => 1,
		),
	)
);
return $db_config;
?>