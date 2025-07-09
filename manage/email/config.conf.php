<?php
return array(
    'dbg' => array(
        'FromEmail' => array(
            'Name' => language('{/panel.from_email/}'),
            'Type' => 'text',
        ),
        'FromName' => array(
            'Name' => language('{/panel.from_name/}'),
            'Type' => 'text',
        ),
        'SmtpHost' => array(
            'Name' => language('{/panel.email_smtp/}'),
            'Type' => 'text',
        ),
        'SmtpPort' => array(
            'Name' => language('{/panel.email_port/}'),
            'Type' => 'text',
        ),
        'SmtpUserName' => array(
            'Name' => language('{/panel.email_username/}'),
            'Type' => 'text',
        ),
        'SmtpPassword' => array(
            'Name' => language('{/panel.email_password/}'),
            'Type' => 'text',
        ),
        '关联表' => array(
            'Table' => 'email/list',
        )
    ),
);