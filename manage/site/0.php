<?php
// 当前用户的权限
// if (!p($_GET['ma'].'.edit')) {
//     echo language('notes.no_permit');
//     return;
// }
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>
<body bg="default">

	<div id='guide' cw="1000">
		<div class='title'><?=language('menu.'.str_replace(',', '.', $_GET['u']).'.module_name')?></div>
		<ul class='item flex-wrap'>
			<?php
			$menu_u = @explode(',', $_GET['u']);
			$menu = p('manage.permit.allurl.'.$menu_u[0]);
			$menu_lang = implode('.', $menu_u);
			foreach ((array)$menu as $k => $v) {
				if ($k=='0' || $k=='_') {
					continue;
				}
				$ary = language('menu.'.$menu_u[0].'.'.$k);
				$ico = "/static/images/guide/{$menu_u[0]}/{$k}.svg";
				if (!is_file(c('root').$ico)) {
					$ico = "/static/images/guide/{$menu_u[0]}/0.svg";
				}
			?>
				<li class="trans" hr-ef='<?=$v['_']?>'>
					<div class='ico m-pic'><?=img::svg($ico);?></div>
					<div class='name'><?=$ary['module_name']?>　</div>
					<div class='brief'><?=$ary['module_brief']?>　</div>
				</li>
			<?php } ?>
		</ul>
	</div>


</body>
</html>