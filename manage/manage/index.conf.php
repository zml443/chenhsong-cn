<?php
return array(
	'add_to_edit' => 1,
    'edit_head' => array('IsLoginLock'=>1, 'Password'=>1, 'Delete'=>1),
	'dbc' => array(
		'UserName' => array(
	        'Type' => 'text',
	        'Sql' => array('varchar(120)', ''),
	        'NotRepeat' => 1,
	        'EditShow' => 1,
			'List' => 1,
	    ),
	    'IsLoginLock' => 1,
		'Password' => array(
			'Type' => 'password',
			'Sql'  => array('varchar(32)',''),
		),
		'wb_manage_id' => array(
			'Table'=> 'manage/index',
			'Type' => 'manage',
			'Sql'  => array('int(11)', 0),
		),
		'ServerKey' => array(
			'Type' => '/manage/manage/index/_tool_server_key',
			'Sql' => array('varchar(32)', ''),
			'Field' => array(
				'ServerKeyOpen' => array('Sql' => array('int(1)', '')),
			),
			'NotSave' => 1,
			'AddHide' => 1
		),
	    'Permit' => array(
	        'Type' => 'permit',
	        'Sql'  => array('text', ''),
	        'Field'=> array(
	            'Level' => array('Sql'=>array('tinyint(1)',1)),
	            'PermitStr' => array('Sql'=>array('text','')),
	        )
	    ),
		'LastLoginIp' => array(
			// 'Name' => language('{/member.login_last_ip/}'),
			'Type' => 'ip',
			'Sql'  => array('varchar(15)', ''),
			'EditShow'=> 1,
			'AddHide' => 1,
			'List' => 1,
		),
		'LastLoginTime'	=> array(
			// 'Name' => language('{/member.login_last_time/}'),
			'Type' => 'daytime',
			'Sql'  => array('int(11)', 0),
			'EditShow'=> 1,
			'AddHide' => 1,
			'List' => 1,
		),
        'data_number_login' => array(
            'Sql'  => array('int(11)', 0),
        ),
		'日志表' => array(
			'Table' => 'manage/log',
		),
	)
);