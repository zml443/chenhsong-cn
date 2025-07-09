<?php
// p('products.index.export') || str::msg(language('notes.no_permit'));

$where = '1=1';
if ($_GET['ids']) {
	//...
	$where = "Id in({$_GET['ids']})";
}
$row = db::get_all('wb_products', $where, '*', 'MyOrder asc, AddTime desc');
$category = db::get_category("wb_products_category");

$i = 1;
$data_excel = array(// 设置内容
	'ColumnWidth'	=>	array(// 列宽
		30,
		18,
		24,
		18,
		18,
		18,
		40,
		20,
	),
	'GlobalStyle'	=>	array(// 全局样式
		'Height' => 30,
		'NoWrap' => 1,
	),
	'ExcelContents' => array(// 内容
		excel::list_array_index($i, '名称', 0), // 参数0表示重置下标
		excel::list_array_index($i, '编号'),
		excel::list_array_index($i, '分类'),
		excel::list_array_index($i, '价格'),
		excel::list_array_index($i, '参考价'),
		excel::list_array_index($i, '会员价'),
		excel::list_array_index($i, '时间'),
		excel::list_array_index($i, '简短介绍'),
		// excel::list_array_index($i, '详情内容'),
	),
);
foreach ($row['row'] as $k => $v) {
	$i++;
	$category_name = '';
	$cids = explode(',', $v['CateId']); //多分类的时候
	foreach ($cids as $cid) {
		$category_name .= ', '.$category[$cid][ln('Name')];
	}
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v[ln('Name')], 0); // 参数0表示重置下标
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['ItemNumber']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, ltrim($category_name, ', '));
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['Price']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['UnPrice']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['MemberPrice']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, date('Y/m/d', $v['AddTime']));
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v[ln('Brief')]);
	// $data_excel['ExcelContents'][] = excel::list_array_index($i, $detail[$v['Id']]['Contents']);
}
// d($data_excel);die;
log::manage('products/index', '批量导出产品数据');
excel::export($data_excel, 'products.'.date('ymd'));// 开始导出
?>