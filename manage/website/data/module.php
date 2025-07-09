<?php
function_exists('c')||exit();

$page_row = db::result("select * from wb_site_page_copy where Id='{$_POST['wb_site_page_id']}'");
if (!$page_row) {
	exit('[]');
}



$global_str = "'other', 'crumb', 'pictures', 'banner', 'video', 'newsletter', 'code', 'editor', 'faq'";
$where = "IsUsed=1 and PersonalExclusive=''";
if ($_POST['current_parts_name']) {
	$where .= " and Parts='{$_POST['current_parts_name']}'";
} else {
	$where .= " and Parts='content'";
}

if ($_POST['current_parts_name']=='header') { //首页查询方式
	// $where .= " and Type='header'";

} else if ($_POST['current_parts_name']=='footer') { //首页查询方式
	// $where .= " and Type='footer'";

} else if ($page_row['Type']=='index') { //首页查询方式
	$where .= " and (PageType='index' or Type in($global_str))";

} else { //内页查询方式
	$global_str .= ", 'category'";
	$where .= " and PageType='inner'";
	switch ($page_row['Type']) {
		// 案例
		case 'case':
			$where .= " and Type in($global_str, 'case')";
			break;
		case 'case-detail':
			$where .= " and Type in($global_str, 'case-detail', 'blog-else')";
			break;
		// 博客
		case 'branches':
			$where .= " and Type in($global_str, 'branches')";
			break;
		case 'branches-detail':
			$where .= " and Type in($global_str, 'branches-detail')";
			break;
		// 博客
		case 'solution':
			$where .= " and Type in($global_str, 'solution')";
			break;
		case 'solution-detail':
			$where .= " and Type in($global_str, 'solution-detail', 'case-else', 'solution-else', 'product-else', 'download-else', 'server-else')";
			break;
		// 博客
		case 'server':
			$where .= " and Type in($global_str, 'server')";
			break;
		case 'server-detail':
			$where .= " and Type in($global_str, 'server-detail', 'case-else', 'server-else', 'product-else', 'download-else', 'server-else')";
			break;
		// 博客
		case 'blog':
			$where .= " and Type in($global_str, 'blog')";
			break;
		case 'blog-detail':
			$where .= " and Type in($global_str, 'blog-detail', 'case-else', 'solution-else', 'product-else', 'download-else', 'server-else')";
			break;
		// 下载
		case 'download':
			$where .= " and Type in($global_str, 'download')";
			break;
		case 'download-detail':
			$where .= " and Type in($global_str, 'download-detail', 'case-else', 'solution-else', 'product-else', 'server-else')";
			break;
		// 产品
		case 'products':
			$where .= " and Type in($global_str, 'product')";
			break;
		case 'products-detail':
			$where .= " and Type in($global_str, 'product-detail', 'product-comment', 'case-else', 'solution-else')";
			break;
		// 团队
		case 'team':
			$where .= " and Type in($global_str, 'team')";
			break;
		case 'team-detail':
			$where .= " and Type in($global_str, 'team-detail')";
			break;
		// 联系我们
		case 'contact-us':
			$where .= " and Type in($global_str, 'contact-us')";
			break;
		// 联系我们
		case 'about':
			$where .= " and Type in($global_str, 'about')";
			break;
		// 常见问题
		case 'faq':
			$where .= " and Type in($global_str, 'faq')";
			break;
		
		default:
			$where .= " and Type in($global_str, 'about', 'history')";
			break;
	}
}
if ($_POST['type']) {
	$where .= " and Type='{$_POST['type']}'";
}

$res = lydb::query("select * from module where $where");
$row = array();
while ($v = lydb::result($res)) {
	$v['Picture'] = '/module/'.$v['Number'].'/pc.jpg';
	if (!is_file(c('root').$v['Picture'])) {
		$v['Picture'] = '';
	}
	$row[] = $v;
}
exit(str::json($row));
