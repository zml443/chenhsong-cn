<?php

function_exists('c') || exit;


if($this->AddressLog){
    log::orders($this->row['wb_orders_id'], 'address', "修改了订单的发货地址");
}
