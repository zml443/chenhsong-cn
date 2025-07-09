<?php
// 已被使用的变量
// $name, $value, $row, $cfg




?>
<div class='ly_img'>
	<?php if ($cfg['Lang']) { ?>
		<img src='<?=img::ary($row[ln($name)])?>' alt=''>
	<?php } else { ?>
		<img src='<?=img::ary($row[$name])?>' alt=''>
	<?php } ?>
</div>