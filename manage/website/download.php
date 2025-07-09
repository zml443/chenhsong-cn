<?php
// 不能直接访问
function_exists('c') || exit;

$res = db::query("select * from wb_site_page_module_copy");
if(!$res) return;


// 临时目录
$tempath = c('root').'file/_tmp/module/'.c('HostName');
if(is_dir($tempath)) file::mkdir($tempath);

while($v = db::result($res)){
    $source = c('root').'module/'.$v['Number'];
    $new = $tempath.'/'.$v['Number'];
    // 1、复制
    file::copydir($source,$new);
}

// 2、压缩(不替换固定字符No000)
$zipName = file::zip($tempath);
$reName = $tempath.'.zip';
// 重命名压缩包
rename(c('root').substr($zipName,1),$reName);



// // 替换固定字符No000
// mixName($tempath);

// // 再压缩
// $zipNameMix = file::zip($tempath);
// $reNameMix = $tempath.'Mix.zip';
// d($reNameMix);
// // 重命名压缩包
// rename(c('root').substr($zipNameMix,1),$reNameMix);



// 3、删除临时文件
file::rmdir($tempath);




// 4、跳转(下载)
$href = '/file/_tmp/module/'.c('HostName').'.zip';
header("Location: ".$href."");
exit;




// 处理No000字符
function mixName($path='',$rel='',$url=''){
    if(!is_dir($path)){
        return array();
    }
    $hand = dir($path);
    while ($f = $hand->read()){
        if ($f == "." || $f == "..") continue;
        $filename = $path.'/'.$f;
        if (is_dir($filename)) {
            // 如果是文件夹，则递归调用自身
            mixName($filename,$rel?$rel.'_'.$f:$f,$url?$url.'/'.$f:$f);
        } else {
            if (preg_match('/^(index.js|index.css|index.php)$/',$f)) {
                $aaa = $rel;
                $xxx = $url;
                $source = file_get_contents($filename);
                $new = str_replace(array('No000','Path000'),array($aaa,$xxx),$source);
                file_put_contents($filename,$new);
            }
        }
    }
}
// mixName($tempath);