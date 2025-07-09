<?php

$table_search_where_extid = $this->table.'_search_where_extid';
$table_search_where = $this->table.'_search_where';
if (!db::has_table($table_search_where_extid) || !db::has_table($table_search_where)) {
	exit(str::json(array(
		'msg' => '表结构不对，无法使用',
		'ret' => 0,
	)));
}

$where = '1';

$res = db::query("select * from {$table_search_where} where {$where} order by MyOrder asc,Id asc");
$ids = array();
$this->row = array();
while ($v = db::result($res)) {
	$ids[] = (int)$v['Id'];
	$this->row[$v['Id']] = str::code($v);
	$this->row[$v['Id']]['children'] = array();
}

if ($ids) {
	$ids = implode(',', $ids);
} else {
	exit(str::json(array(
		'msg' => '',
		'ret' => 0,
	)));
}
// 查询关联
$res2 = db::query("select * from {$table_search_where_extid} where {$table_search_where}_id in({$ids}) order by MyOrder asc,Id asc");
while ($v = db::result($res2)) {
	$wid = $v[$table_search_where.'_id'];
	if ($this->table_copy && isset($v[$this->table.'__copy_id'])) {
		$v[$this->table.'_id'] = $v[$this->table.'__copy_id'];
	}
	$this->row[$wid]['children'][] = str::code($v);
}

exit(str::json(array(
	'data' => array_values($this->row),
	'ret' => 1,
)));

