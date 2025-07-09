<?php
/*
+-----------------------------------------------------
ID 识别

+-----------------------------------------------------

// 用法
$VCodeID = $_SESSION['VCode']['ID'];
unset($_SESSION['VCode']['ID']);
if (!$VCodeID || $VCodeID != $_POST['VCodeID']) {
	ly200::e_json('请重新提交，多次提交无效请联系管理员！', 0);
}
+-----------------------------------------------------
*/

include '../../../php/init.php';

$EX = 'ID' . rand(1000, 9999);

if (count($_SESSION['VCode'])>20) array_shift($_SESSION['VCode']);

if (vcode::token($_GET['token'])) {
	$_SESSION['VCode'][$_GET['name']] = $EX;
	echo $EX;
}
exit;