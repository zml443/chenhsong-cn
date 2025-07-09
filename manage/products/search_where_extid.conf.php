<?php
$db_config = array(
	'dbc' => array(
		'Name' => array(
			'Type' => 'text',
			'Sql' => array('varchar(200)', ''),
			'Group' => 0
		),
		'wb_products_search_where_id' => array(
			'Type' => 'bind-id',
            'Sql' => array('int(11)', '0'),
            // 'IsBindId' => 1,
		),
		'wb_products_id' => array(
            'Sql' => array('text', ''),
		),
	),
);
return $db_config;
?>