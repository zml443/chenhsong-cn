<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
            'Lang' => 1
		),
        'Type' => array(
            'Name' => '类型',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'List' => 'name',
            'Lang' => 1
		),
        'Address' => array(
            'Name' => '联系地址',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1
		),
        'Phone' => array(
            'Name' => '联系电话',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
		),
        'Pictures' => array(
			'Name' => '封面图',
			'Tip' => '一张图，最大尺寸为 1080*650 像素，推荐尺寸为 680*480 像素',
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
	)
);
return $db_config;
?>