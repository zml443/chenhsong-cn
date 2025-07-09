<?php
// 已被使用的变量
// $name, $value, $row, $cfg



?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php if ($cfg['EditShow']) { ?>
				<?=$value ? $value : '--'?>
			<?php } else { ?>
				<span class="ly_input">
					<input type='number' name='<?=$name?>' value="<?=$value?>" step="0.00001" />
				</span>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>