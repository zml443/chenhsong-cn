<?php
// 已被使用的变量
// $name, $row, $cfg





?>

<?php if ($cfg['EditLi']) { ?>

	<label class="ly_input" size="small">
		<b><?=price::rate(0,1)?></b>
		<input type="number" name="<?=$name?>" value="<?=$row[$name]?>"  step="0.01" />
	</label>

<?php } else { ?>

	<?=price::rate(0,1)?><?=$row[$name]?>

<?php } ?>