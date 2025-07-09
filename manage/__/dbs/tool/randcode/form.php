<?php
// 已被使用的变量
// $name, $value, $row, $cfg



$attr = $cfg['NotNull'] ? 'notnull' : '';

?>

<div class='_dbs_item -show <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->

			<?=$value?>

		<!-- 结束 -->
	</div>
</div>