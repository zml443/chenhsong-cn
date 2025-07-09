<?php

isset($c) || exit();

// 清空站点、页面、模块、other模块
db::query("truncate wb_site_web");
db::query("truncate wb_site_page_copy");
db::query("truncate wb_site_page_module_copy");
db::query("truncate wb_site_page_data");



// webName:'w001'
$web_name = $_GET['w'];
$dir = c('root')."module/".$web_name;

if(!is_dir($dir) || !$web_name){return str::msg('该站点不存在,请传入正确的站点名称 >> eg:w001', 0);}

// 1、录入站点
$web_id = db::insert('wb_site_web',array(
    'Used' => 1,
    'Number' => $web_name,
));

// 站点 >> index、about...
$h = dir($dir);
while ($f = $h->read()) {
    $page_path = $dir . "/" . $f;
    if ($f == "." || $f == "..") {
        continue;
    }
    if (!is_dir($page_path) || !is_file($page_path.'/_.conf.php')) {
        continue;
    }
    // 页面 >> _.conf.php
    $page_h = dir($page_path);
    while ($f2 = $page_h->read()) {
        $filePath = $page_path . "/" . $f2;
        if ($f2 == '_.conf.php') {
            // 引入页面配置数据
            $conf = include $filePath;
            $p = array(
                'IsLock'            => 1,
                'HeaderOpacity'     => $conf['header_opacity'],
                'wb_site_web_id'    => $web_id,
                'Number'            => $web_name."/".$f,
                'Type'              => $conf['type'],
                'Style'             => $conf['style'][0],
                'Wrap'              => $conf['wrap'],
                'Width'             => $conf['width'],
                'HaveHeader'        => $conf['parts']['header']?1:0,
                'HaveFooter'        => $conf['parts']['footer']?1:0,
                'HaveLefter'        => $conf['parts']['lefter']?1:0,
                'HaveRighter'       => $conf['parts']['righter']?1:0,
                'Tag'               => $conf['tag'],
            );
            if($conf['type'] == 'other'){
                $other_para = array(
                    'IsLock' => 1,
                );
                // 插入多语言name
                foreach (c('language_name') as $k => $v) {
                    $other_para['Name_'.$k] = $conf['name'];
                }
                // other类型模板插入
                $other_id = db::insert('wb_site_page_data', $other_para);
                $p['wb_site_page_data_id'] = $other_id;
            }
            // 2、录入页面
            $page_id = db::insert('wb_site_page_copy', $p);

            // 3、录入模板
            $m = array(
                'Parts'             => 'content',
                'wb_site_web_id'    => $web_id,
                'wb_site_page_id'   => $page_id,
            );

            if($conf['type'] == 'index'){
                $m['Parts'] = 'header';
                $m['Number'] = $conf['parts']['header']['module'][0]['path'];
                db::insert('wb_site_page_module_copy', $m);
                $m['Parts'] = 'footer';
                $m['Number'] = $conf['parts']['footer']['module'][0]['path'];
                db::insert('wb_site_page_module_copy', $m);
            }
            foreach((array)$conf['parts']['content']['module'] as $v){
                $m['Parts'] = 'content';
                $m['Number'] = $v['path'];
                db::insert('wb_site_page_module_copy', $m);
            }
        }
    }
}

str::msg('站点录入成功', 1);