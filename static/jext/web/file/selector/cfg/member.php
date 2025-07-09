<?php


/*
 * 操作权限
 *
**/
$__PERMISSION = member('Id');


/*
 * 查询列表
 *
**/
$__WHERE = "`GroupId`='member' and ExtId='".member('Id')."'";


/*
 * 添加文件夹
 * 指定某些字段的录入
 * 
**/
$__ADDDIR = array(
	'ExtId'	=>	member('Id')
);