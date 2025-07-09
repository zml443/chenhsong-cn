<?php
// 已被使用的变量
// $name, $cfg, $asname

$language = array();
foreach ($this->language as $k => $v) {
	$language[] = array(
		'label' => language("language.".$v),
		'value' => $v,
	);
}


if ($gk = $_GET[$name]) {
	$this->where .= " and `{$name}`='{$gk}'";
	// 录入搜索-结果栏
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name,
		'value' => language('{/language.'.$_GET[$name].'/}'),
	);
}


// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '
		<div class="ly_input_suffix" ly-drop-select="">
		    <input type="text" bg="white" placeholder="'.language('{/global.select_index/}').'" />
		    <input type="hidden" name="'.$name.'" value="'.htmlspecialchars($_GET[$name]).'" />
		    <script type="text">'.str::json($language).'</script>
		    <i class="lyicon-arrow-down-bold"></i>
		</div>
	',
);
