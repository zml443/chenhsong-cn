<?php
// 已被使用的变量
// $name, $row, $cfg





?>

<?php if ($cfg['EditLi']) { ?>

	<label class="ly_input"><input type="number" name="<?=$name?>" value="<?=$row[$name]?>" size="12" step="0.000001" /></label>

<?php } else { ?>

	<?=$row[$name]?>

<?php } ?>