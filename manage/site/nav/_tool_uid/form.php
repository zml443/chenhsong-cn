<?php
// 已被使用的变量
// $name, $value, $row, $cfg


if ($cfg['Dept']==1) {
	return '';
}
?>

<input type="hidden" name='<?=$name?>' value="<?=$value?:$_GET['UId']?>" />