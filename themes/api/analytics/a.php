<?php
function_exists('c')||exit;

// ul   当前链接
// lk   当前链接，相对链接
// ru   来源链接
// rr   来源平台
// rd   来源域名
// br   浏览器
// im   判断移动端设备
// ct   设备类型

// 不合规数据截断
if(!$_GET['ul'] || !isset($_GET['im']) || !$_GET['br'] || !$_GET['ct']){
	exit;
}
if (!preg_match('/^(https?:)\\/\\//', $_GET['ul'])) {
	exit;
}
if ($_GET['lk'][0]!='/' || !strstr($_GET['ul'], $_GET['lk'])) {
	exit;
}
// 判断来源域名是否为空
if (!strstr($_GET['rd'],'.') || !$_GET['rd']) {
	$_GET['rd'] = '';
	$_GET['ru'] = '';
}
if ($_GET['ru'] && !preg_match('/^(https?:)\\/\\//', $_GET['ru'])) {
	exit;
}


// 浏览器
$browser = array(
	'unknown' => '未知',
	'IE' => 'IE',
	'firefox' => '火狐',
	'UC' => 'UC',
	'opera' => '欧朋(opera)',
	'baidu' => '百度',
	'sogou' => '搜狗',
	'QQ' => 'QQ',
	'WeChat' => '微信',
	'maxthon' => '遨游',
	'360' => '360',
	'chrome' => 'chrome',
	'Safari' => 'Safari',
);
// 设备
$client = array(
	'Android' => 'Android',
	'iPhone' => 'iPhone',
	'iPad' => 'iPad',
	'other' => '其他',
	'PC' => 'PC',
);
// 来源
$referrer = array(
	'baidu' => '百度',
	'shenma' => '神马搜索',
	'360' => '360搜索',
	'sogou' => '搜狗',
	'Google' => 'Google',
	'quark' => '夸克搜索',
	'toutiao' => '头条',
	'direct' => '直接访问',
	'indirect' => '外部链接',
);
if(!$browser[$_GET['br']] || !$client[$_GET['ct']] || !$referrer[$_GET['rr']]){
	exit;
}else{
	$_GET['br'] = $browser[$_GET['br']];
	$_GET['ct'] = $client[$_GET['ct']];
	$_GET['rr'] = $referrer[$_GET['rr']];
}



// 获取ip以及地区
$ipdata = ip::info();
$hour_time = strtotime(date("Y-m-d H:00:00",c('time')));
$day_time = strtotime(date("Y-m-d",c('time')));
$month_time = strtotime(date("Y-m",c('time')));



// cookie记录
if (isset($_COOKIE['analytics_username'])) {
	$analytics_username = $_COOKIE['analytics_username'];
	if (!strstr($analytics_username,$ipdata['ip'])) {
		$analytics_username = $ipdata['ip'].'+'.str::rand(8);
		setcookie("analytics_username", $analytics_username, strtotime('tomorrow'), "/");
	}
} else {
	$analytics_username = $ipdata['ip'].'+'.str::rand(8);
	setcookie("analytics_username", $analytics_username, strtotime('tomorrow'), "/");
}





// UV录入
	$hour_uv = db::result("select * from analytics_uv where Username='$analytics_username' and Type='hour' order by `Time` desc limit 1");
	$day_uv = db::result("select * from analytics_uv where Username='$analytics_username' and Type='day' order by `Time` desc limit 1");
	$insert_uv_data = array(
		'Username' 	=>	$analytics_username,
		'Pv' 		=>	1,
	);
	$is_new_hour_uv = 1;
	$is_new_day_uv = 1;

	if ($hour_uv && $hour_uv['Time']==$hour_time) {
		$is_new_hour_uv = 0;
		db::update('analytics_uv', "Id='{$hour_uv['Id']}'", array(
			'Pv' => $hour_uv['Pv']+1,
		));
	} else {
		$insert_uv_data['Time'] = $hour_time;
		$insert_uv_data['Type'] = 'hour';
		db::insert('analytics_uv', $insert_uv_data);
	}

	if ($day_uv && $day_uv['Time']==$day_time) {
		$is_new_day_uv = 0;
		db::update('analytics_uv', "Id='{$day_uv['Id']}'", array(
			'Pv' => $day_uv['Pv']+1,
		));
	} else {
		$insert_uv_data['Time'] = $day_time;
		$insert_uv_data['Type'] = 'day';
		db::insert('analytics_uv', $insert_uv_data);
	}
// UV 录入结束





// IP录入
	$hour_ip = db::result("select * from analytics_ip where Ip='{$ipdata['ip']}' and Type='hour' order by `Time` desc limit 1");
	$day_ip = db::result("select * from analytics_ip where Ip='{$ipdata['ip']}' and Type='day' order by `Time` desc limit 1");
	$insert_ip_data = array(
		'Ip' 		=>	$ipdata['ip'],
		'Uv' 		=>	1,
		'Pv' 		=>	1,
	);
	$is_new_hour_ip = 1;
	$is_new_day_ip = 1;
	if ($hour_ip && $hour_ip['Time']==$hour_time) {
		$is_new_hour_ip = 0;
		db::update('analytics_ip', "Id='{$hour_ip['Id']}'", array(
			'Uv' => $hour_ip['Uv']+$is_new_hour_ip,
			'Pv' => $hour_ip['Pv']+1,
		));
	} else {
		$insert_ip_data['Time'] = $hour_time;
		$insert_ip_data['Type'] = 'hour';
		db::insert('analytics_ip', $insert_ip_data);
	}
	if ($day_ip && $day_ip['Time']==$day_time) {
		$is_new_day_ip = 0;
		db::update('analytics_ip', "Id='{$day_ip['Id']}'", array(
			'Uv' => $day_ip['Uv']+$is_new_day_ip,
			'Pv' => $day_ip['Pv']+1,
		));
	} else {
		$insert_ip_data['Time'] = $day_time;
		$insert_ip_data['Type'] = 'day';
		db::insert('analytics_ip', $insert_ip_data);
	}
// ip 查询结束






// 浏览器类型录入 browser
	$hour_browser = db::result("select * from analytics_browser where Title='{$_GET['br']}' and Type='hour' order by `Time` desc limit 1");
	$day_browser = db::result("select * from analytics_browser where Title='{$_GET['br']}' and Type='day' order by `Time` desc limit 1");
	$insert_browser_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Title' 	=>	$_GET['br']
	);

	if ($hour_browser && $hour_browser['Time']==$hour_time) {
		db::update('analytics_browser', "Id='{$hour_browser['Id']}'", array(
			'Uv' => $hour_browser['Uv']+$is_new_hour_uv,
			'Ip' => $hour_browser['Ip']+$is_new_hour_ip,
			'Pv' => $hour_browser['Pv']+1,
		));
	} else {
		$insert_browser_data['Time'] = $hour_time;
		$insert_browser_data['Type'] = 'hour';
		db::insert('analytics_browser', $insert_browser_data);
	}

	if ($day_browser && $day_browser['Time']==$day_time) {
		db::update('analytics_browser', "Id='{$day_browser['Id']}'", array(
			'Uv' => $day_browser['Uv']+$is_new_hour_uv,
			'Ip' => $day_browser['Ip']+$is_new_hour_ip,
			'Pv' => $day_browser['Pv']+1,
		));
	} else {
		$insert_browser_data['Time'] = $day_time;
		$insert_browser_data['Type'] = 'day';
		db::insert('analytics_browser', $insert_browser_data);
	}
// 浏览器类型 查询结束





// 点击量 录入 click
	$hour_click = db::result("select * from analytics_click where Type='hour' order by `Time` desc limit 1");
	$day_click = db::result("select * from analytics_click where Type='day' order by `Time` desc limit 1");
	$month_click = db::result("select * from analytics_click where Type='month' order by `Time` desc limit 1");
	$insert_click_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
	);

	if ($hour_click && $hour_click['Time']==$hour_time) {
		db::update('analytics_click', "Id='{$hour_click['Id']}'", array(
			'Uv' => $hour_click['Uv']+$is_new_hour_uv,
			'Ip' => $hour_click['Ip']+$is_new_hour_ip,
			'Pv' => $hour_click['Pv']+1,
		));
	} else {
		$insert_click_data['Time'] = $hour_time;
		$insert_click_data['Type'] = 'hour';
		db::insert('analytics_click', $insert_click_data);
	}

	if ($day_click && $day_click['Time']==$day_time) {
		db::update('analytics_click', "Id='{$day_click['Id']}'", array(
			'Uv' => $day_click['Uv']+$is_new_hour_uv,
			'Ip' => $day_click['Ip']+$is_new_hour_ip,
			'Pv' => $day_click['Pv']+1,
		));
	} else {
		$insert_click_data['Time'] = $day_time;
		$insert_click_data['Type'] = 'day';
		db::insert('analytics_click', $insert_click_data);
	}

	// 判断是否是当前月
	if ($month_click && $month_click['Time']==$month_time) {
		db::update('analytics_click', "Id='{$month_click['Id']}'", array(
			'Uv' => $month_click['Uv']+$is_new_hour_uv,
			'Ip' => $month_click['Ip']+$is_new_hour_ip,
			'Pv' => $month_click['Pv']+1,
		));
	} else {
		$insert_click_data['Time'] = $month_time;
		$insert_click_data['Type'] = 'month';
		db::insert('analytics_click', $insert_click_data);
	}
// 点击量 查询结束





// 设备类型 录入 client
	$hour_client = db::result("select * from analytics_client where Title='{$_GET['ct']}' and Type='hour' order by `Time` desc limit 1");
	$day_client = db::result("select * from analytics_client where Title='{$_GET['ct']}' and Type='day' order by `Time` desc limit 1");
	$insert_client_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Title' 	=>	$_GET['ct']
	);
	if ($hour_client && $hour_client['Time']==$hour_time) {
		db::update('analytics_client', "Id='{$hour_client['Id']}'", array(
			'Uv' => $hour_client['Uv']+$is_new_hour_uv,
			'Ip' => $hour_client['Ip']+$is_new_hour_ip,
			'Pv' => $hour_client['Pv']+1,
		));
	} else {
		$insert_client_data['Time'] = $hour_time;
		$insert_client_data['Type'] = 'hour';
		db::insert('analytics_client', $insert_client_data);
	}

	if ($day_client && $day_client['Time']==$day_time) {
		db::update('analytics_client', "Id='{$day_client['Id']}'", array(
			'Uv' => $day_client['Uv']+$is_new_hour_uv,
			'Ip' => $day_client['Ip']+$is_new_hour_ip,
			'Pv' => $day_client['Pv']+1,
		));
	} else {
		$insert_client_data['Time'] = $day_time;
		$insert_client_data['Type'] = 'day';
		db::insert('analytics_client', $insert_client_data);
	}
// 设备类型 查询结束




// ispc设备 录入 pc_mobile
	$hour_pc_mobile = db::result("select * from analytics_pc_mobile where Title='{$_GET['im']}' and Type='hour' order by `Time` desc limit 1");
	$day_pc_mobile = db::result("select * from analytics_pc_mobile where Title='{$_GET['im']}' and Type='day' order by `Time` desc limit 1");
	$insert_pc_mobile_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Title' 	=>	$_GET['im']?'mobile':'pc'
	);

	if ($hour_pc_mobile && $hour_pc_mobile['Time']==$hour_time) {
		db::update('analytics_pc_mobile', "Id='{$hour_pc_mobile['Id']}'", array(
			'Uv' => $hour_pc_mobile['Uv']+$is_new_hour_uv,
			'Ip' => $hour_pc_mobile['Ip']+$is_new_hour_ip,
			'Pv' => $hour_pc_mobile['Pv']+1,
		));
	} else {
		$insert_pc_mobile_data['Time'] = $hour_time;
		$insert_pc_mobile_data['Type'] = 'hour';
		db::insert('analytics_pc_mobile', $insert_pc_mobile_data);
	}

	if ($day_pc_mobile && $day_pc_mobile['Time']==$day_time) {
		db::update('analytics_pc_mobile', "Id='{$day_pc_mobile['Id']}'", array(
			'Uv' => $day_pc_mobile['Uv']+$is_new_hour_uv,
			'Ip' => $day_pc_mobile['Ip']+$is_new_hour_ip,
			'Pv' => $day_pc_mobile['Pv']+1,
		));
	} else {
		$insert_pc_mobile_data['Time'] = $day_time;
		$insert_pc_mobile_data['Type'] = 'day';
		db::insert('analytics_pc_mobile', $insert_pc_mobile_data);
	}
// ispc设备 查询结束







// 地区 录入
	$country = $ipdata['country'];
	$province = $ipdata['province'];
	$city = $ipdata['city'];
	$area = $ipdata['area'];
// country
	$hour_country = db::result("select * from analytics_country where Title='{$country}' and Type='hour' order by `Time` desc limit 1");
	$day_country = db::result("select * from analytics_country where Title='{$country}' and Type='day' order by `Time` desc limit 1");
	$insert_country_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Title' 	=>	$country
	);

	if ($hour_country && $hour_country['Time']==$hour_time) {
		db::update('analytics_country', "Id='{$hour_country['Id']}'", array(
			'Uv' => $hour_country['Uv']+$is_new_hour_uv,
			'Ip' => $hour_country['Ip']+$is_new_hour_ip,
			'Pv' => $hour_country['Pv']+1,
		));
	} else {
		$insert_country_data['Time'] = $hour_time;
		$insert_country_data['Type'] = 'hour';
		db::insert('analytics_country', $insert_country_data);
	}

	if ($day_country && $day_country['Time']==$day_time) {
		db::update('analytics_country', "Id='{$day_country['Id']}'", array(
			'Uv' => $day_country['Uv']+$is_new_hour_uv,
			'Ip' => $day_country['Ip']+$is_new_hour_ip,
			'Pv' => $day_country['Pv']+1,
		));
	} else {
		$insert_country_data['Time'] = $day_time;
		$insert_country_data['Type'] = 'day';
		db::insert('analytics_country', $insert_country_data);
	}

if ($ipdata['country'] == '中国') {
// province
	$hour_province = db::result("select * from analytics_province where Title='{$province}' and Type='hour' order by `Time` desc limit 1");
	$day_province = db::result("select * from analytics_province where Title='{$province}' and Type='day' order by `Time` desc limit 1");
	$insert_province_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Country' 	=>	$country,
		'Title' 	=>	$province
	);

	if ($hour_province && $hour_province['Time']==$hour_time) {
		db::update('analytics_province', "Id='{$hour_province['Id']}'", array(
			'Uv' => $hour_province['Uv']+$is_new_hour_uv,
			'Ip' => $hour_province['Ip']+$is_new_hour_ip,
			'Pv' => $hour_province['Pv']+1,
		));
	} else {
		$insert_province_data['Time'] = $hour_time;
		$insert_province_data['Type'] = 'hour';
		db::insert('analytics_province', $insert_province_data);
	}

	if ($day_province && $day_province['Time']==$day_time) {
		db::update('analytics_province', "Id='{$day_province['Id']}'", array(
			'Uv' => $day_province['Uv']+$is_new_hour_uv,
			'Ip' => $day_province['Ip']+$is_new_hour_ip,
			'Pv' => $day_province['Pv']+1,
		));
	} else {
		$insert_province_data['Time'] = $day_time;
		$insert_province_data['Type'] = 'day';
		db::insert('analytics_province', $insert_province_data);
	}
}
// 地区 查询结束






// 来源 录入 referrer
	$hour_referrer = db::result("select * from analytics_referrer where Domain='{$_GET['rd']}' and Type='hour' order by `Time` desc limit 1");
	$day_referrer = db::result("select * from analytics_referrer where Domain='{$_GET['rd']}' and Type='day' order by `Time` desc limit 1");
	$insert_referrer_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Title' 	=>	$_GET['rr'],
		'Domain' 	=>	$_GET['rd'],
		'ReferrerUrl' 	=>	$_GET['ru']
	);

	if ($hour_referrer && $hour_referrer['Time']==$hour_time) {
		db::update('analytics_referrer', "Id='{$hour_referrer['Id']}'", array(
			'Uv' => $hour_referrer['Uv']+$is_new_hour_uv,
			'Ip' => $hour_referrer['Ip']+$is_new_hour_ip,
			'Pv' => $hour_referrer['Pv']+1,
		));
	} else {
		$insert_referrer_data['Time'] = $hour_time;
		$insert_referrer_data['Type'] = 'hour';
		db::insert('analytics_referrer', $insert_referrer_data);
	}

	if ($day_referrer && $day_referrer['Time']==$day_time) {
		db::update('analytics_referrer', "Id='{$day_referrer['Id']}'", array(
			'Uv' => $day_referrer['Uv']+$is_new_hour_uv,
			'Ip' => $day_referrer['Ip']+$is_new_hour_ip,
			'Pv' => $day_referrer['Pv']+1,
		));
	} else {
		$insert_referrer_data['Time'] = $day_time;
		$insert_referrer_data['Type'] = 'day';
		db::insert('analytics_referrer', $insert_referrer_data);
	}
// 来源 查询结束






// url_click 录入
	$hour_url_click = db::result("select * from analytics_url_click where Link='{$_GET['lk']}' and Type='hour' order by `Time` desc limit 1");
	$day_url_click = db::result("select * from analytics_url_click where Link='{$_GET['lk']}' and Type='day' order by `Time` desc limit 1");
	$insert_url_click_data = array(
		'Ip' 		=>	1,
		'Uv' 		=>	1,
		'Pv' 		=>	1,
		'Title' 	=>	$_GET['ul'],
		'Link' 		=>	$_GET['lk']
	);

	if ($hour_url_click && $hour_url_click['Time']==$hour_time) {
		db::update('analytics_url_click', "Id='{$hour_url_click['Id']}'", array(
			'Uv' => $hour_url_click['Uv']+$is_new_hour_uv,
			'Ip' => $hour_url_click['Ip']+$is_new_hour_ip,
			'Pv' => $hour_url_click['Pv']+1,
		));
	} else {
		$insert_url_click_data['Time'] = $hour_time;
		$insert_url_click_data['Type'] = 'hour';
		db::insert('analytics_url_click', $insert_url_click_data);
	}

	if ($day_url_click && $day_url_click['Time']==$day_time) {
		db::update('analytics_url_click', "Id='{$day_url_click['Id']}'", array(
			'Uv' => $day_url_click['Uv']+$is_new_hour_uv,
			'Ip' => $day_url_click['Ip']+$is_new_hour_ip,
			'Pv' => $day_url_click['Pv']+1,
		));
	} else {
		$insert_url_click_data['Time'] = $day_time;
		$insert_url_click_data['Type'] = 'day';
		db::insert('analytics_url_click', $insert_url_click_data);
	}
// url_click 查询结束



$before_delete_month = $day_time-2592000;
db::delete("analytics_uv","Time < $before_delete_month");
db::delete("analytics_ip","Time < $before_delete_month");
db::delete("analytics_url_click","Time < $before_delete_month");

exit;