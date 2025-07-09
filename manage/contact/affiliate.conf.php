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
        'Email' => array(
            'Name' => '邮箱',
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1,
		),
		'wb_contact_category_id' => array(
			'Name' => '类别',
			'Type' => 'category',
			'Table'	=> 'contact/category',
			'Sql' => array('int(11)', ''),
			'GroupRight' => 'category',
			'List' => 'name',
			'Search' => 1,
		),
	)
);
return $db_config;
?>