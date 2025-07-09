<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>
<table class='cr8'>
	<tr>
		<td class='sma'>
			<label class='ly_switchery' size="small">
				<input type='checkbox' value='1' <?=$row['FreeOpen']?'checked':'';?> />
				<input type='hidden' name='FreeOpen' value='<?=$row['FreeOpen']?'1':'';?>' />
			</label>
			<input type="hidden" name="FreeSatrtPrice" value="<?=$row['FreeSatrtPrice']?>" />
		</td>
		<!-- <td text-right nowrap><?=price::rate($row['FreeSatrtPrice'])?></td> -->
	</tr>
</table>