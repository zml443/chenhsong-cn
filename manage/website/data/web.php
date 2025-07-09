<?php
// $row = db::get_one('wb_site_page', "Id='1'");

$where = "IsUsed=1";
if (in_array(c('HostTag'), array('shop', 'shopen'))) {
	$where .= " and Tag='shop'";
} else {
	$where .= " and Tag='web'";
}
$res = lydb::query("select * from ss_web where {$where}");
$row = array();
$website_id = g('website.number');
while ($v = lydb::result($res)) {
	$v['cur'] = $website_id==$v['Number']?'cur':'';
	$row[] = $v;
}
exit(str::json($row));
