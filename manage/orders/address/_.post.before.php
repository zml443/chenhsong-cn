<?php

function_exists('c') || exit;


// 有数据变动才记录日志
if($this->is_mod){
    $this->AddressLog = 1;
}
if($this->is_mod&&isset($_POST['wb_orders_id'])){
    $this->AddressLog = 0;
    $orders_shipping_address = db::result("select * from wb_orders_address where wb_orders_id='{$_POST['wb_orders_id']}' and Type='shipping'");
    foreach ($_POST as $k => $v) {
        if($v != $orders_shipping_address[$k]){
            $this->AddressLog = 1;
            continue;
        }
    }
}