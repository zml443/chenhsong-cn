<?php
// 已被使用的变量
// $name, $cfg, $asname


$arr = array(
	'0' => language('{/global.release2/}'),
	'1' => language('{/global.update2/}'),
);
$arr2 = array();
foreach ($arr as $k => $v) {
	$arr2[] = array(
		'value' => $k,
		'label' => $v
	);
}



if (isset($_GET[$name])) {
	$gk = (int)$_GET[$name];
	$this->where .= " and `$name`='{$gk}'";
	// 录入搜索-结果栏
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name,
		'value' => $arr[$gk],
	);
}


// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '
		<div class="ly_input_suffix" ly-drop-select="">
		    <input type="text" bg="white" placeholder="'.language('{/global.select_index/}').'" />
		    <input type="hidden" name="'.$name.'" value="'.$arr[$_GET[$name]].'" />
		    <script type="text">'.str::json($arr2).'</script>
		    <i class="lyicon-arrow-down-bold"></i>
		</div>
	',
);
?>