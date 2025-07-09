<?php

$row = db::get_category($this->table, $this->where);

exit(str::json($row));