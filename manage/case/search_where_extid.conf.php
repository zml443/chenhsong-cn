<?php
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'Group' => 0
		),
		'wb_case_search_where_id' => array(
			'Type' => 'is_ext_id',
            'IsExtId' => 1,
            'Sql' => array('int(11)', '0'),
		),
		'wb_case_id' => array(
            'Sql' => array('text', ''),
		),
	),
);
return $db_config;
?>