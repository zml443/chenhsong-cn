<?php
$db_config = array(
    'dbc' => array(
        'FirstName' => array(
            'Type' => 'first_name',
            'Field' => array(
                'FirstName' => array('Sql'=>array('varchar(90)','')),
                'LastName' => array('Sql'=>array('varchar(90)','')),
            ),
        ),
        'wb_member_id' => array(
            'Type' => 'bind-id',
            'Sql' => array('int(11)', 0),
            'Search' => '='
        ),
        'Type' => array(
            'Type' => 'hidden',
            'Args' => array(
                'shipping' => '配送地址',
                'billing' => '账单地址',
            ),
            'Sql' => array('varchar(12)', 'shipping'),
            // 'EditShow' => 1,
            // 'AddHide' => 1,
            'Search' => '=',
        ),
        'Gender' => array(
            'Type' => 'radio',
            'Sql' => array('varchar(1)', 'A'),
            'Args' => array(
                'A' => language('{/member.Ss/}'),
                'B' => language('{/member.Sir/}'), //boy
                'G' => language('{/member.Ms/}') //girl
            ),
        ),
        'Country' => array(
            'Name' => '国家',
            'Type' => 'country',
            'Sql' => array('varchar(100)', ''),
        ),
        'Province' => array(
            'Name' => '国内地区',
            'Type' => 'Address',
            'Field'=> array(
                'Province' => array('Sql' => array('varchar(50)', '')),//省
                'City' => array('Sql' => array('varchar(50)', '')),//市
                'Town' => array('Sql' => array('varchar(50)', '')),//区
            )
        ),
        'Address' => array(
            'Type' => 'textarea',
            'Sql' => array('varchar(200)'),
        ),
        'Email' => array(
            'Type' => 'text',
            'Sql' => array('varchar(90)'),
        ),
        'Phone' => array(
            'Type' => 'text',
            'Sql' => array('varchar(90)'),
        ),
        'Postcode' => array(
            'Type' => 'text',
            'Sql' => array('varchar(90)'),
        ),
        'IsDefault' => array(
            'Type' => 'only',
            'Sql' => array('int(1)', 0),
        ),
    )
);
return $db_config;
?>