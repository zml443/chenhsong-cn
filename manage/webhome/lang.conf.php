<?php

$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
		),
        'Url' => array(
            'Name' => '链接',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			// 'NotNull' => 1,
		),
	)
);
return $db_config;
?>