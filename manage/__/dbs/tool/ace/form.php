<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($name, $value, $row, $cfg);

?>



<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div style="border:1px solid #ccc" autoheight acode="" mode="<?=$cfg['Mode']?>" -theme="monokai"><textarea name='<?=$name?>' hide><?=$value?$value:$cfg['Value']?></textarea></div>

		<!-- 结束 -->
	</div>
</div>