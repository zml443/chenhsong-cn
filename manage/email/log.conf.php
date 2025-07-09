<?php
$db_config = array(
    'dbc' => array(
        'Subject' => array(
            'Type' => 'Text',
            'Sql'  => array('varchar(200)',''),
            'EditShow' => 1,
        ),
        'Email' => array(
            'Type' => 'Text',
            'Sql'  => array('text'),
            'EditShow' => 1,
        ),
        'AddTime' => array(
            'Type' => 'daytime',
            'Sql'  => array('int(11)', 0),
            'EditShow' => 1,
        ),
        'Body' => array(
            'Type' => 'my_editor',
            'Sql'  => array('text'),
            'EditShow' => 1,
        ),
    )
);
return $db_config;
?>