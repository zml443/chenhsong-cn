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
		
			<label class="ly_input_suffix" ly-drop-select="">
				<input type="text" value="" placeholder="选择国家" />
				<input type="hidden" name="Country" value="<?=$row['Country']?>" />
				<input type="hidden" name="Province" value="<?=$row['Province']?>" />
				<input type="hidden" name="City" value="<?=$row['City']?>" />
				<input type="hidden" name="Town" value="<?=$row['Town']?>" />
				<i class="lyicon-arrow-down-bold"></i>
				<script type="text" data-href="address_country"></script>
			</label>

		<!-- 结束 -->
	</div>
</div>