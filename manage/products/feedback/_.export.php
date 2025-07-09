<?php
p('products.feedback.export') || str::msg(language('notes.no_permit'));
$where = '1=1';
$row = db::get_whole('wb_products_feedback', $where, '*', 'MyOrder asc, AddTime desc');
$i = 1;
$data_excel = array(// 设置内容
	'ColumnWidth'	=>	array(// 列宽
		'A'	=> 30,
		'B'	=> 24,
		'C'	=> 18,
		'D'	=> 18,
		'E'	=> 18,
		'F'	=> 40,
		'G'	=> 20,
		'H'	=> 60,
	),
	'GlobalStyle'	=>	array(// 全局样式
		'Height' => 30,
		'NoWrap' => 1,
	),
	'ExcelContents' => array(// 内容
		excel::list_array_index($i, '姓名', 0), // 参数0表示重置下标
		excel::list_array_index($i, '电话'),
		excel::list_array_index($i, '邮箱'),
		excel::list_array_index($i, 'IP地址'),
		excel::list_array_index($i, '时间'),
		excel::list_array_index($i, '内容'),
	),
);
foreach ($row['row'] as $k => $v) {
	$i++;
	$ip = ip::info($v['Ip']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['Name'], 0); // 参数0表示重置下标
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['Phone']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['Email']);
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $ip['ip'] . '【'.$ip['country'].'.'.$ip['area'].'】');
	$data_excel['ExcelContents'][] = excel::list_array_index($i, date('Y/m/d', $v['AddTime']));
	$data_excel['ExcelContents'][] = excel::list_array_index($i, $v['Message']);
}
// d($data_excel);die;
log::manage('products/feedback', '批量导出产品询盘数据');
excel::export($data_excel, 'products.feedback.'.date('ymd'));// 开始导出
?>