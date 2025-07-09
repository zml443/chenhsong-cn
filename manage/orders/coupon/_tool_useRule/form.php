<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-wrap' style="gap:20px;">
		<!-- 开始 -->
		<div class="tab_links">
			<label class="ly_btn_radio pointer mr_10px">
				<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="Money" <?=$row[$name.'Money']?'checked':($row[$name.'Number']?'':'checked')?> fn="_tool_useFactor"></i>
				<span><?=language('panel.free.full_money')?></span>
			</label>
			<label class="ly_btn_radio pointer mr_10px">
				<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="Number" <?=$row[$name.'Number']?'checked':''?> fn="_tool_useFactor"></i>
				<span><?=language('panel.free.full_number')?></span>
			</label>
		</div>
		<div class="tab_content width300">
			<label class="ly_input" data-con="Money">
				<div class="bg_pane"><?=price::rate(0,1);?></div>
				<input type="text" name="<?=$name?>Money" value="<?=ceil($row[$name.'Money'])?$row[$name.'Money']:''?>">
			</label>
			<label class="ly_input" data-con="Number">
				<input type="text" name="<?=$name?>Number" value="<?=$row[$name.'Number']?:''?>">
				<div class="bg_pane"><?=language('panel.free.full_unit')?></div>
			</label>
		</div>
		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>