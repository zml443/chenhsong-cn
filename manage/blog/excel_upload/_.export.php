<?php
$data_excel = array(// 设置内容
	'ColumnWidth'	=>	array(// 列宽
		30,
		18,
		18,
		40,
	),
	'ExcelContents' => array(// 内容
		excel::list_array_index(1, '名称', 0), // 参数0表示重置下标
		excel::list_array_index(1, '分类'),
		excel::list_array_index(1, '时间'),
		excel::list_array_index(1, '简短介绍'),
		// =================================================
		excel::list_array_index(2, '文章名称', 0), // 参数0表示重置下标
		excel::list_array_index(2, '文章分类'),
		excel::list_array_index(2, date('Y/m/d', c('time'))),
		excel::list_array_index(2, '这里写的是简短介绍'),
		// =================================================
	),
);
log::manage('news/excel_upload', '下载模板');
excel::export($data_excel, 'news-demo');// 开始导出
?>