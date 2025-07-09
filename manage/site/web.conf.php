<?php
$db_config = array(
	'dbc' =>  array(
		'Name' => 1,
		'Release' => array(
			'Sql' => array('int(1)', '0'),
		),
		'Used' => array(
			'Sql' => array('int(1)', '0'),
		),
		'Number' => array(
			'Sql' => array('varchar(50)', ''),
		),
		// 做多类型的时候使用，不同平台显示不同版面 pc   app
		'Type' => array(
			'Sql' => array('varchar(50)', ''),
		),
	    '关联表' => array(
	    	'Table' => array('site/page_copy'),
	    	'ExtId' => 1,
	    )
	),
);
return $db_config;
?>