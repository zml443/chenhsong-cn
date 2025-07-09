<?php
// 已被使用的变量
// $name, $value, $row, $cfg


if($row[$name.'Type'] == 'all'){
    echo language('panel.select_member.check.all');
}

if($row[$name.'Type'] == 'group'){
    $str = explode(',',$row[$name.'GroupType']);
    foreach($str as $k => $v){
        $str[$k] = language('panel.select_member.group.'.$v);
    }
    // echo language('panel.select_member.check.group').':'.implode(',',$str);
    echo implode('，',$str);
}

if($row[$name.'Type'] == 'tag'){
    echo $row[$name.'Tag'];
}

if($row[$name.'Type'] == 'id'){
    echo $row[$name.'Id'];
}

?>
