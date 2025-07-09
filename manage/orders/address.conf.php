<?php
return array(
    'dbc' => array(
        // 
        'Type' => array(
            'Type' => 'select',
            'Sql' => array('varchar(12)', 'shipping'),
            'Args' => array(
                'shipping' => language('{/orders.shipping_address/}'),
                'billing' => language('{/orders.billing_address/}'),
            ),
            'EditHide' => 1,
            'EditAdd' => 1
        ),
        // 
        'wb_orders_id' => array(
            'Type' => 'bind-id',
            'Sql' => array('int(11)', '0'),
        ),
        // 
        'FirstName' => array(
            'Name' => '{/global.name/}',
            'Type' => 'first_name',
            'Field'=> array(
                // 字段名可以改，但是顺序不能乱
                'FirstName' => array('Sql'=>array('varchar(90)','')),
                'LastName' => array('Sql'=>array('varchar(90)','')),
            ),
        ),
        // 
        // 'Gender' => array(
        //     'Type' => 'radio',
        //     'Sql'  => array('varchar(1)', 'A'),
        //     'Args' => array(
        //         'A' => '{/member.gender.A/}',
        //         'B' => '{/member.gender.B/}', //boy
        //         'G' => '{/member.gender.G/}' //girl
        //     ),
        // ),
        // 
        'Country' => array(
            'Name' => '{/global.country_address/}',
            'Type' => 'country_address',
            'Sql' => array('varchar(50)', ''),
            'Field'=> array(
                'Province' => array('Sql' => array('varchar(50)', '')),
                'City' => array('Sql' => array('varchar(50)', '')),
                'Town' => array('Sql' => array('varchar(50)', '')),
            ),
        ),
        // 
        'Address' => array(
            'Name' => '{/global.address/}',
            'Type' => 'textarea',
            'Sql'  => array('varchar(150)')
        ),
        // 
        /*'Email' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(150)')
        ),*/
        // 
        'Phone' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(150)')
        ),
        // 
        'Postcode' => array(
            'Type' => 'text',
            'Sql'  => array('varchar(150)')
        ),
    )
);