<?php
function_exists('c') || exit;

echo str::json(saas::html(array(
	'variable' => 1,
	'type' => 'index'
)));
// echo saas::html(c('module.dir').'w013/index/_.conf.php');
?>