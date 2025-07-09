<?php
// 已被使用的变量
// $name, $cfg, $asname


$table = $this->tablename($cfg['Table']);


if ($gk = $_GET[$name]) {
	// 录入搜索-条件栏
	$in_id = explode(',', db::get_in_value($table, "find_in_set('$gk', `UId`)", 'Id').",'$gk'");
	$where = '';
	$i = 0;
	foreach ($in_id as $k => &$v) {
		if ($v) {
			$where .= ($i?' or ':'')." find_in_set({$v}, `{$name}`)";
			$i++;
		}
	}
	if ($where) $this->where .= " and ({$where})";
	// 
	if($table == 'wb_about_category'){
		$category_name = db::get_value($table, "Id='{$gk}'", 'Name');
	}else{
		$category_name = db::get_value($table, "Id='{$gk}'", ln('Name'));
	}
	// 录入搜索-结果栏
	$this->search_xz[] = array(
		'name' => $cfg['Name'],
		'get' => $name,
		'value' => htmlspecialchars($category_name),
	);
}
$category = db::ly_drop_select_category('Id', $table, '1');

// 录入搜索栏
$this->search['layout'][] = array(
	'name' => $cfg['Name'],
	'value' => '
		<div class="ly_input_suffix" ly-drop-select="">
		    <input type="text" bg="white" placeholder="'.language('{/global.select_index/}').'" />
		    <input type="hidden" name="'.$name.'" value="'.htmlspecialchars($_GET[$name]).'" />
		    <script type="text">'.str::json($category).'</script>
		    <i class="lyicon-arrow-down-bold"></i>
		</div>
	',
);
?>