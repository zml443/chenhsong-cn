<?php

/*if (c('HostTag')=='shop') {
    $app_store_ary = include c('root').'manage/__/app-shop.php';
} else {
    $app_store_ary = include c('root').'manage/__/app-web.php';
}

$url = strrchr(url::get(),'?');

if ($app_store_ary['_']['wb_products'] || g('app_store.products.wb_products')) {
	js::location('/products/'.$url);
} else if ($app_store_ary['_']['wb_blog'] || g('app_store.other.wb_blog')) {
	js::location('/blog/'.$url);
}*/

function_exists('c') || exit;

echo str::json(saas::html(array(
	'variable' => 1,
	'type' => 'search'
)));
?>