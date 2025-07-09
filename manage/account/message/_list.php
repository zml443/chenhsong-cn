<?php

function_exists('c')||exit();

$where = '1';

$type = $POST['type'];
if($type){
    $where = " and Type='{$type}'";
}

$res = lydb::query("select * from message where $where order by AddTime desc");

if ($res->num_rows<1) {
	exit(str::json(array(
	    'msg' => '',
	    'ret' => 0
	)));
}

while ($v = lydb::result($res)) {
    $v['AddTime'] = date("Y-m-d",$v['AddTime']);
    $data[] = $v;
}

exit(str::json(array(
    'arr' => $data,
    'ret' => 1
)));