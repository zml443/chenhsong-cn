<?php
$cur_dir_path = dirname(__FILE__);
return array(
	'global' => include $cur_dir_path.'/global.php', // 全局
	'menu' => include $cur_dir_path.'/menu.php', // 菜单
	'language' => include $cur_dir_path.'/language.php',//语言
	'dbs' => include $cur_dir_path.'/dbs.php',//dbs插件统一语言包
	'notes' => include $cur_dir_path.'/notes.php',//提示
	'member' => include $cur_dir_path.'/member.php',//管理员/会员
	'panel' => include $cur_dir_path.'/panel.php', // 面板信息
	'form' => include $cur_dir_path.'/form.php', // 表单留言/联系信息
	'orders' => include $cur_dir_path.'/orders.php',//订单
	'page' => include $cur_dir_path.'/page.php',//页面&面包屑
	'front_end' => include $cur_dir_path.'/front_end.php',//前端类
);