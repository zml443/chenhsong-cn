<?php
// 当前用户的权限
if (!p('app.app_store.edit')) {
    return;
}
if (c('HostTag')=='shop') {
	$app_store_ary = include c('root').'manage/__/app-shop.php';
} else {
	$app_store_ary = include c('root').'manage/__/app-web.php';
}

?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<div class="zml_app_store_header">
		<div class="text-center fz36 pt_60px pb_60px" color="white"><?=language('{/menu.app.app_store.module_name/}')?></div>
	</div>

	<div class="mt_50px mb_50px" cw="1300">
		<?php
		$i=-1;
		foreach ($app_store_ary as $k => $v) {
			if ($k=='_') {
				continue;
			}
			$i++;
		?>
			<div class="fz30 <?=$i?'mt_30px':''?>"><?=language('dbs.app.'.$k)?></div>
			<div class="flex-wrap mt_35px">
				<?php
					foreach ($v as $k1 => $v1) {
						$item = language('menu.'.($v1['language']?:$v1['key']));
						$url = c('manage.permit.allurl.'.$v1['key'].'._');
				?>
					<div class="zml_app_store" bg="white">
						<div class="img i-pic"><img src="<?=$item['module_pic']?>" alt=""></div>
						<div class="name"><?=$item['module_name']?></div>
						<div class="brief"><?=$item['module_brief']?></div>
						<div class="childrenLi">
							<?php
								foreach ((array)$v1['children'] as $k2 => $v2) { 
									$item2 = language('menu.'.($v2['language']?:$v2['key']));
							?>
								<div class="flex-middle2 mt_15px">
									<label class="ly_switchery mr_10px" size="small">
										<input type="checkbox"  onclick="app_store_fn.save(this)" data-key="<?=$k2?>" data-val="<?=a($k2)?'0':'1'?>" <?=a($k2)?'checked':''?> />
									</label>
									<span><?=$item2['module_name']?></span>
								</div>
							<?php } ?>
						</div>
						<div class="flex-middle2 mt_35px">
							<?php if (a($k1)) { ?>
								<a class="ly_btn_radius width80 <?=$v1['close']?'disabled':''?>" border="main" size="small" hr-ef="<?=$url?>"><?=language('{/global.installed/}')?></a>
								<div class="ml_20px pointer" color="text3" onclick="app_store_fn.save(this)" data-key="<?=$k1?>" data-val="0"><?=language('{/global.cancel/}')?></div>
							<?php } else { ?>
								<div class="ly_btn_radius width80 <?=$v1['close']?'disabled':'pointer'?>" onclick="app_store_fn.save(this)" bg="main" size="small" data-key="<?=$k1?>" data-val="1">
									<?=language('{/global.install/}')?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<script>
		var app_store_fn = {
			data: {},
			url() {
				$.async('POST', '?ma=app/app_store/_url', this.data, result=>{
					if (result.url) {
						WP.location.href = result.url
						// WP.manage.src(result.url)
					} else {
						location.reload()
					}
				}, 'json');
			},
			save(el) {
				var el = $(el)
				this.data = {
					key: el.attr('data-key'),
					val: el.attr('data-val')
				}
				// this.data = data
				$.async('POST', '?ma=app/app_store/_save', this.data, result=>{
					if (result.ret==1) {
						this.url()
					} else {
						$.alert(result.msg, 2000)
					}
				}, 'json')
			}
		};
	</script>

</body>
</html>