<?php
// 已被使用的变量
// $name, $cfg

$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[]=$k;
$eftime0 = $field_key[0];
$eftime1 = $field_key[1];

$table = $this->tablename($cfg['Table']);

$show_get = htmlspecialchars($_GET[$name]);

if ($_GET[$name]) {
	$timestr = explode('~', $_GET[$name]);
	$s = strtotime($timestr[0]);
	$e = strtotime($timestr[1]);
	$this->where .= " and `{$eftime0}`>={$s} and `{$eftime1}`<={$e} ";
	// 录入搜索-结果栏
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name,
		'value' => $show_get,
	);
}

// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '<div class="ly_input"><input type="text" name="'.$name.'" value="'.$show_get.'" bg="white" ly-laydate="date" range="~"></div>',
);