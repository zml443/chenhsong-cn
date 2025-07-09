<?php
// g('wb_ad.pc')
return array(
    'dbg' => array(
        // pc
        'pc' => array(
            'Name' => 'Pc',
            'Type' => 'image',
            'Tip'  => '1920 * 1068像素,文字在编辑里修改，仅视频能添加蒙版',
            'Lang' => 1,
            'Cfg'  => array(
                'img' => array(
                    'Name' => '蒙版',
                    'Type' => 'img',
                ),
                'tit1' => array(
                    'Name' => '标题1',
                    'Type' => 'text',
                ),
                'tit2' => array(
                    'Name' => '标题2',
                    'Type' => 'text',
                ),
                'url' => array(
                    'Name' => '链接',
                    'Type' => 'text'
                ),
                'alt' => array(
                    'Name' => 'alt',
                    'Type' => 'text'
                ),
                'title' => array(
                    'Name' => 'title',
                    'Type' => 'text'
                ),
            ),
        ),
        // 手机版
        'mobile' => array(
            'Name' => '手机',
            'Type' => 'image',
            'Tip'  => '750 * 750像素,文字在编辑里修改',
            'Lang' => 1,
            'Cfg'  => array(
                'img' => array(
                    'Name' => '蒙版',
                    'Type' => 'img',
                ),
                'tit1' => array(
                    'Name' => '标题(中)',
                    'Type' => 'text',
                ),
                'tit2' => array(
                    'Name' => '标题(英)',
                    'Type' => 'text',
                ),
                'url' => array(
                    'Name' => '链接',
                    'Type' => 'text'
                ),
                'alt' => array(
                    'Name' => 'alt',
                    'Type' => 'text'
                ),
                'title' => array(
                    'Name' => 'title',
                    'Type' => 'text'
                ),
            ),
        ),
    ),
);