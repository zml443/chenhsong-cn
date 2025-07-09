<?php

$db_config = array(
	'dbg' => array(
		'IsMember' => array(
			'Type' => 'open',
			'Name' => '登录可下载',
			'Sql' => array('int(1)',0),
		),
		'IsFeedback' => array(
			'Type' => 'open',
			'Name' => '留言可下载',
			'Sql' => array('int(1)',0),
		),
	)
);
return $db_config;
?>