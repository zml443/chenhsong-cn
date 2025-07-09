<?php
// 导入站点配置文件
$cur_dir = dirname(__FILE__);
include substr($cur_dir, 0, -15).'/inc/global.php';
c('jext.php', $cur_dir . '/');
c('$.path', $cur_dir . '/../');