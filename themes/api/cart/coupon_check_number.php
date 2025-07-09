<?php

$coupon = db::get("wb_orders_coupon::can_use", array(
	'number' => $_POST['number']
));

if ($coupon) {
	str::msg('can use', 1);
} else {
	str::msg('不可使用',0);
}

?>