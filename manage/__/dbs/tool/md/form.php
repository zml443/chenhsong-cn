<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($name, $value, $row, $cfg);

$rand = str::rand();
?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			
			<div acode="" autoheight mode="markdown"><textarea name='<?=$name?>' hide><?=$row[$name]?></textarea></div>

		<!-- 结束 -->
	</div>
</div>