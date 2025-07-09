<?php
isset($c) || exit();

$list = wb_member_address::limit_current($_POST);

echo str::json($list);
?>