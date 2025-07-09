<?php
$db_config = array(
	'dbc' => array(
		'wb_orders_id' => array(
			'Sql'  => array('Int(11)', 0),
		),
		'wb_manage_id' => array(
			'Sql'  => array('Int(11)', 0),
		),
		'UserName' => array(
			'Type' => 'text',
			'EditShow' => 1,
		),
		'Module'   => array(
			'Type' => 'text',
			'EditShow' => 1,
			'Sql'  => array('Varchar(32)', ''),
		),
		'Log' => array(
			'Type' => 'text',
			'EditShow' => 1,
			'Sql'  => array('Varchar(180)', ''),
		),
        'Ip' => array(
            'Type' => 'Ip',
            'Sql' => array('varchar(15)'),
        ),
		'AddTime' => 1,
	)
);
return $db_config;
?>