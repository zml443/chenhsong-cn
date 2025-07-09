<?php
// 已被使用的变量
// $name, $prefix_name, $row, $cfg
?>




<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class="flex-wrap" style="gap:20px">
				<?php
					foreach ((array)$cfg['Args'] as $k => $v) { 
				?>
					<label class='ly_btn_checkbox'>
						<i class="mr_5px lyicon-select-bold"></i>
						<span><?=$v?></span>
						<input class="hide" type='checkbox' value='1' <?=$row[$k]?'checked':'';?>>
						<input type='hidden' name='<?=$k?>' value='<?=$row[$k]?'1':'0';?>' />
					</label>
				<?php 
					} 
				?>
			</div>

		<!-- 结束 -->
	</div>
</div>