<?php
// 已被使用的变量
// $name, $value, $row, $cfg






?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->

			<label class='switchery'><input type='checkbox' name='<?=$name?>' value='1' <?=$value?'checked':''?>></label>

		<!-- 结束 -->
	</div>
</div>