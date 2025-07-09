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
		'BriefDescription' => array(
			'Tip' => '换行为一人',
			'Type' => 'textarea',
			'Sql' => array('text'),
            'Lang' => 1
		),
	)
);
return $db_config;
?>