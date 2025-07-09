<?php
// 已被使用的变量
// $name, $value, $row, $cfg


$table = $this->tablename($cfg['Table']);
if ($row[$name]) {
	$ids = explode(',', $row[$name]);
	$id = '0';
	foreach ($ids as $k => $v) {
		$id .= ','.(int)$v;
	}
	$res = db::query("select * from $table where Id in($id)");
	while ($v=db::result($res)) {
		echo "<span class='ly_main_tag mr_5px' size='mini'>".($v['Name']?:$v[ln('Name')])."</span>";
	}
}