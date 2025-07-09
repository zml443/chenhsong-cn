<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
			'Lang' => 1,
		),
		'Brief' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'BriefDescription2' => array(
            'Name' => '文本',
			'Type' => 'textarea',
			'Sql' => array('text'),
			'Lang' => 1
		),
		'Pictures' => array(
			'Name' => '封面图',
			'Tip' => '一张图，建议尺寸为 460*550 像素',
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
	),
);
return $db_config;
?>