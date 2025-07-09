<?php
// 已被使用的变量
// $name, $cfg, $prefix_name

$gk = (array)$_GET[$name];
$radio = '';
$value = array();

foreach ($cfg['Args'] as $k => $v) {
	if (in_array($k, $gk)) {
		$is_check = 'checked';
		$value[] = $v;
	} else {
		$is_check = '';
	}
	$radio .= '<label class="flex-max2 pointer"><i class="ly_checkbox mr_3px"><input type="checkbox" name="'.$name.'[]" value="'.$k.'" '.$is_check.'></i><span>'.$v.'</span></label>';
}


if ($gk) {
	$val = @implode("','", $gk);
	$this->where .= " and `{$name}` in('{$val}')";
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name.'[]',
		'value' => implode(',', $value),
	);
}



// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '<div class="flex-wrap" style="gap:10px 20px">'.$radio.'</div>',
);
