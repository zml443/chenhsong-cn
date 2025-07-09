<?php
// 已被使用的变量
// $name, $row, $cfg



// echo $row[$name] ? '是' : '';
?>

<?php if ($cfg['EditHIde']) { ?>
	<label class='ly_switchery' size="small"><input type='checkbox' value='1' <?=$row[$name]?'checked':''?> disabled></label>
<?php } else { ?>
	<label class='ly_switchery' size="small"><input type='checkbox' value='1' <?=$row[$name]?'checked':''?> dbs='mod-list-radio,<?=$row['Id']?>'><input type='hidden' name='<?=$name?>' value='<?=$row[$name]?'1':''?>'></label>
<?php } ?>