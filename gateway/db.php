<?php
include '../inc/global.php';
function_exists('c') || exit;


extract($_GET['ApiName']!=''?$_GET:$_POST, EXTR_PREFIX_ALL, 'p');


($p_ApiName=='') && str::msg('非法的请求！');
// ($p_ApiName=='' || $p_timestamp=='' || $p_sign=='') && str::msg('非法的请求！');
// abs($p_timestamp-$c['time'])>1800 && str::msg('请求已过时，请重新发起请求！');


$p_ApiName = str_replace('..', '', $p_ApiName);



if (is_file(c('root').'gateway/db/'.$p_ApiName.'.php')) {
	include 'db/'.$p_ApiName.'.php';
	exit();
}


str::msg('what are you want to do?');











// <?php
// $data = array(
//     'ret' => 1,
//     'msg' => '测试请求aaaa',
//     'data' => ['ceshi-123']
// );
// exit(json_encode($data));




// 接收站点名，访问该文件目录，阻止访问上一层
$webname = $_POST['module'];

$file = c('root').'module/'.$webname;
if(!is_dir($file)){
    exit(str::json(array(
        'ret' => 0,
        'msg' => '目标站点不存在',
        'data' => array()
    )));
}else{
    exit(str::json(array(
        'ret' => 1,
        'msg' => '',
        'data' => setGroup($webname)
    )));
}

function setGroup($webname){
    $row = array();
    $path = c('root').'module/'.$webname;
    if(!is_dir($path)){
        return $row;
    }
    // 站点 w001
    $h = dir($path);
    while ($f = $h->read()){
        if ($f == "." || $f == "..") continue;
        $filename = $path.'/'.$f;
        if (is_dir($filename)) {

            // 页面 about
            $h2 = dir($filename);
            while ($f2 = $h2->read()){
                if ($f2 == "." || $f2 == "..") continue;
                $filename2 = $filename.'/'.$f2;
                if (is_dir($filename2)) {

                    // 模块 feedback
                    $h3 = dir($filename2);
                    while ($f3 = $h3->read()){
                        if ($f3 == "." || $f3 == "..") continue;
                        $filename3 = $filename2.'/'.$f3;
                        
                        // 文件 index.db.conf.php
                        if (preg_match('/index.conf.php/',$f3)) {
                            $row[$webname.'_'.$f.'_'.$f2] = include $filename3;
                        }
                    }
                }
            }
        }
    }
    return $row;
}











