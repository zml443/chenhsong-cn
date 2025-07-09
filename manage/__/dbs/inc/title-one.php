<?php
// $arr_u = @explode(',', $_GET['u']);
// if (count($arr_u)>2) {
// 	$app_info = language('menu.'.implode('.', $arr_u));
// } else {
// 	$app_info = language('menu.'.$arr_u[0]);
// }

?>
<div class="flex-bottom <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?> hr-ef="back()">
	<div class="flex-middle2 mr_20px">
		<i class="lyicon-arrow-left-bold"></i>
		<span><?=language('{/global.back/}')?></span>
	</div>
	<span class="name fz20"><?=permit::name();?></span>
</div>