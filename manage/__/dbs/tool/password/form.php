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

			<span class='ly_input width300'>
				<input type='text' name='Password' value=''>
			</span>

		<!-- 结束 -->
	</div>
</div>
