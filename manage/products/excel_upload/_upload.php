<?php
p('products.excel_upload.add') || str::msg(language('notes.no_permit'));
if (!is_file(c('root').$_POST['xls'])) {
	str::msg(language('notes.upload_xls_file'), 0);
}
$a = array(
	'page'		=>	(int)$_POST['page'],
	'row'		=>	800,
);
$repeat_name = array();
$data = excel::upload_data($_POST['xls']);
foreach((array)$data['data'] as $k=>$v){
	if($k<=$a['page']*$a['row']){
		continue;
	}
	if( (($a['page']+1)*$a['row']+1)<=$k ){
		$progress = round(($a['page']+1)*$a['row']/$data['count']*100, 2);
		$progress = $progress<100?$progress:100;
		str::msg(array(
			'txt'		=> '正在导入...'.$k,
			'progress'  => $progress.'%',
			'repeat'	=> $repeat_name,
		), -100);
	}
	//整理分类
	$cids = array();
	$category_name = explode(',', str_replace('，', ',', $v[2]));
	foreach ($category_name as $cname) {
		if (!$cname) continue;
		$cname = addslashes($cname);
		if ($cate = db::get_one('wb_products_category', "Name_cn='{$cname}'", 'Id')) {
			$cids[] = $cate['Id'];
		}
		else {
			db::insert('wb_products_category', array(
				'Name_cn' => $cname
			));
			$cids[] = db::get_insert_id(); 
		}
	}
	// 数据过滤
	$v = str::code($v, 'addslashes');
	//数据保存
	//$v = str::code($v, 'addslashes');
	// d($v);
	$d = array(
		'Name'		=>	$v[0],
		'ItemNumber'	=>	$v[1],
		'CateId'		=>	implode(',', $cids),
		'Price'			=>	(float)$v[3],
		'UnPrice'		=>	(float)$v[4],
		'MemberPrice'	=>	(float)$v[5],
		'Brief'		=>	$v[6],
		// 'PicPath'		=>	str::json(@explode(',', str_replace(array(';','，','；'),',',$v[7]))),
		'EditTime'		=>	c('time')
	);
	// d($d);
	// 重复项
	if ($one = db::get_one('wb_products',"(Name='{$d['Name']}')")){
		$Id = $one['Id'];
		// $repeat_name[] ="行数:{$k} -> ".$d['Name_cn'];
		db::update('wb_products', "Id=$Id", $d);
	}
	// 添加
	else {
		db::insert('wb_products', $d);
		$Id=db::get_insert_id();
	}
}
file::unlink($data['file']);
log::manage('products/excel_upload', '批量导入数据');
str::msg(array(
	'txt'		=> '批量上传完成',
	'progress'  => '100%',
	'repeat'	=> $repeat_name,
), 1);
?>