<?php
// 已被使用的变量
// $name, $value, $row, $cfg



$attr = $cfg['NotNull'] ? 'notnull' : '';

?>


<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php if ($cfg['Lang']) { ?>
				<div mLanguage>
					<?php
						foreach ($this->language as $k => $v) {
							$n = $this->lang($name, $v);
					?>
						<div class="<?=$k?'absolute goaway':''?>">
							<?php if ($cfg['EditShow']) { ?>
								<?=$value[$v] ? nl2br($value[$v]) : '--'?>
							<?php } else { ?>
								<label class='ly_input'>
									<textarea size="default" autoHeight name='<?=$n?>' <?=$attr?>><?=$value[$v]?$value[$v]:(is_array($cfg['Value'])?$cfg['Value'][$v]:$cfg['Value'])?></textarea>
								</label>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			<?php } else { ?>
				<?php if ($cfg['EditShow']) { ?>
					<?=$value ? nl2br($value) : '--'?>
				<?php } else { ?>
					<span class='ly_input'>
						<textarea size="default" autoHeight name='<?=$name?>' <?=$attr?>><?=$value?$value:$cfg['Value']?></textarea>
					</span>
				<?php } ?>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>