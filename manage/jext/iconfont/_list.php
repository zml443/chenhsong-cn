<?php

function_exists('c') || exit;

exit(str::json(array(
	'list' => array(
		array(
			'icon' => 'lyicon-customer-service',
		),
		array(
			'icon' => 'lyicon-email',
		),
		array(
			'icon' => 'lyicon-map',
		),
		array(
			'icon' => 'lyicon-print',
		),
		array(
			'icon' => 'lyicon-telephone',
		),
		array(
			'icon' => 'lyicon-xiaoxi',
		),
		array(
			'icon' => 'lyicon-language',
		),
		array(
			'icon' => 'lyicon-global',
		),
	)
)));