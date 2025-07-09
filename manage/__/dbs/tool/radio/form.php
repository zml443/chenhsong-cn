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
				<?=$cfg['Args'][$value]?>
			<?php }else{?>
				<div class="flex-middle2 flex-wrap">
					<?php
						foreach ($cfg['Args'] as $k => $v) {
							$chk=$value==$k?'checked':'';
					?>
						<label class='flex-middle2 pointer mr_20px'>
							<i class="ly_radio mr_3px"><input type='radio' name='<?=$name?>' value='<?=$k?>' <?=$chk?>></i>
							<span><?=$v?></span>
						</label>
					<?php } ?>
				</div>
			<?php }?>

		<!-- 结束 -->
	</div>
</div>