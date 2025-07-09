<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($name, $value, $row, $cfg);

?>



<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php if ($cfg['EditShow']) { ?>
					<?php foreach ($cfg['Field'] as $k => $v) { ?>
						<div><?=$row[$k]?></div>
					<?php } ?>
			<?php } else { ?>
				<div class='address' address>
					<?php foreach ($cfg['Field'] as $k => $v) { ?>
						<label class="ly_input inline-flex mr_5px width150"><select name='<?=$k?>'><?=$row[$k]?></select></label>
					<?php } ?>
				</div>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>