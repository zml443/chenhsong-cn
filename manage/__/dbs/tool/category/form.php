<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$table = $this->tablename($cfg['Table']);
$where = '1=1';
if ($cfg['Dept']) {
	$where .= ' and Dept<='.(int)$cfg['Dept'];
}
$category = db::ly_drop_select_category('Id', $table, $where);
// d($category);
?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php if ($cfg['Add']) { ?>
				<label class="ly_select_checkbox" ly-drop-select="" data-type="checkbox">
					<div><input type="text" placeholder="" /></div>
					<input type="hidden" name='<?=$name?>' value="<?=$value?>" />
					<i class="lyicon-arrow-down-bold"></i>
					<script type="text"><?=str::json($category)?></script>
				</label>
			<?php } else { ?>
				<label class="ly_input_suffix" ly-drop-select="">
					<input type="text" placeholder="" />
					<input type="hidden" name='<?=$name?>' value="<?=$value?>" />
					<i class="lyicon-arrow-down-bold"></i>
					<script type="text"><?=str::json($category)?></script>
				</label>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>