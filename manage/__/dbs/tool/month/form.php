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

			<span class='ly_input w360'>
				<!-- <b>.*<div class='arrow'><em></em><i></i></div></b> -->
				<input type='text' name='<?=$name?>' value='<?=$value?date('Y-m',$value):''?>'  class='form_input' ly-laydate='month' size='40'>
			</span>

		<!-- 结束 -->
	</div>
</div>