<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<?php if ($cfg['Lang']) { ?><span class='langselbox'></span><?php } ?>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->
		
			<?php
				if (substr($value,0,1)=='{') {
					d(str::json(htmlspecialchars_decode($value), 'decode'));
				} else {
					d($value);
				}
			?>

		<!-- 结束 -->
	</div>
</div>