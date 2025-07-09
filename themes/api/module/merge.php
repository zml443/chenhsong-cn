<?php

$dir = dirname(__FILE__).'/.data/';
$data = str::json(file_get_contents($dir.'var'), 'decode');

$default_dir = '/themes/default/';

$js = '';
$css = '';
$xxx_html = file_get_contents($dir.'../xxx.php');

function get_code($v, &$_js_cont, &$_css_cont){
	$module = '/file/_obj_/'.$v['name'].'/';
	$Path000 = $module;
	$mdljs = c('root').$module.'index.js';
	$mdldbs = c('root').$module.'dbs/';
	$mdlcss = c('root').$module.'index.css';
	$mdlhtml = c('root').$module.'index.php';
	// 
	if (is_file($mdljs)) {
		if (!strstr($_js_cont, "* {$v['name']} *")) {
			$_js_cont .= "/* {$v['name']} */\r\n".file_get_contents($mdljs)."\r\n\r\n\r\n\r\n";
		}
	}
	// 
	if (is_file($mdlcss)) {
		if (!strstr($_css_cont, "* {$v['name']} *")) {
			$_css_cont .= "/* {$v['name']} */\r\n".file_get_contents($mdlcss)."\r\n\r\n\r\n\r\n";
		}
	}
	// 
    $data_dir=@dir($mdldbs);
    if ($data_dir) {
        while ($son_dir=$data_dir->read()) {
            if ($son_dir=='.' || $son_dir=='..' || is_file($mdldbs.$son_dir)) {
                continue;
            }
            $file_dir=@dir($mdldbs.$son_dir.'/');
            while ($sson_file=$file_dir->read()) {
                if($sson_file!='.' && $sson_file!='..'){
                	file::write_php('/manage/'.$son_dir.'/'.$sson_file, file_get_contents($mdldbs.$son_dir.'/'.$sson_file));
                }
            }
        }
    }
    // 
	if (is_file($mdlhtml)) {
		$_html_cont = "\r\n<!-- 开始 -->\r\n".file_get_contents($mdlhtml)."\r\n<!-- 结束 -->\r\n\r\n\r\n";
	} else {
		$_html_cont = '';
	}
	$_js_cont = str_replace(array('No000', 'Path000'), array($v['name'],$Path000), $_js_cont);
	$_css_cont = str_replace(array('No000', 'Path000'), array($v['name'],$Path000), $_css_cont);
	$_html_cont = str_replace(array('No000', 'Path000', 'file::filter_root(dirname(__FILE__))'), array($v['name'], $Path000, "'{$module}'"), $_html_cont);
	return $_html_cont;
}



// 下载头部
if ($data['header'] && $data['header']['download']) {
	$html = get_code($data['header'], $js, $css);
	if ($html) {
		file::write_php($default_dir.'inc/header.php', $html);
	}
}
// 下载内容区
if ($data['content']) {
	foreach ($data['content'] as $k => $v) {
		$html = '';
		foreach ($v as $k1 => $v1) {
			if ($v1['download']) {
				$html .= get_code($v1, $js, $css)."\r\n\r\n";
			}
		}
		if ($html) {
			$html = str_replace("\r\n", "\r\n\t", $html);
			$html = str_replace(array('{{(page_name)}}', '{{(content_html)}}'), array($k, $html), $xxx_html);
			file::write_php($default_dir.$k.'.php', $html);
		}
	}
}
// 下载底部
if ($data['footer'] && $data['footer']['download']) {
	$html = get_code($data['footer'], $js, $css);
	if ($html) {
		file::write_php($default_dir.'inc/footer.php', $html);
	}
}

file::write_php($default_dir.'css/style.css', $css);
file::write_php($default_dir.'js/web.js', $js);

str::msg('', 1);