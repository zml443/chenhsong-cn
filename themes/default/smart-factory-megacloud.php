<?php
// 防止胡乱进入
// 智能工厂 MegaCloud平台
isset($c) || exit;

$navId = 'factory';
$navTwoId = $navBanId = 'megacloud';
$seo = db::seo('megacloud');

$factory_megacloud = db::get_one('wb_factory_megacloud',"1",'*');
$factory_megacloud_data = str::json($factory_megacloud['Data'], 'decode');

$page_row = db::get_all('wb_factory_list', "Language = '{$c['lang']}'", '*', 'MyOrder asc, AddTime asc');

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body class="megacloud">
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?php include 'inc/menu.php'; ?>
	</div>	
	
	<section id="megacloud-info">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=nl2br($factory_megacloud[ln('Name')]); ?></div>
			<div class="brief" wow='fadeInUp'><?=nl2br($factory_megacloud[ln('BriefDescription')]); ?></div>
			<div class="data" wow='fadeInUp'>
				<?php foreach((array)$factory_megacloud_data as $k => $v){?>
					<div class="box" wow='fadeInUp'>
						<div class="icon m-pic"><img src="<?=img::get($v['pic']); ?>" alt="" /></div>
						<div class="text"><?=nl2br($v[ln('title')]); ?></div>
					</div>
				<?php }?>
			</div>
		</div>
	</section>
	
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