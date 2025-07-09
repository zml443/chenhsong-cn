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
			<?php
				foreach ($cfg['Args'] as $k => $v) {
					echo stristr(','.$value.',', ",{$k},") ? $v.(count($cfg['Args'])-1 != $k?"、":"") : '';
				}	
			?>	
		<?php }else{?>
			<div class="">
				<?php
					//////////////////////////////////////////////////////
					// json组件调用时需要做判断
					$value_first = substr($value,0,1);
					if ($value_first=='[' || $value_first=='{') {
						$value = implode(',', str::json(htmlspecialchars_decode($value), 'decode'));
					}
					//////////////////////////////////////////////////////
					foreach ($cfg['Args'] as $k => $v) {
						$chk = stristr(','.$value.',', ",{$k},") ? 'checked' : '';
				?>
					<label class='mr_25px flex-btn pointer'>
						<i class="ly_checkbox lyicon-select-bold mr_5px"></i>
						<input type='checkbox' class="hide" value='<?=$k?>' <?=$chk?>><?=$v?>
						<input type='hidden' name='<?=$name?>[]' value='<?=$k?>' />
					</label>
				<?php } ?>
			</div>
		<?php }?>

		<!-- 结束 -->
	</div>
</div>