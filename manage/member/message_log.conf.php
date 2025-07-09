<?php
$db_config = array(
	'dbc' =>  array(
		'MemberType' => array(
			'Name'=> '接收对象',
			'Type' => 'wb_member_message_log_member_type',
			'Sql' => array('varchar(200)', ''),
			'Field' => array(
				'wb_member_id' => array('Sql'=>array('text','')),
				'MemberLevel' => array('Sql'=>array('varchar(200)','')),
			),
			'Args' => array(
				'all' => '所有用户',
				'level' => '指定等级',
				'user' => '指定会员',
			),
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