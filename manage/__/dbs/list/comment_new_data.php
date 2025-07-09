<?php

$row = db::get_row_count($this->table, $this->where.' and Id>'.(int)$_GET['_min_id']);

exit(str::json(array(
	'ret' => 1,
	'has_new_data' =>$row?1:0
)));