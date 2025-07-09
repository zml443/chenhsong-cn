<?php
// 当前用户的权限
/*if (!p('app.0.edit')) {
    echo language('notes.no_permit');
    return;
}*/
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<div class="mb_50px" cw="1000">
		<div class="sticky" style="top:0; z-index:20;">
		    <div class="ly-h2 p_30_0px" bg="default"><?=language('menu.'.$_GET['U'][0].'.module_name')?></div>
		</div>
		<ul class="wcb_app_ul">
			<?php
			// d(c('manage.permit'));
			$menu = c('manage.permit.allurl.'.$_GET['U'][0]);
			foreach ((array)$menu as $k => $v) {
				if ($k=='0' || $k=='_' || $k=='__' || $k=='app_store') {
					continue;
				}
				$ary = language('menu.ad.'.$k);
			?>
				<li class="li trans flex-middle2" hr-ef='<?=$v['_']?>'>
					<!-- <div class="img i-pic"><img src="<?=$ary['module_pic']?>" alt=""></div> -->
					<div class="name flex-1"><?=$ary['module_name']?></div>
					<a class="into"><?=language('{/global.into/}')?></a>
				</li>
			<?php } ?>
		</ul>
	</div>

</body>
</html>