<?php
$arr_u = @explode(',', $_GET['u']);
if (count($arr_u)>2) {
	$app_info = language('menu.'.implode('.', $arr_u));
} else {
	$app_info = language('menu.'.$arr_u[0]);
}

?>
<div class="flex-bottom <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?> hr-ef="back()">
	<div class="flex-middle2 mr_20px">
		<i class="lyicon-arrow-left-bold"></i>
		<span><?=language('{/global.back/}')?></span>
	</div>
	<span class="name fz20">
		<?php 
			$xname = '';
			$xlen = count($arr_u) - 2;
			foreach ($arr_u as $k => $v) {
				$xname .= '.'.$v;
				if ($xlen>$k) continue;
				echo ($xlen<$k?" / ":'').language('menu'.$xname.'.module_name');
			}
		?>
	</span>
</div>