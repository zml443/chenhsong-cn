<?php
// 已被使用的变量
// $name, $row, $cfg




// POST数据的预先整理
// 可使用 str::msg()
if ($callbackType=='post') {
	// $_POST[$name] = ip::get();
}


// 保存处理
// 不能使用 str::msg(), 会导致数据保存不完整，导致数据错误
else if ($callbackType=='save') {
	if ($_POST[$name]) {
		$where = "1=1";
		if ($_POST['ex_na'] && $_POST['ex_id'] && $this->fields[$_POST['ex_na']]) { //当有父子层数关系的时候，就判断当前层数内是否重复
			$ex_na = $_POST['ex_na'];
			$ex_id = (int)$_POST['ex_id'];
			$where .= " and `$ex_na`='{$ex_id}'";
		}
		$where .= " and Id<>'{$_POST['Id']}'";
		db::query("update ".$this->table." set `$name`=0 where $where");
	}
}

?>