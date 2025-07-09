<?php
// 已被使用的变量
// $name, $value, $row, $cfg



if ($cfg['Dept']==1) {
	return '';
}

// 存在关联id时，只能那指定的数据
$ex_na=$this->is_ext_id;
if ($ex_na && $this->fields[$ex_na]) {
	$ex_id = (int)$_GET[$ex_na];
	$where = "`$ex_na`=$ex_id";
} else {
	$where = '1=1';
}
// 
if ($cfg['Dept']) {
	$where .= ' and Dept<'.(int)$cfg['Dept'];
}
if ($_GET['_UId']) {
	$uid = (int)$_GET['_UId'];
	$where .= " and (find_in_set($uid, UId) or Id=$uid)";
}
if ($row) {
	$id = (int)$row['Id'];
	$where .= " and Id<>$id and find_in_set($id, UId)=0";
}
// $value = $row['UId'];
// $value || $value = $_SESSION['UID-L'.$this->table];

$category = db::ly_drop_select_category('UId', $this->table, $where);
?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
		
			<label class="ly_input_suffix" ly-drop-select="" data-type="radio" data-split-value="|">
				<input type="text" placeholder="请选择类别" />
				<input type="hidden" name='<?=$name?>' value="<?=$value?>" />
				<i class="lyicon-arrow-down-bold"></i>
				<script type="text"><?=str::json($category)?></script>
			</label>

		<!-- 结束 -->
	</div>
</div>