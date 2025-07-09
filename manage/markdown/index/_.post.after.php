<?php

if ($this->before_row['Files']!=$this->row['Files']) {
    if ($this->before_row['Files']) {
        $dir = str_replace('.zip','', $this->before_row['Files']);
        file::unlink($this->before_row['Files']);
        file::rmdir($dir);
    }
    // 
    if (is_file(c('root').$this->row['Files'])) {
        // 解压
        // file::iconv_zip($this->row['Files']);
        $zip = file::unzip_cn($this->row['Files']);
        // 过滤掉没用的文件,生成对应的文件树
        $arr = deleteFiles($zip, array(
            'type' => $this->row['Type']
        ));
        db::update($this->table, 'Id='.$this->row['Id'], array(
            'Data' => str::json($arr),
        ));
    }
}




// 删除文件夹中不符合要求的文件
function deleteFiles($path, $conf) {
    $dir = c('root').$path;
    if(!is_dir($dir)){
        return array();
    }
    // 文件夹
    $arr1 = array();
    // 文件
    $arr2 = array();
    $h = dir($dir); // 打开文件夹
    $md_preg = $conf['type']=='html' ? '/\\.(md|html|docx?|png|jpe?g)$/' : '/\\.(md|docx?|png|jpe?g)$/';
    $md_preg2 = $conf['type']=='html' ? '/\\.(md|html)$/' : '/\\.md$/';
    // 过滤掉无效文件
    while ($f = $h->read()) {
        if ($f != "." && $f != "..") {
            $filePath = $dir . "/" . $f;
            // 检查文件后缀名
            if (!preg_match($md_preg,$f)) {
                file::unlink($filePath); // 删除文件
            }
            // 将文件名解码
            $fileName = str_replace(array('.md','.html'), '', urldecode($f));
            // 防止url自动转码，无法访问到文件
            $fileName2 = str_replace('%', '', $f);
            // 重写文件名
            rename($filePath, $dir.'/'.$fileName2);
            if (is_dir($dir.'/'.$fileName2)) {
                // 如果是文件夹，则递归调用自身, 内容不为空时存入
                $fileCont = deleteFiles($path.'/'.$fileName2, $conf);
                if ($fileCont) $arr1[] = array(
                    'Name' => $fileName,
                    'Files' => $path.'/'.$fileName2,
                    'children' => $fileCont
                );
            } else {
                // 是md文件时存入
                if (preg_match($md_preg2,$f)) $arr2[] = array(
                    'Name' => $fileName,
                    'Files' => $path.'/'.$fileName2,
                );
            }
        }
    }
    // 合并数组，文件夹在前，文件在后
    $arr = array_merge($arr1, $arr2);
    return $arr;
}
