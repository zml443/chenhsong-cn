<?php

$dir = dirname(__FILE__).'/.data/';
$data = str::json(file_get_contents($dir.'var'), 'decode');


function download(&$arr){
	if (is_array($arr) && !$arr['download']) {
		$res = curl::api('http://open.ooofoo.com/gateway/module.php', 'mVRNMuftzxs0s0Ff', array(
			'ApiName' => 'download',
			'Number' => $arr['name'],
			'type' => $arr['type']?:'Zip'
		));
		$arr['download'] = 1;
		if ($res) {
			$zip = '/file/_obj_/'.$arr['name'].'.zip';
			file::write($zip, $res);
			file::unzip($zip);
			file::unlink($zip);
		}
		return 1;
	} else {
		return 0;
	}
}

$is_download = 0;
$data_download_number = array(0,0);

// 下载头部
if ($data['header'] && !$data['header']['download']) {
	download($data['header']);
	$is_download = 1;
}
$data_download_number[0]++;
$data_download_number[1]++;
// 下载内容区
if ($data['content']) {
	foreach ($data['content'] as $k => $v) {
		$data_download_number[0] += count($v);
		if (!$is_download) foreach ($v as $k1 => $v1) {
			$data_download_number[1]++;
			if (!$v1['download']) {
				download($data['content'][$k][$k1]);
				$is_download = 1;
				break;
			}
		}
		if ($is_download) {
			break;
		}
	}
}
// 下载底部
if (!$is_download && $data['footer'] && !$data['footer']['download']) {
	download($data['footer']);
	$is_download = 1;
	$data_download_number[1]++;
}
$data_download_number[0]++;

file_put_contents($dir.'var', str::json($data));

if ($is_download) {
	exit(str::json(array(
		'msg' => '',
		'progress' => (int)($data_download_number[1] / $data_download_number[0] * 100),
		'ret' => -1
	)));
	// str::msg('', -1);
}

str::msg('', 1);