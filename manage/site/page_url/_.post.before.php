<?php

// 防止胡乱进入
function_exists('c')||exit;


foreach ($this->dbc as $k => $v) {
	if ($_POST[$k] && is_array($_POST[$k])) {
		$_POST[$k]['prefix'] && $_POST[$k]['prefix'] = preg_replace('/[^\\-_a-zA-Z0-9]/', '', $_POST[$k]['prefix']);
	}
}