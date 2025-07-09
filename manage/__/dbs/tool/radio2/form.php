<?php
// 已被使用的变量
// $name, $value, $row, $cfg



?>



<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>' data-dbs-name="<?=$name?>">
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
							if (!is_array($v)) {
								$v = array('text'=>$v);
							}
					?>
						<label class='ly_btn_radio pointer mr_20px mb_10px'>
							<i class="ly_radio mr_10px"><input type='radio' name='<?=$name?>' value='<?=$k?>' <?=$chk?>></i>
							<span><?=$v['text']?></span>
							<?=$v['tip']?"<a class='lyicon-help ml_10px' ly-tip-bubble='{}' data-tip-contents='".nl2br($v['tip'])."'></a>":''?>
						</label>
					<?php } ?>
				</div>
			<?php }?>

		<!-- 结束 -->
	</div>
</div>