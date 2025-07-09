<?php
// 防止胡乱进入
isset($c) || exit;

$navId = 'industry';
$footer_back = 'white';

$InId = (int)$_GET['id'];
// $info = db::get_one('wb_industry', "Id = '{$InId}' and Language = '{$c['lang']}' and IsSaleOut != 1", '*');
// if(!$info){return false;}

$info = db::get_one('wb_industry', "Id = '{$InId}' and IsSaleOut = 0 and Language='{$c['lang']}'", '*');
$monitor = db::get_one('wb_industry',"Id = '{$InId}' and IsSaleOut = 0",'*');

if($monitor && !$info){
    header("Location: /");
}elseif(!$info){
    return false;
}

$seo = db::seo('wb_industry',$InId);
$ind_banner = str::json($info['Pictures'], 'decode');
$info_name = $info['Name'].l('行业方案',' Industry Solutions'); 

// 菜单
$pro_menu = array(
	'technology' => array('href'=>'#industry-technology','name'=>l('技术优势','Advantages'),'top'=>'100px'),
	'application' => array('href'=>'#industry-application','name'=>l('应用案例','Application Cases'),'top'=>'100px'),
	'custom' => array('href'=>'#industry-custom','name'=>l('客户案例','Cases'),'top'=>'100px'),
	'products' => array('href'=>'#industry-recommend','name'=>l('推荐机型','Models'),'top'=>'100px'),
	// 'relevant' => array('href'=>'#industry-relevant','name'=>l('相关技术/自动化','Related'),'top'=>'100px'),
	'info' => array('href'=>'#industry-info','name'=>l('相关资讯','Related News'),'top'=>'100px'),
	'form' => array('href'=>'#contact_form','name'=>l('联系我们','Contact Us'),'top'=>'100px'),
);

// 技术优势
$technology = str::json($info['Data'], 'decode');
if(empty($technology[0]['title'])) {
	$pro_menu['technology'] = [];
}

// 应用案例
// $application = str::json($info['Pictures2'], 'decode');
// if(empty($application[0]['path'])) {
// 	$pro_menu['application'] = [];
// }

$pg = (int)$_GET['pg'];
$app_cases = db::get_limit_page('wb_industry_application', "wb_industry_id = '{$InId}'", '*', 'MyOrder asc, AddTime asc', $pg,  6);
if(!$app_cases['row']) {
	$pro_menu['application'] = [];
}


// 客户案例
$cases_id = $info['wb_cases_id'];
if($cases_id){
	$where = "Id in ({$cases_id}) and IsSaleOut != 1 and Language = '{$c['lang']}'";
	$rel_cases = db::get_all('wb_blog', $where, '*', 'MyOrder asc, AddTime asc');
}
// else{
// 	$where = "wb_blog_category_id = 4 and IsSaleOut != 1 and Language = '{$c['lang']}'";
// 	$rel_cases = db::get_all('wb_blog', $where, '*', 'MyOrder asc, AddTime asc');
// }

if(!$rel_cases){
	$pro_menu['custom'] = [];
}

// 相关机型
$products_id = $info['wb_products_id'];
if($products_id){
	$where = "Id in ({$products_id}) and IsSaleOut != 1 and Language = '{$c['lang']}'";
	$rel_products = db::get_all('wb_products', $where, '*', 'MyOrder asc, AddTime asc');
}
if(!$rel_products){
	$pro_menu['products'] = [];
}

// 相关技术
$rel_tech = db::get_limit('wb_about_technology', "1", '*','MyOrder asc, AddTime asc',0,3);

// 相关自动化
$auto_id = $info['wb_automation_id'];
if($auto_id){
	$where = "Id in ({$auto_id}) and Language = '{$c['lang']}'";
	$rel_auto = db::get_all('wb_factory_automation', $where, '*', 'MyOrder asc, AddTime asc');
}
// if(!$rel_auto){
//     $pro_menu['relevant'] = array('href'=>'#industry-relevant','name'=>l('相关技术','Related'),'top'=>'100px');
// }

// 相关资讯
$blog_id = $info['wb_blog_id'];
if($blog_id){
	$where = "Id in ({$blog_id}) and IsSaleOut != 1 and Language = '{$c['lang']}'";
	$rel_blog = db::get_limit('wb_blog', $where, '*', 'MyOrder asc, AddTime asc',0,4);
}
// else{
// 	$where = "IsSaleOut != 1 and Language = '{$c['lang']}'";
// 	$rel_blog = db::get_limit('wb_blog', $where, '*', 'MyOrder asc, AddTime asc',0,4);
// }
if(!$rel_blog){
	$pro_menu['info'] = [];
}

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body>
	<?php include 'inc/header.php';?>

	<div class="other_banner relative">
		<section id="ind_banner" class="relative over">
			<div class="pic relative i-pic">
				<?php if(server::mobile(1)){?>
					<img class="absolute max" src="<?=img::get($ind_banner[1]['path']);?>" alt="<?=$ind_banner[1]['alt']; ?>"  title="<?=$ind_banner[1]['title']; ?>" />
				<?php } else {?>
					<img class="absolute max" src="<?=img::get($ind_banner[0]['path']);?>" alt="<?=$ind_banner[0]['alt']; ?>"  title="<?=$ind_banner[0]['title']; ?>" />
				<?php }?>
			</div>

			<div class="banner_box absolute max">
				<div class="box cw1600">
					<div class="menu">
						<a href="/"><?=l('首页','Home');?></a>
						<span>/</span>
						<a href="/industry"><?=$nav[$navId]['name'];?></a>
						<span>/</span>
						<a href="javascript:;"><?=$info_name;?></a>
					</div>

					<div class="info">
						<div class="name"><?=$info_name;?></div>
						<div class="brief"><?=nl2br($info['BriefDescription']); ?></div>
					</div>
				</div>
			</div>
		</section>

		<section id="pro_menu" class="absolute">
			<div class="cw1600 relative">
				<div class="nav flex-center relative">
					<div class='container' free view="auto" page="none" prev="#pro_menu .prev" next="#pro_menu .next">
						<div class='wrapper'>
							<?php foreach((array)$pro_menu as $k => $v) {
								if(empty($v)){continue;}
								?>
								<a href="<?=$v['href']; ?>" position-follow-cur="<?=$v['href']; ?>" top="<?=$v['top']; ?>" class="slide text-center trans"><?=$v['name']; ?></a>
							<?php } ?>
						</div>
					</div>
				</div>
				
				<div class="prev btn absolute pointer fz0 m-pic"><img src="/images/products/jt-down.png" /></div>
				<div class="next btn absolute pointer fz0 m-pic"><img src="/images/products/jt-down.png" /></div>
			</div>
		</section>
	</div>
	
	<?php 
		// 技术优势
		if(!empty($technology[0]['title'])) {
	?>
	<section id="industry-technology">
		<div class="cw1600">
			<!-- <div class="title" wow='fadeInUp'><?//=$pro_menu['technology']['name']; ?></div> -->

			<div class="content">
				<div class="left" wow='fadeInUp'>
					<div class="pn m-pic trans prev"><img src="/images/industry/pn.svg" class="svg trans" alt="" /></div>

					<div class="container" page="none" view="auto" vertical="" 
						prev="#industry-technology .prev" 
						next="#industry-technology .next"
					>
						<div class='wrapper' tab="{hover:1}" to="#industry-technology .bind" fn="ly2._ly2_tab_">
							<?php foreach((array)$technology as $k => $v){?>
								<div class='slide trans <?=$k==0?'cur':'';?>'>
									<div class="word">
										<div class="name trans text-line2"><?=$v['title']; ?></div>
										<div class="brief trans"><?=nl2br($v['brief']); ?></div>
									</div>
								</div>
							<?php }?>
						</div>
					</div>

					<div class="pn m-pic trans next"><img src="/images/industry/pn.svg" class="svg trans" alt="" /></div>
				</div>

				<div class="right bind over" wow='fadeInUp'>
					<?php foreach((array)$technology as $k => $v){
						$pic = img::get($v['pic'])?img::get($v['pic']):'/images/industry/technology1.jpg';
						?>
						<div class="box relative over m-pic <?=$k==0?'cur':'';?>">
							<img class="absolute max" src="<?=$pic; ?>" alt="<?=$v['title']; ?>" />
						</div>
					<?php }?>
				</div>
			</div>
			
			<? // 移动端 ?>
			<div class='container mobile' fn="__swiper_" view="auto" loop wow='fadeInUp'>
			    <div class='wrapper'>
					<?php foreach((array)$technology as $k => $v){
						$pic = img::get($v['pic'])?img::get($v['pic']):'/images/industry/technology1.jpg';
						?>
						<div class='slide'>
							<div class="img relative over m-pic">
								<img class="absolute max" src="<?=$pic ?>" alt="<?=$v['title']; ?>" />
							</div>
							<div class="word">
								<div class="name trans"><?=$v['title']; ?></div>
								<div class="brief trans"><?=nl2br($v['brief']); ?></div>
							</div>
						</div>
					<?php }?>
			    </div>
			</div>			

		</div>
	</section>
	<?php }?>
	

	<?php
		// 应用案例
		if($app_cases['row']) {
	?>
	<div>
		<section id="industry-application">
			<div class="cw1600">
				<div class="title" wow='fadeInUp'><?=$pro_menu['application']['name']; ?></div>

				<div class="list flex-wrap" wow='fadeInUp'>
					<?php foreach((array)$app_cases['row'] as $k => $v) {
							$pic = str::json($v['Pictures'], 'decode');
						?>
						<div class="item relative over">
							<div class="bot relative">
								<div class="back relative over i-pic">
									<img class="absolute max trans" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" />
								</div>
								<div class="name absolute text-over"><?=$v['Name']; ?></div>
							</div>

							<div class="top absolute max trans">
								<div class="in">
									<div class="p1"><?=nl2br($v['Name']); ?></div>
									<div class="p2"><?=nl2br($v['BriefDescription']); ?></div>
								</div>
							</div>
						</div>
					<?php }?>
				</div>

				<?php if($app_cases['total_page'] > 1){?>
					<div ajax-append="{page:<?=$app_cases['page']+1?>,total_page:<?=$app_cases['total_page']?>}" to="#industry-application .list" class="more flex-max2 trans pointer" wow='fadeInUp'>
						<div class="txt trans"><?=l('更多案例','More Cases'); ?></div>
						<div class="jt m-pic trans"><img class="svg" src="/images/about/introduce/more.svg" /></div>
					</div>
				<?php }?>
			</div>
		</section>
	</div>
	<?php }?>

	<?php
	/*
		// 应用案例
		if(!empty($application[0]['path'])) {
	?>
	<section id="industry-application">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=$pro_menu['application']['name']; ?></div>

			<div class='container relative' delay="5s" view="1" loading>
				<div class='wrapper'>
					<?php foreach((array)$application as $k => $v) {?>
						<div class='slide realtive over i-pic'>
							<img class="absolute max" src="<?=img::get($v['path']); ?>" alt="<?=$v['alt']; ?>"  title="<?=$v['title']; ?>" />
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</section>
	<?php }*/?>
	
	<?php
		// 客户案例
		if($rel_cases) {
	?>
	<section id="industry-custom">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=$pro_menu['custom']['name']; ?></div>
			<div class='container' fn="__swiper_" view="auto" -loop wow='fadeInUp'>
			    <div class='wrapper <?=count($rel_cases)<3 ?'flex-center':'';?>'>
					<?php foreach((array)$rel_cases as $k => $v){
						$url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
						$pic = str::json($v['Pictures'], 'decode');
					?>
						<div class='slide b-pic'>
							<div class="img i-pic relative">
								<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="absolute max i-pic"><img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" /></a>

								<?php if(img::get($v['Video'])){ ?>
									<div class="play trans5 absolute m-pic pointer" ly-video src="<?=img::get($v['Video']); ?>">
										<img src="/images/icon/play.svg" class="svg trans" alt="<?=$v['Name']?>" />
									</div>
								<?php }?>
							</div>
							<div class="word">
								<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="name block trans text-over"><?=$v['Name']?></a>
								<div class="brief trans text-line2"><?=$v['BriefDescription']?></div>
							</div>
						</div>
					<?php }?>
			    </div>
			</div>
		</div>
	</section>
	<?php }?>
	
	<?php
		// 推荐机型
		if($rel_products) {
	?>
	<section id="industry-recommend">
		<div class="cw1600">
			<div class="title" wow='fadeInUp'><?=$pro_menu['products']['name']; ?></div>
			<div class="content" wow='fadeInUp'>
				<div class='container' fn="__swiper_" view="auto" prev="#industry-recommend .prev" next="#industry-recommend .next">
					<div class='wrapper'>
						<?php foreach((array)$rel_products as $k => $v){
							$pic = str::json($v['Pictures'], 'decode');
							$url = url::set($v,'wb_products.detail');
							?>
							<a href="<?=$url; ?>" class='slide block b-pic'>
								<div class="img m-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max trans absolute"/></div>
								<div class="word">
									<div class="name trans"><?=$v['Name']; ?></div>
									<div class="brief trans"><?=$v['BriefDescription']; ?></div>
								</div>
							</a>
						<?php }?>
					</div>
				</div>
				<div class="pn trans m-pic prev"><img src="/images/industry/pn.svg" alt="" class="svg" /></div>
				<div class="pn trans m-pic next"><img src="/images/industry/pn.svg" alt="" class="svg" /></div>
			</div>
		</div>
	</section>
	<?php }?>
	
	<!-- 相关内容 -->
	<?/*?>
	<section id="industry-relevant">
		<div class="cw1600">
			<div class="top" wow='fadeInUp'>
				<div class="choose" tab="{}" to="#industry-relevant .bind" fn="ly2._ly2_tab_">
					<div class="box trans cur"><?=l('相关技术','Technologies')?></div>
					<?php if($rel_auto) {?>
					<div class="box trans"><?=l('相关自动化','Automation')?></div>
					<?php }?>
				</div>
				<div class="bind">
					<a href="/technology" class="btn block trans"><?=l('了解更多','Learn More')?></a>
					<?php if($rel_auto) { ?>
					<a href="/smart-factory-automation" class="btn block trans"><?=l('了解更多','Learn More')?></a>
					<?php }?>
				</div>
			</div>

			<div class="bind" wow='fadeInUp'>
				<div class="content">
					<?php foreach((array)$rel_tech as $k => $v){
						$pic = str::json($v['Pictures2'], 'decode');
						?>
						<a href="/technology#tech<?=$v['Id']; ?>" class="box block b-pic" wow='fadeInUp'>
							<div class="name trans text-over"><?=$v[ln('Name')]; ?></div>
							<div class="brief  text-line2"><?=$v[ln('Brief')]; ?></div>
							<div class="img i-pic">
								<img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>" title="<?=$pic[0]['title']; ?>"  class="max absolute"/>
							</div>
						</a>
					<?php }?>
				</div>

				<?php if($rel_auto) { ?>
				<div class="content <?=count($rel_auto)<3?'flex-center':'';?>">
					<?php foreach((array)$rel_auto as $k => $v){
						$pic = str::json($v['Picture'], 'decode');
					?>
						<div class="box block b-pic">
							<div class="name trans text-over"><?=$v['Name']; ?></div>
							<div class="brief text-line2"><?=$v['BriefDescription']; ?></div>

							<div class="img i-pic">
								<img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>" title="<?=$pic[0]['title']; ?>"  class="max absolute"/>
							</div>
						</div>
					<?php }?>
				</div>
					<?php }?>
			</div>
		</div>
	</section>
	<?*/?>
	
	<?php
		// 相关资讯
		if($rel_blog) {
	?>
	<section id="industry-info">
		<div class="cw1600">
			<div class="top">
				<div class="title" wow='fadeInUp'><?=$pro_menu['info']['name']; ?></div>
				<a href="/blog" class="btn trans"><?=l('了解更多','Learn More')?></a>
			</div>
			<div class="content <?=count($rel_blog)<4?'flex-center':'';?>" wow='fadeInUp'>
				<?php foreach((array)$rel_blog as $k => $v){
					$url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
					$pic = str::json($v['Pictures'], 'decode');
				?>
					<div class="box b-pic" wow='fadeInUp'>
						<div class="img i-pic">
							<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="absolute max i-pic"><img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" /></a>

							<?php if(img::get($v['Video'])){ ?>
								<div class="play trans5 absolute m-pic pointer" ly-video src="<?=img::get($v['Video']); ?>">
									<img src="/images/icon/play.svg" class="svg trans" alt="<?=$v['Name']?>" />
								</div>
							<?php }?>
						</div>
						<div class="word">
							<div class="time"><?=date('Y.m.d', (int)$v['AddTime']); ?></div>
							<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="name trans text-line2"><?=$v['Name']?></a>
						</div>
					</div>
				<?php }?>
			</div>
		</div>
	</section>
	<?php }?>

	<!-- 联系我们 -->
	<?php include 'inc/contact_form.php'; ?>

	<?php include 'inc/footer.php';?>
</body>
</html>

<script>
	$(document).on('click','#industry-application .content .car .drop',function(){
		$('#industry-application .content .out').stop().slideDown();
	});
	$(document).on('click','#industry-application .content .out .info .close',function(){
		$('#industry-application .content .out').stop().slideUp();
	});

	$(function(){
		$(window).scroll(function(){
			var s_top = $(window).scrollTop();
			var header_h = $('#header').outerHeight();
			var banner_h = $('#ind_banner').outerHeight();
			var nav_h = banner_h;
			if(s_top >= nav_h){
				$('#pro_menu').addClass('fixed');
			}else{
				$('#pro_menu').removeClass('fixed');
			}

			if($('#pro_menu').length){
				$('[position-follow-cur]').each(function(){
					var obj = $($(this).attr('position-follow-cur'));
					if (obj.size()==0) {
						return;
					}
					var top = obj.offset().top;	

					if(s_top + 150>=top){
						$(this).addClass('cur').siblings().removeClass('cur');
					}
				});
			}
			
		});
	});
</script>