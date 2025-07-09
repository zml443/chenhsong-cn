<?php

include '../../../../php/init.php';


$dbc = array(
    'Name'		=> 1,
    // 'Type'		=> array(
    // 				'Type' => 'text',
    // 				'Sql'  => array('varchar(20)', ''),
    // 				'Dis'  => 1,
    // 				'Hide' => 1,
    // 				'Value'=> 'manage',
    // 			),
    'MyEditor'	=> 1,
);
\dbs\get::html(array(
	'__file__' => __FILE__,
	'table'  => 'jext_ueditor_mdl',
	'dbc'    => $dbc,
	'dbclist'=> $dbclist,
	'permit' => array(
		'add'  => 1,
		'list' => 1,
		'edit' => 1,
		'del'  => 1
	),
));

?>