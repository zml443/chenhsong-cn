<?php
function_exists('c') || exit;

echo str::json(saas::html(array(
	'variable' => 1,
	'type' => 'blog'
)));