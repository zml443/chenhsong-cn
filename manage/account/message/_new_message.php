<?php

function_exists('c')||exit();

$webNumber = c('HostName');
$wb_manage_id = manage('Id');

$result = lydb::result("select * from message where Type='system_update' order by AddTime desc limit 1");
$log = lydb::result("select * from message_log where Type='system_update' order by AddTime desc limit 1");

if ($result['AddTime'] != $log['AddTime']) {
    lydb::insert('message_log', array(
        'AddTime' => $result['AddTime'],
        'Type' => 'system_update',
        'WebNumber' => $webNumber,
        'message_id' => $result['Id'],
        'wb_manage_id' => $wb_manage_id,
    ));
    $result['AddTime'] = date("Y-m-d",$result['AddTime']);
    exit(str::json(array(
        'ret' => 1,
        'msg' => '有最新数据',
        'arr' => $result,
    )));
} else {
    exit(str::json(array(
        'ret' => 0,
        'msg' => '没有新数据',
    )));
}