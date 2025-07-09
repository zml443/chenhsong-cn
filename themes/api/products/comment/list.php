<?php
isset($c)||exit;
$row = wb_products_comment::limit($_POST);
echo str::json($row);
?>