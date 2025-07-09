<?php
// 已被使用的变量
// $name, $value, $row, $cfg




?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->
			<?php if ($cfg['Lang']) { ?>
				<div mLanguage>
					<?php
						foreach ($this->language as $k => $v) {
							$n = $this->lang($name, $v);
							$val = str::code(str::json(htmlspecialchars_decode($value[$v]), 'decode'));
					?>
						<div class="flex-middle2 <?=$k?'hide':''?>">
							<div class='ly_input w160'><input type='text' name='<?=$n?>[number]' value="<?=$val['number']?>"></div>
							<div class='ml_20px'><?=language('{/global.unit/}')?></div>
							<div class='ly_input w100'><input type='text' name='<?=$n?>[unit]' value="<?=$val['unit']?>"></div>
						</div>
					<?php } ?>
				</div>
			<?php } else { ?>
				<?php $value = str::code(str::json(htmlspecialchars_decode($value), 'decode'));?>
				<div class="flex-middle2">
					<div class='ly_input w160'><input type='text' name='<?=$name?>[number]' value="<?=$value['number']?>"></div>
					<div class='ml_20px'><?=language('{/global.unit/}')?></div>
					<div class='ly_input w100'><input type='text' name='<?=$name?>[unit]' value="<?=$value['unit']?>"></div>
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>