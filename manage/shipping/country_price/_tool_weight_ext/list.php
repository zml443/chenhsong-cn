<?php
// 已被使用的变量
// $name, $row, $cfg

$field_key = array();
foreach ($cfg['Field'] as $k => $v) $field_key[] = $k;
$ext_weight_name = $field_key[0];
$ext_price_name = $field_key[1];

?>

<?php if ($cfg['EditLi']) { ?>

	<table class="maxw">
		<tr>
			<td>
				<label class="ly_input" size="small">
					<b>Kg</b>
					<input type="number" name="<?=$ext_weight_name?>" value="<?=$row[$ext_weight_name]?>" dbs="mod-list-input,<?=$row['Id']?>" />
				</label>
			</td>
			<td>&nbsp;/&nbsp;</td>
			<td>
				<label class="ly_input" size="small">
					<b><?=price::rate(0,1)?></b>
					<input type="number" name="<?=$ext_price_name?>" value="<?=$row[$ext_price_name]?>" dbs="mod-list-input,<?=$row['Id']?>" />
				</label>
			</td>
		</tr>
	</table>

<?php } else { ?>

	<?=$row[$ext_weight_name]?> Kg / <?=price::rate(0,1)?><?=$row[$ext_price_name]?>

<?php } ?>