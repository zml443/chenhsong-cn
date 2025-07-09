<?php
// 已被使用的变量
// $name, $row, $cfg





?>

<?php if ($cfg['EditLi']) { ?>

	<label class="ly_input" size="small">
		<b>KG</b>
		<input type="number" name="<?=$name?>" value="<?=$row[$name]?>" step="0.001" />
	</label>

<?php } else { ?>

	<?=$row[$name]?>KG

<?php } ?>