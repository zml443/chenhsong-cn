<?php
$page_entity = wb_site_page::get_page();
$id = $_POST['id'];
$jump_foreach = 0;
$page_current = array();
foreach ($page_entity as $k => $v) {
	if ($v['type']=='index') {
		$page_current = $v;
	}
	if ($v['children']) {
		foreach ($v['children'] as $k1 => $v1) {
			if ($id && ($v1['type']==$id || $v1['id']==$id)) {
				$page_current = $v1;
				$jump_foreach = 1;
				break;
			}
		}
	} else if ($id && ($v['type']==$id || $v['id']==$id)) {
		$page_current = $v;
		break;
	}
	if ($jump_foreach) break;
}
$page_url = wb_site_page::url();
$module_type_res = lydb::query("select * from module_type");
$module_type = array();
while ($v = lydb::result($module_type_res)) {
	$module_type[$v['Name']] = array(
		'name' => $v['Title']
	);
}

// 网站状态
$web = db::result("select * from wb_site_web where Used=1 limit 1");
if ($web['Release']) {
	if (g('website.update_time')==$web['EditTime']) {
		$use_status = 'used'; //使用中
	} else {
		$use_status = 'update'; //更新中
	}
} else {
	$use_status = 'un_used'; //未使用
}

// 语言版本
$language = array();
foreach (c('language') as $k => $v) {
	$language[$v] = language('{/language.'.$v.'/}');
}

exit(str::json(array(
	'id' => $web['Id'],
	'use_status' => $use_status,
	'language' => $language,
	'current_lang' => c('lang'),
	'current_language' => language('{/language.'.c('lang').'/}'),
	'css' => array(
		'mainColor' => g('website.mainColor'),
	),
	'page_entity' => $page_entity,
	'page_url' => $page_url,
	'allUrl_service' => wb_service::url(),
	'page_current' => $page_current,
	'module_type' => $module_type,
)));
?>