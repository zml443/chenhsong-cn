<?php
// 防止胡乱进入
isset($c) || exit;
$web = db::result("select * from wb_site_web where Used=1 limit 1");
if (!$web) {
	js::location('/manage/?ma=website/module','','top');
}

$_SESSION['website_preview_model'] = 1;


if ($_GET['Id']) {
	js::location('/tools/website/dist/?Id='.$_GET['Id']);
} else {
	js::location('/tools/website/dist/');
}


?>