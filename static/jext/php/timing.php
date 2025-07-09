<?php

include 'init.php';

$_SESSION['VCode']['IP']=ip::get();
$_SESSION['VCode']['IP']||$_SESSION['VCode']['IP'] = '0.0.0';


// 返回数据
///////////////////////////////////////////////////////////////////////////
$return_data = array();
///////////////////////////////////////////////////////////////////////////


// 返回 系统时间 + session_id + ip
///////////////////////////////////////////////////////////////////////////
if ($_POST['number']<=1) {
	$return_data['session_id'] = session_id();
	$return_data['time'] = c('time');
	$return_data['ip'] = $_SESSION['VCode']['IP'];
} else {
	$return_data['time'] = c('time');
}
///////////////////////////////////////////////////////////////////////////



// 文件银行删除临时文件
///////////////////////////////////////////////////////////////////////////
// 5.3.1.22.11.3 加一个 log::manage() 记录
if ($_POST['number']==2) {
	$_POST['_temp_unlink_file'] = array();
	$time = c('time') - 1*86400;
	$where = "GroupId='default' and IsTmp=1 and AddTime<{$time}";
	$row = db::query("select * from jext_files where $where");
	while ($v = db::result($row)) {
		if (c('aliyun_oss.id') && strstr($v['Path'], '.aliyuncs.com')) {
			aliyun_oss::delete_file($v['Path']);
		} else {
			file::unlink($v['Path']);
		}
		$_POST['_temp_unlink_file'][] = $v;
	}
	db::query("delete from jext_files where $where");
	if ($_POST['_temp_unlink_file']) {
		log::manage('jext_files', '定时删除临时文件');
	}
	// 删除临时文件夹
	$path = c('root').c('tmp_dir').'upload/';
    $h = dir($path);
    while ($f = $h->read()) {
    	if ($f=='.' || $f=='..') continue;
    	if (is_dir($path.$f)) {
    		$t = strtotime($f);
    		if ($t<c('time')-2*86400) {
    			file::rmdir($path.$f, 1);
    		}
    	}
    }
}
///////////////////////////////////////////////////////////////////////////

$return_data['ret'] = 1;
echo str::json($return_data);
?>