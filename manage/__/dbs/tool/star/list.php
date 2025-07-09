<?php
// 已被使用的变量
// $name, $row, $cfg



	$table = $this->tablename($cfg['Table']);
	$ex_id = $table.'_id';
	$tar = db::get_one($table, "Id='{$row[$ex_id]}'");
	echo $tar['Name']?$tar['Name']:$tar[ln('Name')];
	// d($ex_id, $row);
?>