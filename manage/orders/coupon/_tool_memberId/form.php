<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// d($row);

?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-between'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
		<?php
			if($row['Name']){
				if($row['DistributionQty']){
					echo "<div>{$row['DistributionQtyEd']}/{$row['DistributionQty']}</div>";
				}else
					echo language('panel.DistributionQty.number');
			}else{
				echo "<div class='ly_btn_radius pointer' bg='main' size='mini' onclick='_tool_memberId.createCode(this)'>自动生成</div>";
			}
		?>
		<!-- <div class="ly_btn_radius pointer" bg="main" size="mini" onclick="_tool_memberId.createCode(this)">自动生成</div> -->
	</div>
	<div id="No000" class='_dbs_content'>
		<!-- 开始 -->
		<?php
			if($row['Name']){
				echo "<input class='ly_input maxw' style='background: #f4f5f7;cursor: no-drop;color: #404852;' type='text' readonly='readonly' name='{$name}' value='{$row['Name']}' />";
			}else
				echo "<input class='ly_input maxw' type='text' data-code name='{$name}' placeholder='".language('notes.coupon_code_tip')."' value='{$row['Name']}' />";
		?>
		<label class="mt_15px pointer flex-btn">
			<i class="ly_checkbox lyicon-select-bold mr_10px"></i>
			<input type="checkbox" class="hide" value="1" <?=$row[$name.'Combined']?'checked':''?>/>
			<input type="hidden" name="<?=$name?>Combined" value="<?=$row[$name.'Combined']?>" />
			<span><?=language('panel.free.Combined')?></span>
		</label>
		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>