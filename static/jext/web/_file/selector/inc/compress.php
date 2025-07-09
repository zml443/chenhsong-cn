<?php
// function_exists('c')||exit();
include '../../../../php/init.php';



$id = (int)$_GET['id'];
$res = db::result("select * from jext_files where Id=$id limit 0,1");

$update = [];
if($id){
    // 原图
    $path = c('root').$res['Path'];
    $size = filesize($path);
    if ($size<1024*1024*1.5) {
        exit(str::json(array(
            'ret' => 1,
            'msg' => '小图可以不压缩',
        )));
    }
    // 压缩路径
    $newImgPath = c('root') . c('tmp_dir') . 'upload/'.date('Y-m-d/');
    $newImgName = $newImgPath.str_replace(array('/','-'),'_',$res['Path']);
    // 创建临时文件夹
    file::mkdir($newImgPath);
    // 实例压缩图
    $xxx = new img_compress($path);
    // 保存到
    $xxx -> init($newImgName);



    // 文件操作
    if(!is_file($newImgName)){
        // return array();
        exit(str::json(array(
            'ret' => 0,
            'msg' => '压缩失败',
        )));
    }
    if($size < filesize($newImgName)){
        unlink($newImgName);
        exit(str::json(array(
            'ret' => 1,
            'msg' => '不压缩',
        )));
    }else{
        list($width, $height) = getimagesize($newImgName);
        $update['Width'] = $width;
        $update['Height'] = $height;
        $update['Size'] = filesize($newImgName);
        // 更新数据库
        $update && db::update('jext_files', "Id='{$res['Id']}'", $update);
        unlink($path);
        rename($newImgName,$path);
        exit(str::json(array(
            'ret' => 1,
            'msg' => '压缩成功',
        )));
    }
    // d($res,'path:',$newImgName,'size:',filesize($path),$update);
}