<?php
$this->where = '1';
if ($_GET['Id']) {
	$ids = explode(',', (string)$_GET['Id']);
	$ids_where = '0';
	foreach ($ids as $v) {
		$ids_where .= ",".(int)$v;
	}
	$this->where .= " and Id not in($ids_where)";
}
$category = db::ly_drop_select_category('UId', $this->table, $this->where);
?>
<form id="_edit_category_uid" class="flex-middle2">
	<span><?=language('global.uid')?>：</span>
	<label class="ly_input_suffix flex-1" ly-drop-select="">
		<input type="text" placeholder="" />
		<input type="hidden" name='UId' value="" />
		<i class="lyicon-arrow-down-bold"></i>
		<script type="text"><?=str::json($category)?></script>
	</label>
	<input type="hidden" name="Id" value="<?=$_GET['Id']?>" />
</form>