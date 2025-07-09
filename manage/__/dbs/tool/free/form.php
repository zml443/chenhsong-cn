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
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="Money" <?=$row[$name.'Money']?'checked':($row[$name.'Discount']?'':'checked')?> fn="dbs_free_type_fn"></i>
					<span><?=language('{/panel.free.free_money/}')?></span>
				</label>
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="Discount" <?=$row[$name.'Discount']?'checked':''?> fn="dbs_free_type_fn"></i>
					<span><?=language('{/panel.free.free_discount/}')?></span>
				</label>
			</div>
			<div class="tab_content">
				<label class="ly_input width300" data-con="Money">
					<div class="bg_pane"><?=price::rate(0,1)?></div>
					<input type="text" name="<?=$name?>Money" value="<?=ceil($row[$name.'Money'])?$row[$name.'Money']:''?>">
				</label>
				<div class="flex-middle2" data-con="Discount">
					<label class="ly_input">
						<input type="number" name="<?=$name?>Discount" value="<?=$row[$name.'Discount']?:''?>" int="">
						<div class="bg_pane"><b>%</b></div>
					</label>
					<div class="ml_10px"><?=language('{/panel.free.free_discount_tip/}')?></div>
				</div>
			</div>
		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>