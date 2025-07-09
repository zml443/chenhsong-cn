<?php
// 已被使用的变量
// $name, $cfg, $asname



$show_get = htmlspecialchars($_GET[$name]);

if ($_GET[$name]) {
	$timestr = explode('~', $_GET[$name]);
	$s = strtotime($timestr[0]);
	$e = strtotime($timestr[1]) + 1439;
	// 录入搜索-条件栏
	$this->where .= " and `{$name}`>={$s} and `{$name}`<={$e} ";
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
	'value' => '<div class="ly_input"><input type="text" name="'.$name.'" value="'.$show_get.'" bg="white" ly-laydate="" range="~"></div>',
);
