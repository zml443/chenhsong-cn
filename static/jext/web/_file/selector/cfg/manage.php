<?php


// 操作权限
$__PERMISSION = (int)manage('Id') || (int)$_SESSION['Jmdl']['Id'];



// 查询列表的条件
$__WHERE = "`GroupId`='manage'";



/*
 * 添加文件夹
 * 指定某些字段的录入
 * 
 */
$__ADDDIR = array(
	'ExtId'	=>	(int)manage('Id')
);