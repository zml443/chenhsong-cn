<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$flag = $row[$name]||($this->is_add && (int)$cfg['Sql'][1]);

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content clean'>
		<!-- 开始 -->
			
			<?php if ($cfg['EditShow']) { ?>
				<label class='ly_switchery'>
					<input type='checkbox' value='1' <?=$flag?'checked':''?> disabled />
					<input type='hidden' name='<?=$name?>[]' value='<?=$flag?'1':'0'?>' />
				</label>
			<?php } else { ?>
				<label class='ly_switchery'>
					<input type='checkbox' value='1' <?=$flag?'checked':''?> />
					<input type='hidden' name='<?=$name?>' value='<?=$flag?'1':'0'?>' />
				</label>
			<?php } ?>

		<!-- 结束 -->
	</div>
</div>