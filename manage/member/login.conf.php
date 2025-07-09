<?php
$db_config = array(
    'dbg' => array(
        'config' => array(
            'Name' => '{/set.basic_info/}',
            'Cfg'  => array(
                'name' => array(
                    'Name' => '{/set.site_name/}',
                    'Type' => 'text',
                ),
                'domain' => array(
                    'Name' => '{/set.domain/}',
                    'Type' => 'text',
                ),
                'copyright' => array(
                    'Name' => '{/set.copyright/}',
                    'Type' => 'text',
                    'Lang' => 1,
                ),
                'icp' => array(
                    'Name' => '{/set.icp/}',
                    'Type' => 'text',
                ),
            ),
        ),
    ),
);
return $db_config;
?>