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
			
			<?php if ($cfg['EditShow']) { ?>
				<?=price::rate(0,1)?> <?=$value?>
			<?php } else { ?>
				<div class='ly_input'>
					<b><?=price::rate(0,1)?></b>
					<input type='number' name='<?=$name?>' value="<?=$value?>"  step="0.01" />
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>