<?php

function_exists('c') || exit;


$fields3 = db::fields('wb_site_page');
$fields6 = db::fields('wb_site_page_copy');


if (!$fields3['IsHidden']) {
	db::query("alter table wb_site_page add `IsHidden` int(1) default '0'");
}
if (!$fields6['IsHidden']) {
	db::query("alter table wb_site_page_copy add `IsHidden` int(1) default '0'");
}

