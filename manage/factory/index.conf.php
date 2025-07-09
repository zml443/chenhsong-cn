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
		'Advantage' => array(
            'Name' => '特点和优势',
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
		'Picture' => array(
            'Name' => '封面图',
			'Type' => 'image',
            'Tip' => '一张图，推荐尺寸为 800*540 像素',
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
            'Group' => '图片',
		),
	)
);
return $db_config;
?>