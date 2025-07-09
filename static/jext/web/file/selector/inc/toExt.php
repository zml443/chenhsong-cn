<?php
// function_exists('c')||exit();
include '../../../../php/init.php';


$id = $_GET['id'];
$data = [];
if($id){
    $arr = db::query("select * from jext_files where find_in_set({$id},UId)");
    while($v = db::result($arr)){
        $data[] = $v;
    }
}

exit(str::json(array(
    'arr' => $data,
    'ret' => 1,
)));