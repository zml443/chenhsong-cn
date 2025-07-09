<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(120)',''),
            'EditShow' => 1
        ),
        'Email'  => array(
            'Type' => 'text',
            'Sql'  => array('varchar(200)',''),
            'EditShow' => 1
        ),
    ),
    'list' => array(
        'layout' => array(
            'Email' => 1,
            'Name' => 1,
        )
    )
);
if ($_GET['d']=='get_email') {
    $db_config['list'] = array(
        'type' => 'email',
        'limit' => 50,
        'search' => array(
            'keyword' => array('Name'=>1),
            'select' => array(),
        )
    );
}
return $db_config;
?>