<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// d($name, $value, $row, $cfg);


	$mids = explode(',', $row[$name]);
	$mid = '0';
	foreach ($mids as $v) {
		$mid .= ','.(int)$v;
	}
	$member = db::all("select * from wb_member where Id in ($mid)");
	foreach ($member as $v) {
?>
	<div>
		<?=$v['UserName'] ? $v['UserName'] : ($v['Mobile'] ? $v['Mobile'] : $v['Phone']);?>
		<a hr-ef='<?=c('manage.url.email')?>&toEmail=<?=$v['Email']?>/<?=$v['UserName']?>'><?=$v['Email']?></a>
	</div>
<?php
	}
?>