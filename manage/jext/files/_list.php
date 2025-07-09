<?php

function_exists('c') || exit;

// 当前文件夹
$current_dir = db::result("select * from jext_files where Id='{$_POST['id']}'");
$current_dir || $current_dir = array('Id'=>0, 'UId'=>'');

// 整理查询条件
$where1 = '';
if ($current_dir) {
	$where1 .= " and UId='{$current_dir['UId']}{$current_dir['Id']},'";
} else {
	$where1 .= " and UId='0,'";
}
if ($_POST['name']) {
	$where1 .= " and Name like '%{$_POST['name']}%'";
}

switch ($_POST['ext']) {
	case 'img':
		$where1 .= " and Name REGEXP '\.(png|jpe?g|gif|ico|webp)'";
		break;
	case 'mp4':
		$where1 .= " and Name REGEXP '\.(mp4|avi|rmv?b?|mov|qt|asf|flv|mpe?g|dat)'";
		break;
	case 'doc':
		$where1 .= " and Name REGEXP '\.(docx?|xlsx?|pdf|ppt|webp)'";
		break;
	case 'mp3':
		$where1 .= " and Name REGEXP '\.(mp3)'";
		break;
	case 'other':
		$where1 .= " and Name REGEXP '\.?!(mp3|docx?|xlsx?|pdf|ppt|webp|mp4|avi|rmv?b?|mov|qt|asf|flv|mpe?g|dat|png|jpe?g|gif|ico|webp)'";
		break;
	default:
		break;
}

$where = "GroupId='manage'";

$dir = db::query("select * from jext_files where {$where} and Type=0 {$where1}");
$dir_row = array();
while ($v = db::result($dir)){
	$v['_count_'] = db::result("select count(*) as a from jext_files where $where and find_in_set({$v['Id']}, UId)", 'a'); 
	$dir_row[] = $v;
}

$list = db::query("select * from jext_files where {$where} and Type=1 {$where1} order by AddTime desc limit ".((int)$_POST['pg']*30).", 30");
$list_row = array();
while ($v=db::result($list)){
	$list_row[] = $v;
}

exit(str::json(array(
	'current_dir' => $current_dir,
	'dir' => $dir_row,
	'list' => array(
		'limit' => 30,
		'total' => 0,
		'children' => $list_row
	)
)));