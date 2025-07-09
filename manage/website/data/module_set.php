<?php
isset($c) || exit;

$data = $_POST['data'];

if (!$data || !is_array($data['parts'])) {
	str::msg('數據錯誤', 0);
}

$page_id = (int)$_POST['page_id'];
$one = db::get_one('wb_site_page_copy', "Id='{$page_id}'");
if (!$one['FileName']) {
	str::msg('页面不存在', 0);
}

$page_path = c('website.path').'page/'.$one['FileName'].'/';

$page_file = c('root').$page_path.'_.conf.php';

if (!is_file($page_file)) {
	str::msg('文件不存在',0);
}

$setting = include $page_file;

// 需要保存的字段
$fields = array('id', 'title', 'path', 'hide', 'children', 'hidden', 'display', 'lock');

// 記錄模塊id，用於判斷是否重複
$ids = array();

// 檢查整理模塊配置
foreach ($data['parts'] as $k0 => $v0) {
	if (!is_array($v0['module'])) {
		continue;
	}
	foreach ($v0['module'] as $k1 => $v1) {
		if (!is_file(c('module.dir').$v1['path'].'/index.php')) {
			str::msg('不存在模塊:'.$v1['path'], 0);
		}
		if (!$v1['id']) {
			str::msg('id錯誤:'.$v1['path'], 0);
		} else if (in_array($v1['id'], $ids)) {
			str::msg('id重複:'.$v1['id'], 0);
		} else {
			$ids[] = $v1['id'];
		}
		foreach ($v1 as $k2 => $v2) {
			if (!in_array($k2,$fields)) unset($v0['module'][$k1][$k2]);
		}
	}
	$setting['parts'][$k0]['module'] = $v0['module'];
}

file::write_php($page_file, "<?php\r\nreturn ".str::ary_dump($setting)."\r\n?>");

str::msg('保存成功', 1);
?>