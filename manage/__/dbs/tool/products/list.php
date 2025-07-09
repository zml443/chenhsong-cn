<?php
// 已被使用的变量
// $name, $value, $row, $cfg


if($row[$name.'Type'] == 'all'){
    echo language('panel.select_products.all');;
}

if($row[$name.'Type'] == 'id'){
    echo $row[$name.'Id'];
}

if($row[$name.'Type'] == 'category'){
    echo $row[$name.'Category'];
}

?>
