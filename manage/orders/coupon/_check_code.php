<?php
function_exists('c') || exit;

$rand = strtoupper(str::rand(8));
$code = getCode($rand);


function getCode($str){
    $hasCode = db::result("select * from wb_orders_coupon where Name='{$str}' limit 0,1");
    if(count($hasCode)>0){
        getCode(strtoupper(str::rand(8)));
    }else
        return $str;
}

exit(str::json(array(
    'msg' => $code,
    'ret' => 1,
)));