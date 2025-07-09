<?php
// 已被使用的变量
// $name, $cfg


$manage_log = language('{/dbs.manage_log/}');
$mLog = array();
$w = '';
$xz = array();
foreach ($manage_log as $k => $v) {
	$mLog[] = array(
		'label' => $v,
		'value' => $k,
	);
	if ($_GET[$name] && $_GET[$name] == $k) {
		$w .= " and `$name`='$k'";
		$xz[] = $v;
	}
}


// 组合成一个条件
if ($w) {
	// 录入搜索-条件栏
	$this->where .= $w;

	// 录入搜索-结果栏
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name,
		'values' => $xz
	);
}

// d($mLog);
// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '
		<div class="ly_input_suffix" ly-drop-select="">
		    <input type="text" bg="white" placeholder="'.language('{/global.select_index/}').'" />
		    <input type="hidden" name="'.$name.'" value="'.htmlspecialchars($_GET[$name]).'" />
		    <script type="text">'.str::json($mLog).'</script>
		    <i class="lyicon-arrow-down-bold"></i>
		</div>
	',
);