<?php
// 已被使用的变量
// $name, $value, $row, $cfg




?>
<div class='ly_img'>
	<?php if ($cfg['Lang']) { ?>
		<img src='<?=$row[ln($name)]?>' alt=''>
	<?php } else { ?>
		<img src='<?=$row[$name]?>' alt=''>
	<?php } ?>
</div>