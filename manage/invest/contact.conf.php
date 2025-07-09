<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
            'Name' => '股票代码',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
		),

		'Info' => array(
            'Name' => '主要股份过户登记处',
			'Type' => 'textarea',
			'Sql' => array('varchar(500)'),
		),
        'Info2' => array(
            'Name' => '股份过户登记分处',
			'Type' => 'textarea',
			'Sql' => array('varchar(500)'),
			'Lang' => 1
		),
        'Info3' => array(
            'Name' => '注册办事处',
			'Type' => 'textarea',
			'Sql' => array('varchar(500)'),
		),
        'Info4' => array(
            'Name' => '总办事处及主要营业地点',
			'Type' => 'textarea',
			'Sql' => array('varchar(500)'),
			'Lang' => 1
		),
        'Info5' => array(
            'Name' => '企业传讯及投资者关系',
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
        'Data' => array(
            'Name' => '相关职权范围',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'name' => array(
					'Name' => '文本',
					'Type' => 'text',
                    'Lang' => 1,
				),
				'Url' => array(
					'Name' => '链接',
					'Type' => 'text',
				),
			),
			'Add' => 1,
            'Count' => 3
		),
	),
);
return $db_config;
?>