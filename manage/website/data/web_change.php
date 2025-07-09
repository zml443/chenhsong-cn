<?php

function_exists('c')||exit;

$web_row = db::result("select * from wb_site_web where Number='{$_POST['Number']}'");
if ($web_row) {
	db::update("wb_site_web", "1", array(
		'Used' => 0
	));
	db::update("wb_site_web", "Id='{$web_row['Id']}'", array(
		'Used' => 1
	));
	exit(str::json(array(
		'msg' => '已更新',
		'ret' => 1,
	)));
}

/*$web = lydb::result("select * from ss_web where Number='{$_POST['Number']}'");
if (!$web) {
    str::msg('数据错误');
}*/

/*$all = lydb::query("select * from ss_page where ss_web_id='{$web['Id']}'");
if ($all->num_rows==0) {
    str::msg('数据错误');
}*/
$result = saas_db::insert('copy', array(
	'wb_site_web_id' => (int)$web_row['Id'],
	'web_number' => $_POST['Number'],
));

if ($result['ret']==0) {
	exit(str::json(array(
		'msg' => '创建失败',
		'ret' => 0,
	)));
}

/*$count = db::result("select count(*) as a from wb_site_web", 'a');

if ($count==1) if (c('HostTag')=='shop') {
	$app_store = array(
		'blog' => 'other.wb_blog',
		'faq' => 'other.wb_faq',
		'history' => 'other.wb_history',
		'partner' => 'other.wb_partner',
		'case' => 'other.wb_case',
		'download' => 'other.wb_download',
		'solution' => 'other.wb_solution',
	);
} else {
	$app_store = array(
		'products' => 'other.wb_products',
		'blog' => 'other.wb_blog',
		'faq' => 'other.wb_faq',
		'history' => 'other.wb_history',
		'partner' => 'other.wb_partner',
		'case' => 'other.wb_case',
		'download' => 'other.wb_download',
		'solution' => 'other.wb_solution',
	);
}

mysqli_data_seek($all,0);
while ($v = lydb::result($all)) {
	$type = $app_store[$v['Type']];
	if ($type) {
		g('app_store.'.$type, '1');
	}
}*/


log::manage('wb_site_page', '页面风格切换：'.$_POST['Number']);

str::msg('已更新',1);
?>