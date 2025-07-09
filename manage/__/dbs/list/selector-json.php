<?php
// 防止胡乱进入
function_exists('c')||exit;

// 获取字段名
if ($this->dbc['Picture']) {
	$picture_name = 'Picture';
} else if ($this->dbc['Pictures']) {
	$picture_name = 'Pictures';
} else {
	$picture_name = '';
}
if($this->dbc['Name']){
	if ($this->dbc['Name']['Lang']) {
		$title_name = ln('Name');
	} else {
		$title_name = 'Name';
	}
}else{
	if ($this->dbc['FirstName']) {
		$title_name = 'FirstName';
	}elseif ($this->dbc['Email']) {
		$title_name = 'Email';
	}elseif ($this->dbc['Phone']){
		$title_name = 'Phone';
	}
}
// 已选择的数据
$choice_ids = explode(',',$_GET['_choice_ids']);
foreach($choice_ids as &$v){ $v = (int)$v; }
$current = db::query("select * from ".$this->table." where Id in(".implode(',',$choice_ids).") order by ".$this->orderby);
while ($v = db::result($current)) {
	// $v = str::code($v);
	$r = array(
		'id' => $v['Id'],
	);
	if($picture_name){
		$r['path'] = $v[$picture_name];
	}
	if ($title_name=='FirstName') {
		$r['name'] = str::real_name($v['FirstName'],$v['LastName']);
	} else {
		$r['name'] = $v[$title_name];
	}
}

exit(str::json(array(
	'data' => $row,
	'ret' => 1
)));

?>