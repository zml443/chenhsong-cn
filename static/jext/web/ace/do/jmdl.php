<?php


$jmdl = new \jmdl\config(array());

// 操作权限
// 
// 读
// 特殊账号有读代码的权限
$__READ = $jmdl->special;

// 写
// 特殊账号有写代码的权限
$__SAVE = $jmdl->special;


// 后缀，写判断语句
$__FILE = 1;