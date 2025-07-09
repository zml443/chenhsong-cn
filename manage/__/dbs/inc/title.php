<?php
$arr_u = @explode(',', $_GET['u']);
if (count($arr_u)>2) {
	$app_info = language('menu.'.$arr_u[0].'.'.$arr_u[1]);
} else {
	$app_info = language('menu.'.$arr_u[0]);
}

?>
<div class="zml_title flex-middle2 <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
	<span class="name"><?=$app_info['module_name']?></span>
</div>