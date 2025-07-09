<?php
$db_config = array(
	'dbc' =>  array(
		'UId' => array(
		    'Name' => '层级',
		    'Type' => 'uid',
		    'Field' => array(
		        'UId' => array('Sql'=>array('varchar(100)', '0,')),
		        'Dept' => array('Sql'=>array('tinyint(1)', 1))
		    ),
		    'Dept' => 5,
			'AddHide'=>1,
			'EditHide'=>1,
		),
		'wb_member_id' => array(
		    'Sql'  => array('int(11)', 0),
		),
		'AddTime' => array(
			'Type' => 'daytime',
			'Sql' => array('int(11)', '0'),
		),
		'Message' => array(
			'Type' => 'textarea',
			'Sql'  => array('text', ''),
		),
		/* '关联表' => array(
			'Table' => 'site/message_log',
		), */
	),
	
	////////////////////////////////////////////////////////////////////////////////////////////////
	
	// 列表页设置
	////////////////////////////////////////////////////////////////////////////////////////////////
	'list' => array(
		'layout' => array(
			'Message' => 1,
			'AddTime' => 1,
			'MemberType' => 1,
		)
	),
	////////////////////////////////////////////////////////////////////////////////////////////////
	
);

return $db_config;
?>