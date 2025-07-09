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
            'Sql' => array('text', ''),
            'Lang' => 1,
        ),
        'Data' => array(
            'Name' => '数据',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'unit' => array(
					'Name' => '数值',
					'Type' => 'unit',
                    'Lang' => 1,
				),
				'name' => array(
					'Name' => '文本',
					'Type' => 'text',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
            'Count' => 3
		),
    ),
);
return $db_config;
?>