<?php
$db_config = array(
	'dbc' => array(
	    'Name' => 1,
	    'Type' => array(
            'Type' => 'Radio',
            'Args' => array(
                'P' => '{/orders.invoice.P/}',
                'C' => '{/orders.invoice.C/}',
            ),
            'Sql'  => array('Varchar(2)', 'P')
        ),
	    'Phone' => 1,
	    'Email' => 1,
	    'Company' => array(
            'Type' => 'text',
            'Sql'  => array('Varchar(250)', '')
		),
	    'CompanyPhone' => array(
            'Type' => 'text',
            'Sql'  => array('Varchar(250)', '')
		),
	    'CompanyAddress' => array(
            'Type' => 'textarea',
            'Sql'  => array('Varchar(250)', '')
		),
	    'BankName' => array(
            'Type' => 'text',
            'Sql'  => array('Varchar(250)', '')
		),
	    'BankNumber' => array(
            'Type' => 'text',
            'Sql'  => array('Varchar(250)', '')
		),
	)
);
return $db_config;
?>