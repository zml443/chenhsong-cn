<?php

$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;


$row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);

exit(str::json(array(
	'pg' => (int)$_GET['pg']?:1,
	'total' => (int)db::get_row_count($this->table, $this->where),
	'limit' => $this->limit,
	'children' => $row,
	'search_xz' => $this->search_xz,
	'search' => $this->search,
)));