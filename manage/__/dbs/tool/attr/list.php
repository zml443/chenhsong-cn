<?php
// 已被使用的变量
// $name, $value, $row, $cfg





?>

<table>
	<?php foreach ((array)$cfg['Args'] as $k => $v) { ?>
		<tr>
			<td><?=$v?>&nbsp;</td>
			<td class='sma'>
				<label class='ly_switchery' size="small">
					<input type='checkbox' name='<?=$k?>' value='1' <?=$row[$k]?'checked':'';?> dbs='mod-list-radio,<?=$row['Id']?>'>
					<input type='hidden' name='<?=$k?>' value='<?=$row[$k]?'1':'';?>'>
				</label>
			</td>
		</tr>
	<?php } ?>
</table>