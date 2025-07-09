<?php

$db_config = array(
	'dbc' => array(
		// 'Language' => 1,
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
		),
		'wb_industry_id' => array(
			'Type' => 'bind-id',
			'Sql'   => array('int(11)','0'),
		),
		'BriefDescription' => array(
			'Type' => 'textarea',
			'Sql' => array('text','')
		),
        'Pictures' => array(
            'Name'=>'背景图',
			'Tip' => '一张图片，推荐尺寸控制在 505*300 像素',
			'Type' => 'image',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text'
				)
            ),
		),
	)
);
return $db_config;
?>