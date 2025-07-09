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
			
			<ul class='ly_position min'>
				<?php for ($i=1; $i<=9; $i++) { ?>
					<label><input type='checkbox' data-number="1" name='<?=$name?>' value='<?=$i?>' <?=$value==$i?'checked':''?> /></label>
				<?php } ?>
			</ul>

		<!-- 结束 -->
	</div>
</div>