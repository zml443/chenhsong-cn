<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
            'Lang' => 1
		),  
		'wb_director_id' => array(
			'Type' => 'bind-id',
			'Sql'   => array('int(11)','0'),
		),
        'Data' => array(
            'Name' => '介绍',
			'Type' => 'json',
			'Sql' => array('text',''),
			'Cfg' => array(
                'year' => array(
					'Name' => '时间',
					'Type' => 'text',
					'Lang' => 1,
				),
				'brief' => array(
					'Name' => '介绍',
					'Type' => 'text',
					'Lang' => 1,
				),
			),
			'Add' => 1,
		),
	)
);
return $db_config;
?>