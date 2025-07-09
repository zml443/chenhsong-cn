<?php
/*
+-----------------------------------------------------
| 滑动验证
| by zinn
+-----------------------------------------------------

// 用法
$drag_code = (int)$_SESSION['VCode']['Drag'];
unset($_SESSION['VCode']['Drag']);
if ($drag_code == 0) {
	// 验证失败，返回失败信息
}
+-----------------------------------------------------
*/


include '../../../php/init.php';

$IP = ip::get();

$VTOKEN = $_POST['VTOKEN'];


/*if ($VTOKEN==vcode::cca() && $_SESSION['VCode']['IP']==ip::get()) {
	$_SESSION['VCode']['ID'] = $EX;
}*/

if ($_POST['ACT'] == 'TOKEN') {
	// 作用不大
	$_SESSION['drag_code_code'.$IP] = $_POST['CODE'] ^ vcode::cca();
	exit('Set JToken.'.$_SESSION['drag_code_code'.$IP]);
}
else {
	// id 是唯一能做验证的东西
	if ($_SESSION['drag_code_code'.$IP]==$_POST['TOKEN'] && $_SESSION['VCode']['IP']==$IP && $VTOKEN==vcode::cca()) {
		$_SESSION['VCode']['Drag'] = 1;
		str::msg('验证成功.'.$VTOKEN, 1);
	} else {
		$_SESSION['VCode']['Drag'] = 0;
		str::msg('验证失败.'.$VTOKEN, 0);
	}
}