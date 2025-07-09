<?php
// 智能工厂 自动化
// 防止胡乱进入
isset($c) || exit;

$navId = 'factory';
$navTwoId = $navBanId = 'automation';
$seo = db::seo('automation');

// $automation_cate = db::get_all('wb_factory_category', 'Dept = 1', "*", 'MyOrder asc, Id asc');
// $CateId = (int)$_GET['aid']?$_GET['aid']:$automation_cate[0]['Id'];

// $where = "Language='{$c['lang']}'";
// $CateId && $where .= " and wb_automation_category_id = '{$CateId}'";
// $pg = (int)$_GET['pg'];
// $page_list = db::get_limit_page('wb_factory_automation', $where,'*',db::get_order_by('new','wb_factory_automation'),$pg, 6,
// 	array(
// 		'prev' => '<div class="pn box m-pic trans l"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
// 		'next' => '<div class="pn box m-pic trans r"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
// 		)
// 	);
// if($pg>$page_list['total_page']){return false;}

$factory_auto = db::get_one('wb_factory_auto',"1",'*');
$factory_auto_data = str::json($factory_auto['Data'], 'decode');

$page_row = db::get_all('wb_factory_auto_list', "Language = '{$c['lang']}'", '*', 'MyOrder asc, AddTime asc');
?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body class="auto_back">
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?php include 'inc/menu.php'; ?>
	</div>

	<section id="megacloud-info">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=nl2br($factory_auto[ln('Name')]); ?></div>
			<div class="brief" wow='fadeInUp'><?=nl2br($factory_auto[ln('BriefDescription')]); ?></div>
			<?php if($factory_auto_data[0][ln('Title')]) {?>
			<div class="data" wow='fadeInUp'>
				<?php foreach((array)$factory_auto_data as $k => $v){?>
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
	<section id="automation">
		<div class="cw1600">
			<div class='container choose mobile' view="auto" page="none" loading wow='fadeInUp'>
				<div class='wrapper <?=!server::mobile(1) && count($automation_cate)<4?'flex-center':'';?>'>
					<?php foreach((array)$automation_cate as $k => $v) {?>
						<a href="<?=url::set($v,'wb_factory_category'); ?>" class='slide box trans <?=$CateId == $v['Id'] ?'cur':''; ?>'><?=$v[ln('Name')]; ?></a>
					<?php }?>
				</div>
			</div>

			<div class="content" wow='fadeInUp'>
				<?php foreach((array)$page_list['row'] as $k => $v) {
					$pic = str::json($v['Picture'], 'decode');
				?>
					<div class="list" wow='fadeInUp'>
						<div class="word">
							<div class="name"><?=$v['Name']; ?></div>
							<div class="ul">
								<div class="li">
									<div class="tit"><?=l('核心价值','Core Values'); ?>：</div>
									<div class="brief"><?=nl2br($v['BriefDescription']); ?></div>
								</div>
								<div class="li">
									<div class="tit"><?=l('技术特点','Technical Characteristics'); ?>：</div>
									<div class="brief"><?=nl2br($v['Point']); ?></div>
								</div>
							</div>
						</div>
						<div class="img m-pic b-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute" /></div>
					</div>
				<?php }?>
			</div>

			<?php include 'inc/page.php';?>
		</div>
	</section>
	<?*/?>
	
	<?php include 'inc/footer.php';?>
</body>
</html>
<!-- <script>
	$(document).on('hover','#automation .choose .box',function(){
		$(this).addClass('cur').siblings().removeClass('cur');
        var id = $(this).data('id');

        $.post('smart-factory-automation', {id:id}, function(html){
            // $('#automation .ajaxBox').html(html);
        },'html');
        return false;
	});
</script> -->

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