<?php
include '../../../php/init.php';	

$json = wb_address_country::drop_select(array(
	'Dept' => 2
));
echo str::json(array_values($json));
?> 