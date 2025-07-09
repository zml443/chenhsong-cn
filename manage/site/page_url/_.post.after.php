<?php

// 防止胡乱进入
function_exists('c')||exit;


foreach ($this->row as $k => $v) {
	if (!$this->before_row[$k] || $this->before_row[$k]!=$v) {
		db::update('page_url', "ExtTable='{$k}'", array(
			'PrefixUrl' => $v['prefix']
		));
	}
}