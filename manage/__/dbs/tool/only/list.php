<?php
// 已被使用的变量
// $name, $row, $cfg



// echo $row[$name] ? '是' : '';
?>

<label class='ly_switchery' size="small">
	<input type='checkbox' name='<?=$name?>' value='1' <?=$row[$name]?'checked':'';?> dbs='mod-list-radio,<?=$row['Id']?>' fn="_type_for_only">
</label>
<script>$.include('<?=file::self_dir(__FILE__)?>list.js');</script>