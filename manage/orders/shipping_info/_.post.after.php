<?php

db::update("wb_orders","Id='{$_POST['wb_orders_id']}'", array(
	'Status' => '3',
	'ShippingTime' => c('time')
));