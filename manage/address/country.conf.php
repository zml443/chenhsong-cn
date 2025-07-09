<?php
$db_config = array(
    'dbc' => array(
        'Name' => array(
            'Type' => 'text',
            'Sql' => array('varchar(200)',''),
            'Lang' => 1
        ),
        'Name2' => array(
            'Name' => '完整名稱',
            'Type' => 'text',
            'Sql' => array('varchar(120)',''),
        ),
        'UId' => array(
            // 'Name' => '类别',
            'Type' => 'uid',
            'Field' => array(
                'UId' => array('Sql'=>array('varchar(100)', '0,')),
                'Dept' => array('Sql'=>array('tinyint(1)', 1))
            ),
            'Dept' => 3,
        ),
        'Number' => array(
            'Name' => '编号',
            'Type' => 'text',
            'Sql' => array('varchar(20)',''),
        ),
    )
);
return $db_config;
?>