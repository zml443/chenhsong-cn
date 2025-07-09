<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'Lang' => 1,
            'NotNull' => 1
        ),
        'BriefDescription' => array(
            'Type' => 'textarea',
            'Sql' => array('varchar(500)', ''),
            'Lang' => 1,
        ),
        'Picture' => array(
            'Name' => '图片',
			'Type' => 'image',
            'Tip' => '推荐尺寸为 1600*600 像素',
			'Sql' => array('text',''),
			'Cfg' => array(
				'alt' => array(
					'Name' => 'alt',
					'Type' => 'text',
                    'Lang' => 1,
                ),
				'title' => array(
					'Name' => 'title',
					'Type' => 'text',
                    'Lang' => 1,
				)
            ),
		),
    ),
);
return $db_config;
?>