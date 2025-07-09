<?php


/*
 * 操作权限
 *
**/
// 读
// $__READ = (int)$_SESSION['Jext']['Id'] || (int)$_SESSION['Manage']['Id'];
$__READ = 1;
// 写
$__SAVE = 0;


/*
 * 后缀
 *
**/
$__FILE = preg_match('/\.(tpl|txt|js|css)$/', $file);