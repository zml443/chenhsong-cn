<?php
// 已被使用的变量
// $name, $value, $row, $cfg




?>

<div class='_dbs_item -show <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<?php
				if ($value) {
					$val = ip::info($value);
					echo $val['ip'] . '【'.$val['country'].'.'.$val['area'].'】';
				}
				else {
			?>
				<font color="#999">N/A</font>
			<?php 
				}
			?>

		<!-- 结束 -->
	</div>
</div>