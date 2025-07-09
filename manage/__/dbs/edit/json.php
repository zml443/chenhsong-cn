<?php

if ($this->dbg) {
	$row = $this->row = g($this->table);
} else {
	$Id = (int)$_GET['Id'];
	$this->row = str::code(db::result("select * from {$this->table} where Id='{$Id}'"));	
}

foreach ($this->row as $k => &$v) {
	if (in_array(substr($v,0,1), array('{','[')) && in_array(substr($v,0,-1), array('}',']'))) {
		$data = str::json($v, 'decode');
		if ($data) {
			$v = $data;
		}
	}
}

exit(str::json(array(
	'data' => $this->row,
	'ret' => 1
)));