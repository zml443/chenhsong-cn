<?php
/**
 * 得到上传文件所对应的各个参数,数组结构
 * json_encode(array(
 *     "state" => "",          //上传状态，上传成功时必须返回"SUCCESS"
 *     "url" => "",            //返回的地址
 *     "title" => "",          //新文件名
 *     "original" => "",       //原始文件名
 *     "type" => "",            //文件类型
 *     "size" => "",           //文件大小
 * ))
 */
if (!manage('Id') || preg_match('/\.(exe|php|html?|java|jsp)$/', $_FILES['upfile']['name'])) {
    return json_encode(array(
        "state" => "ERROR",
    ));
}

$save_dir = c('u_file_dir') . strtolower(c('Number')) . date('/Y-m/d/');
$file = file::upload($_FILES['upfile'], $save_dir);

$Id = db::insert('jext_files', array(
    'Type'      =>  1,
    'GroupId'   =>  'ueditor',
    'ExtId'     =>  (int)manage('Id'),
    'Name'      =>  $_FILES['upfile']['name'],
    'Path'      =>  $file,
    // 'Width'     =>  $file['Width'],
    // 'Height'    =>  $file['Height'],
    // 'Size'      =>  $file['Size'],
    'AddTime'   =>  time(),
    'IsTmp'     =>  0
));
return json_encode(array(
    "state" => "SUCCESS",          //上传状态，上传成功时必须返回"SUCCESS"
    "url" => $file,            //返回的地址
    "title" => "",          //新文件名
    "original" => "",       //原始文件名
    "type" => "",            //文件类型
    "size" => "",           //文件大小
));