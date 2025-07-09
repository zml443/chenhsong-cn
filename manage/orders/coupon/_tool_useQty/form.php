<?php
// 已被使用的变量
// $name, $value, $row, $cfg

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
		<div class="">
			<label class="ly_input mb_10px">
				<input type="text" name="<?=$name?>" value="<?=$row[$name]?:''?>" onkeyup="_tool_useQty_cb.writeNumber(this)">
				<div class="bg_pane"><?=language('panel.UseQty.unit')?></div>
			</label>
			<label class="flex-btn pointer">
				<i class="ly_checkbox lyicon-select-bold mr_10px"></i>
				<input type="checkbox" class="hide" value="1" <?=$row[$name.'Type']?'checked':''?> fn="_tool_useQty_cb"/>
				<input type="hidden" name="<?=$name?>Type" value="<?=$row[$name.'Type']?>" />
				<span><?=language('panel.UseQty.number')?></span>
			</label>
		</div>
		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>