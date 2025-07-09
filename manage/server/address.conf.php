<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(100)', ''),
            'Lang' => 1,
            'NotNull' => 1
        ),
        'Data' => array(
            'Name' => '地区',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
				'name' => array(
					'Name' => '文本',
					'Type' => 'text',
                    'Lang' => 1,
				),
			),
			'Add' => 1,
		),
    ),
);
return $db_config;
?>