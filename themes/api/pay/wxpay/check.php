<?php


$order = db::get_one("orders","OrderNumber='{$_POST['OrderNumber']}'");

if ($order['Status']==2) {
	str::msg($order['Status'], 1);
}
else {
	str::msg($order['Status'], 0);
}