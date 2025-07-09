<?php
// 智能工厂 模具与产品
// 防止胡乱进入
isset($c) || exit;

$navId = 'products';
$navTwoId = $navBanId = 'mold';
$seo = db::seo('mold');

$factory_mold = db::get_one('wb_factory_mold',"1",'*');
$factory_mold_data = str::json($factory_mold['Data'], 'decode');
$service_item_pic = str::json($factory_mold[ln('Picture')], 'decode');
$factory_mold_cases = str::json($factory_mold['Data2'], 'decode');

$factory_mold_process = str::json($factory_mold['Data3'], 'decode');
$service_process_pic = str::json($factory_mold[ln('Pictures')], 'decode');

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body class="mold_back">
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?//php include 'inc/menu.php'; ?>
	</div>	
	
	<?//团队介绍 ?>
	<section id="mold-team">
		<div class="cw1600 content">
			<div class="title" wow='fadeInUp'><?=nl2br($factory_mold[ln('Name')]); ?></div>
			<div class="brief" wow='fadeInUp'><?=nl2br($factory_mold[ln('BriefDescription')]); ?></div>
		</div>
	</section>

	<?//服务项目 ?>
	<section id="mold-serve">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=l('服务项目','Service Items'); ?></div>
			<?php // 移动端?>
			<div class="content m-pic mobile">
				<img src="<?=img::get($service_item_pic[0]['path']);?>" alt="<?=$service_item_pic[0]['alt']; ?>" title="<?=$service_item_pic[0]['title']; ?>" />
			</div>

			<?php // PC 端 ?>
			<div class="content" wow='fadeInUp'>
				<div class="one">
					<div class="two">
						<div class="three"><?=nl2br($factory_mold[ln('Name2')]); ?></div>
					</div>
				</div>
				<?php foreach((array)$factory_mold_data as $k => $v){ ?>
					<div class="li li<?=$k+1; ?>">
						<div class="word"><div class="text"><?=nl2br($v[ln('brief')]); ?></div></div>
						<div class="icon">
							<div class="m-pic"><img src="<?=img::get($v['icon']); ?>" alt="<?=$v[ln('title')]; ?>" /></div>
							<?=$v[ln('title')]; ?>
						</div>
					</div>
				<?php }?>
			</div>
		</div>
	</section>

	<?//服务案例 ?>
	<section id="mold-case">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=l('服务案例','Service Cases'); ?></div>
			<div class="content" wow='fadeInUp'>
				<div class='container' page="none" space="5" loop prev="#mold-case .prev" next="#mold-case .next">
					<div class='wrapper'>
						<?php foreach((array)$factory_mold_cases as $k => $v) {?>
							<div class='slide b-pic'>
								<div class="img i-pic"><img src="<?=img::get($v['pic']); ?>" alt="<?=$v[ln('title')]; ?>" /></div>
								<div class="word">
									<div class="text">
										<div class="name"><?=$v[ln('title')]; ?></div>
										<div class="brief"><?=nl2br($v[ln('brief')]); ?></div>
									</div>
									<?php if($v['url']) {?>
										<a href="<?=$v['url']; ?>" class="btn trans block"><?=l('了解详情','Learn More')?></a>
									<?php }?>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="pn prev m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
				<div class="pn next m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
			</div>
		</div>
	</section>
	
	<?//服务流程 ?>
	<section id="mold-process">
		<div class="cw1600 relative">
			<div class="title" wow='fadeInUp'><?=l('服务流程','Service Process'); ?></div>
			<?php // 移动端?>
			<div class="content m-pic mobile">
				<img src="<?=img::get($service_process_pic[0]['path']);?>" alt="<?=$service_process_pic[0][ln('alt')]; ?>" title="<?=$service_process_pic[0][ln('title')]; ?>"  />
			</div>
			<?php // PC端?>
			<div class="content" wow='fadeInUp'>
				<?php foreach((array)$factory_mold_process as $k => $v) {?>
					<div class="box">
						<div class="top">
							<div class="num"><?=$k+1; ?></div>
							<div class="icon m-pic"><img src="<?=img::get($v['icon']); ?>" alt="<?=$v[ln('title')]; ?>" /></div>
						</div>
						<div class="center">
							<div class="line"></div>
							<div class="round"></div>
							<div class="text"><?=$v[ln('title')]; ?></div>
						</div>
						<?php if($k == 3){?>
							<div class="ok">OK</div>
							<div class="ng m-pic">
								<img src="/images/factory/ng.png" alt="" />
							</div>
						<?php }?>
					</div>
				<?php }?>
			</div>
			<div class="wire"></div>
		</div>
	</section>
	
	<?php include 'inc/footer.php';?>
</body>
</html>