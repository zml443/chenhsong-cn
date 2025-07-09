<?php
// 已被使用的变量
// $name, $cfg


$arr = array();
foreach ((array)$cfg['Args'] as $k => $v) {
	$arr[] = array(
		'label' => $v,
		'value' => $k,
	);
}
$arrJson = str::json($arr);


// 组合成一个条件
if ($gk = $_GET[$name]) {
	$xz = array();
	$where = '';
	$i=-1;
	foreach ((array)$cfg['Args'] as $k => $v) {
		if (strstr($gk, $k)) {
			$i++;
			$where .= ($i?' or ':'').'`'.$k.'`=1';
			$xz[] = $v;
		}
	}
	// 录入搜索-条件栏
	$this->where .= " and ($where)";

	// 录入搜索-结果栏
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name,
		'values' => $xz
	);
}


// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '
		<div class="ly_input_suffix" ly-drop-select="">
		    <input type="text" bg="white" placeholder="'.language('{/global.select_index/}').'" />
		    <input type="hidden" name="'.$name.'" value="'.htmlspecialchars($_GET[$name]).'" />
		    <script type="text">'.$arrJson.'</script>
		    <i class="lyicon-arrow-down-bold"></i>
		</div>
	',
);