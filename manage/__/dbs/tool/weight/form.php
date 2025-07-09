<?php
// 已被使用的变量
// $name, $value, $row, $cfg





?>



<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class='ly_input'>
				<b>Kg</b>
				<input type='number' name='<?=$name?>' value="<?=$value?>" step="0.001" />
			</div>

		<!-- 结束 -->
	</div>
</div>