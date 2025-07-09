<?php
// 常用字段名
return array(
    'Name' => array(
        'Type' => 'text',
        'Sql' => array('varchar(100)', ''),
        'NotNull' => 1,
        'List' => 1,
        'IsName' => 1,
        'Search' => '%'
    ),
    'Language' => array(
        'Type' => 'language',
        'Sql' => array('varchar(10)', 'cn'),
        'Field' => array(
            'LanguageDa' => array('Sql' => array('varchar(200)',''),'NotNull'=>0),
        ),
        'Group' => 'language',
        'NotNull' => 1,
        'List' => 1,
        'Search' => 1
    ),
    'IsUnpublished' => array(
        'Type' => 'is-unpublished',
        'Search' => 1
    ),
    'PageUrl' => array(
        'Type' => 'pageurl',
        'Cfg' => array(
            'Dir' => '/',
            'Ext' => '/'
        )
    ),
    'Seo' => array(
        'Type' => 'seo',
        'GroupRight' => 'seo'
    ),
    // 跳过seo
    'NotSeo' => array(
        'Sql'  => array('tinyint(1)', 0),
    ),
    // 管理员是否已读
    'IsRead' => array(
        'Sql'  => array('tinyint(1)', 0),
    ),
    'IsLoginLock' => array(
        'Sql'  => array('tinyint(1)', 0),
    ),
    // 锁定数据，不允许删除
    'IsLock' => array(
        'Sql'  => array('tinyint(1)', 0),
    ),
    // 跳过数据查询
    'IsContinue' => array(
        'Sql'  => array('tinyint(1)', 0),
    ),
    'wb_manage_id' => array(
        'Type' => 'manage',
        'Sql' => array('Int(11)', '0'),
        'Field' => array(
            'past_wb_manage_id' => array('Sql' => array('Int(11)','')),
        )
    ),
    'UId' => array(
        'Name' => '类别',
        'Type' => 'uid',
        'Field' => array(
            'UId' => array('Sql'=>array('varchar(100)', '0,')),
            'Dept' => array('Sql'=>array('tinyint(1)', 1))
        ),
        'Dept' => 2,
    ),

    'AddTime' => array(
        'Sql' => array('int(11)',0),
        'List' => 1,
        'Search' => 1
    ),
    'Pictures' => array(
        'List' => 1,
    ),
    'Picture' => array(
        'List' => 1,
    ),
    'Detail' => array(
        'Group' => 'editor',
    ),
    'Editor' => array(
        'Group' => 'editor',
    ),
    'UserName' => array(
        'Type' => 'text',
        'Sql' => array('varchar(50)', ''),
        'NotRepeat' => 1,
        'List' => 1,
        'Search' => '%'
    ),
    'Password' => array(
        'Type'   => 'password',
        'Sql' => array('varchar(50)', ''),
        'EditHide' => 1,
    ),
    'Email' => array(
        'List' => 1,
        'Search' => '%'
    ),
    'Phone' => array(
        'List' => 1,
        'Search' => '%'
    ),
    'Mobile' => array(
        'List' => 1,
        'Search' => '%'
    ),
    'Tel' => array(
        'List' => 1,
        'Search' => '%'
    ),
    'Brief' => array(
        'Search' => '%'
    ),
    'BriefDescription' => array(
        'Search' => '%'
    ),
);