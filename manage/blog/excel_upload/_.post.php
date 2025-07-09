<?php

p('news.excel_upload.add') || str::msg(language('notes.no_permit'));
if (!is_file(c('root').$_POST['xls'])) {
	str::msg(language('notes.upload_xls_file'), 0);
}
$a = array(
	'page'		=>	(int)$_POST['page'],
	'row'		=>	2,
);
$repeat_name = array();
$data = excel::upload_data($_POST['xls']);
// d($data);die;
foreach((array)$data['data'] as $k=>$v){
	if($k<=$a['page']*$a['row']){
		continue;
	}
	if( (($a['page']+1)*$a['row']+1)<=$k ){
		$progress = round(($a['page']+1)*$a['row']/$data['count']*100, 2);
		$progress = $progress<100?$progress:100;
		str::msg(array(
			'txt'		=> '正在导入...'.$a['row'].'-'.$k,
			'progress'  => $progress.'%',
			'repeat'	=> $repeat_name,
		), -100);
	}
	//整理分类
	$cids = array();
	$category_name = explode(',', str_replace('，', ',', $v[1]));
	foreach ($category_name as $cname) {
		if (!$cname) continue;
		$cname = addslashes($cname);
		if ($cate = db::get_one('wb_news_category', "Name_cn='{$cname}'", 'Id')) {
			$cids[] = $cate['Id'];
		}
		else {
			db::insert('wb_news_category', array(
				'Name_cn' => $cname
			));
			$cids[] = db::get_insert_id(); 
		}
	}
	// 数据过滤
	$v = str::code($v, 'addslashes');
	//数据保存
	$d = array(
		'Name_cn'		=>	$v[0],
		'CateId'		=>	implode(',', $cids),
		'AddTime'		=>	$v[2] ? strtotime($v[2]) : c('time'),
		'Brief_cn'		=>	$v[3],
		// 'PicPath'		=>	str::json(@explode(',', str_replace('，', ',', $v[4]))),
		'EditTime'		=>	c('time')
	);
	// 重复项
	if ($one = db::get_one('wb_news',"Name_cn='{$d['Name_cn']}'", 'Id')){
		$Id = $one['Id'];
		$repeat_name[] ="行数:{$k} -> {$d['Name_cn']}";
		// db::update('wb_news', "Id=$Id", $d);
	}
	// 添加
	else {
		db::insert('wb_news', $d);
		$Id=db::get_insert_id();
	}
}
file::unlink($data['file']);
log::manage('news/excel_upload', '批量导入数据');
str::msg(array(
	'txt'		=> '批量上传完成',
	'progress'  => '100%',
	'repeat'	=> $repeat_name,
), 1);

?>