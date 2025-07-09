<?php

//配置文件
include 'inc/global.php';

// 网站状态
use system\web as ww;
ww::jump302();
ww::close();






// ================================= 提前设置 开始 =================================

// 通过文件夹表示语言版本
/*$url = $_GET['weburl'] = '/'.ltrim($_GET['weburl']);
$lang = c('lang');
foreach ($lang as $v) {
	if (preg_match('#^/'.$v.'#', $url)) {
		$_GET['weburl'] = preg_replace('#^/'.$v.'#', '', $_GET['weburl']);
		$_SESSION['lang'] = $v;
		c('lang', $v);
		break;
	}
}*/



// 自定义链接
page_url::init();



// 伪静态
c('rewrite', array(
	// '^/pcate/?(.*)?$'	=>	'/products_category$1'
));




// ================================= 提前设置 结束 =================================

member('', wb_member::current());

if (member('Id')) {
	// wb_member_message::get_message();
}






// 网站入口
use system\index as ii;
ii::init();

// 关闭数据库
db::close();