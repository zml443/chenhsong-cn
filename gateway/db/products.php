<?php
function_exists('c') || exit;

if ($_SESSION['website_preview_model']) {

} else {
	// 
}

echo str::json(saas::html(array(
	'variable' => 1,
	'type' => 'products'
)));
?>