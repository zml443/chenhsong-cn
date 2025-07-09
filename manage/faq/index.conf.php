<?php

$db_config = array(
	'dbc' => array(
		'Language' => 1,
		'Name' => array(
			'Name' => language('{/dbs.field.Question/}'),
			'Type' => 'text',
			'Sql' => array('varchar(200)'),
			'NotNull' => 1
		),
		'wb_faq_category_id' => array(
			'Name' => language('{/dbs.field.Category/}'),
			'Type' => 'category',
			'Table' => 'faq/category',
			'Sql' => array('int(11)',''),
			'GroupRight' => language('{/dbs.field.Category/}'),
		),
		'AddTime' => array(
			'Type' => 'day',
			'Sql' => array('int(11)', '0'),
		),
		'BriefDescription' => array(
			'Name' => language('{/dbs.field.Answer/}'),
			'Type' => 'textarea',
			'Sql' => array('text'),
		),
	)
);
return $db_config;
?>