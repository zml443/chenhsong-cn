<?php
// 防止胡乱进入
// 智能工厂 智慧工程
isset($c) || exit;

$navId = 'factory';
$navTwoId = $navBanId = 'factory';

$seo = db::seo('smart');

// $factory_list = db::get_all('wb_factory', "Language = '{$c['lang']}'", "*", 'MyOrder asc, Id asc');

$factory_factory = db::get_one('wb_factory_factory',"1",'*');
$factory_factory_data = str::json($factory_factory['Data'], 'decode');

$page_row = db::get_all('wb_factory_factory_list', "Language = '{$c['lang']}'", '*', 'MyOrder asc, AddTime asc');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body class="factory">
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?php include 'inc/menu.php'; ?>
	</div>	

	<section id="megacloud-info">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=nl2br($factory_factory[ln('Name')]); ?></div>
			<div class="brief" wow='fadeInUp'><?=nl2br($factory_factory[ln('BriefDescription')]); ?></div>
			<?php if($factory_factory_data[0][ln('Title')]) {?>
			<div class="data" wow='fadeInUp'>
				<?php foreach((array)$factory_factory_data as $k => $v){?>
					<div class="box" wow='fadeInUp'>
						<div class="icon m-pic"><img src="<?=img::get($v['pic']); ?>" alt="" /></div>
						<div class="text"><?=nl2br($v[ln('title')]); ?></div>
					</div>
				<?php }?>
			</div>
			<?php }?>
		</div>
	</section>
	
	<?php if($page_row) {?>
	<section id="megacloud-choose">
		<div class="cw1600 container" page="none" view="auto">
			<div class='wrapper flex-center'>
				<?php foreach((array)$page_row as $k => $v) {?>
					<a href="#li<?=$k+1?>" class='slide trans <?=$k==0?"cur":""?>' position-follow-cur="#li<?=$k+1?>" top="150px">
						<div class="en"><?=nl2br($v['SubName']); ?></div>
						<div class="cn"><?=nl2br($v['Name']); ?></div>
					</a>
				<?php }?>
			</div>
		</div>
	</section>

	<!-- 列表 -->
	<section id="megacloud-list">
		<?php foreach((array)$page_row as $k => $v) {
			$data = str::json($v['Data'], 'decode');
			$pic = str::json($v['Picture'], 'decode');
		?>
			<div class="list" id="li<?=$k+1?>">
				<div class="cw1600 content" wow='fadeInUp'>
					<div class="word">
						<div class="en"><?=nl2br($v['SubName']); ?></div>
						<div class="cn"><?=nl2br($v['Name']); ?></div>
						<div class="brief"><?=nl2br($v['BriefDescription']); ?></div>

						<div class="data">
							<?php foreach((array)$data as $k1 => $v1){ ?>
								<div class="box">
									<div class="icon m-pic"><img src="<?=img::get($v1['pic']);?>" alt="<?=$v1['title']; ?>" /></div>
									<div class="text"><?=$v1['title']; ?></div>
								</div>
							<?php }?>
						</div>
					</div>

					<div class='container' page="none" loading>
						<div class='wrapper'>
							<?php foreach((array)$pic as $k1 => $v1) {?>
								<div class="slide img m-pic relative over" image-show="组<?=$v['Id']?>|<?=img::get($v1['path']);?>">
									<img class="absolute max" src="<?=img::get($v1['path']);?>" alt="" />
								</div>
							<?php }?>
						</div>
					</div>

				</div>
			</div>
		<?php }?>
		
	</section>
	<?php }?>

	<?/*?>
	<section id="smart">
		<?php foreach((array)$factory_list as $k => $v){
			$pic = str::json($v['Picture'], 'decode');
		?>
		<div class="list over">
			<div class="cw1600 content">
				<div class="img i-pic"  wow='fadeInUp'>
					<img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute" />
				</div>
				<div class="word"  wow='fadeInUp'>
					<div class="title trans"><?=$v['Name']; ?></div>
					<div class="info trans"><?=nl2br($v['BriefDescription']); ?></div>
					<?php if($v['Advantage']) { ?>
					<div class="name trans"><?=l('特点和优势','Features and Advantages')?></div>
					<div class="brief trans"><?=nl2br($v['Advantage']); ?></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php }?>
	</section>
	<?*/ ?>
	
	<?php include 'inc/footer.php';?>
</body>
</html>
<script>
	// 二级导航点击切换
	$(document).on('click','#megacloud-choose .container .slide',function(){
		$(this).addClass('cur').siblings().removeClass('cur');
	});

	$(function(){
		$(window).scroll(function(e){
			var s_top = $(window).scrollTop();
			var banner_h = $('#inner-banner').outerHeight();
			var h1 = $('#megacloud-info').outerHeight();
			var h2 = $('#megacloud-choose').outerHeight();
			var nav_h = banner_h + h1 + h2;
			if(s_top >= nav_h){
				$('#megacloud-choose').addClass('cur');
			}else{
				$('#megacloud-choose').removeClass('cur');
			}

			// 二级导航滚动切换
			$('[position-follow-cur]').each(function(){
				var obj = $($(this).attr('position-follow-cur'));
				if (obj.size()==0) {
					return;
				}
				var top = obj.offset().top;
				if(s_top + 150>=top){
					var cur = $(this);
					cur.addClass('cur').siblings().removeClass('cur');
				}
			});
		});
	});
</script>