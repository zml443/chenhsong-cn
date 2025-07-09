<?php

// 防止胡乱进入
isset($c) || exit;

$navId='index';

$index_about = db::get_one('wb_webhome_about',"1",'*');
$index_about_data = str::json($index_about['Data'], 'decode');

$ind_branch = db::get_one('wb_webhome_address',"1",'*');
$ind_branch_data = str::json($ind_branch['Data'], 'decode');

$ind_duty = db::get_one('wb_about_info',"1",'*');
$ind_duty_list = db::get_all('wb_about_responsibility', "Language = '{$c['lang']}'", "*", 'MyOrder asc, Id asc');

$blog_cate = db::get_all('wb_blog_category', 'Dept = 1', "*", 'MyOrder asc, Id asc');

$ind_custom = db::get_one('wb_webhome_custom',"1",'*');
$ind_custom_logo = str::json($ind_custom['Pictures'], 'decode');

$ind_join = db::get_one('wb_webhome_join',"1",'*');
$ind_join_data = str::json($ind_join['Data'], 'decode');

$ind_factory = db::get_one('wb_factory_home',"1",'*');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body class="index">
	
	<?php include 'inc/header.php'; ?>

	<?php include 'inc/banner.php'; ?>

	<? // 走进震雄 ?>
	<section id="ind_about">
		<div class="cw1680">
			<div class="tit" wow="fadeInUp"><?=nl2br($index_about[ln('Name')]); ?></div>
			<div class="brief" wow="fadeInUp"><?=nl2br($index_about[ln('BriefDescription')]); ?></div>

			<?php if(img::get($index_about[ln('Video')])){ ?>
			<div class="play m-pic pointer" ly-video src="<?=img::get($index_about[ln('Video')]); ?>">
				<img src="/images/icon/play.svg" class="svg trans" alt="">
			</div>
			<?php }?>

			<div class="list flex-between flex-top2">
				<?php foreach((array)$index_about_data as $k => $v) {?>
				<div class="li">
					<div class="num">
						<span ly-number-roll><?=$v[ln('unit')]['number']; ?></span>
						<span class="txt"><?=$v[ln('unit')]['unit']; ?></span>
					</div>
					<div class="name"><?=$v[ln('name')]; ?></div>
				</div>
				<?php }?>
			</div>
		</div>
	</section>
	
	<? // 产品选项卡 ?>
	<section id="ind_pro">
		<div class="cw1680">
			<div class="title" wow="fadeInUp"><?=nl2br($index_about[ln('Name2')]); ?></div>
			
			<div class="bot relative" wow="fadeInUp">
				<div class='container' <?=server::mobile(1)?'center':''; ?> view="auto" page="none" prev="#ind_pro .bot .c_prev" next="#ind_pro .bot .c_next">
					<div class='wrapper' tab="{}" to="#ind_pro .top">
						<?php foreach((array)$nav['factory']['children'] as $k => $v){
							if($k>1){continue;}
							?>
							<div class="slide flex-center flex-middle2"><?=$v['name']?></div>
						<?php }?>

						<div class="slide flex-center flex-middle2 cur"><?=l('注塑机','Injection molding machine');?></div>

						<?php 
							$count = 0;
							foreach((array)$nav['factory']['children'] as $k => $v){
								if($count < 2){
									$count++;
									continue;
								}
							?>
							<div class="slide flex-center flex-middle2">
								<?=$v['name']?>
							</div>
						<?php }?>
					</div>
				</div>

				<div class="c_prev m-pic pointer absolute btn trans">
					<img src="/images/icon/prev.svg" class="svg" >
				</div>
				<div class="c_next m-pic pointer absolute btn trans">
					<img src="/images/icon/next.svg" class="svg" >
				</div>
			</div>

			<div class="top" wow="fadeInUp">
				<?php foreach((array)$nav['factory']['children'] as $k => $v){
					if($k>1){continue;}
					$imgPath = '';
					$img_ext = array('jpg', 'png', 'jpge');
					if($v['subname'] == 'engineering'){
						$imgPath = str::json($ind_factory['Pictures'], 'decode');
					}else if($v['subname'] == 'megacloud'){
						$imgPath = str::json($ind_factory['Pictures2'], 'decode');
					}
					$img = $imgPath[0]['path'];
					$file_data = pathinfo($img);
				?>
					<div class="top_bind hide">
						<?php
							if($imgPath){
								if(in_array($file_data['extension'], $img_ext)){
									?>
									<div class="img m-pic flex-center flex-middle">
										<img src="<?=$img; ?>" alt="<?=$imgPath[0][ln('alt')]; ?>" title="<?=$imgPath[0][ln('title')]; ?>" />
									</div>
								<?php }else {?>
									<div class="video flex-center flex-middle">
										<video src="<?=$img; ?>" controls muted autoplay loop webkit-playsinline="true" playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>
									</div>
								<?php }?>
						<?php }else{?>
							<div class="not_tip">
								<?=l('暂时没有产品信息','There is currently no product information available');?><?=$k;?>
							</div>
						<?php }?>
					</div>
				<?php }?>

				<?// 产品 ?>
				<div class="top_bind flex-top2 flex-between cur">
					<div class="left">
						<div class="left_box relative">
							<div class="tit"><?=l('注塑机','Injection molding machine');?></div>
							<div class="list" tab="{hover: 1}" to="#ind_pro .right">
								<?php foreach((array)$nav['products']['children'] as $k => $v){?>
									<div class="li pointer trans <?=$k==0?'cur':''?>">
										<?=$v['name']?>
									</div>
								<?php }?>
							</div>
						</div>
					</div>

					<div class="right">
						<?php $proCount=0; foreach((array)$nav['products']['children'] as $k => $v){ 
							$nav_pro = db::get_all('wb_products',"Language = '{$c['lang']}' and wb_products_category_id = '{$v['Id']}' and IsSaleOut != 1",'*','MyOrder asc,AddTime asc');
						?>
							<?php if($nav_pro) {?>
								<div class="right_bind flex-between flex-top2">
									<? // 产品图 ?>
									<div class="pic">
										<div class='container main maxh relative' loading <?=$proCount>=1?'observer':''?> observeParents page="none" 
											speed="1" control="#ind_pro .top .right .industry .control" 
											prev="#ind_pro .top .right .pic .prev" 
											next="#ind_pro .top .right .pic .next"
										>
											<div class='wrapper'>
												<?php foreach((array)$nav_pro as $prok => $prov){
													$pic = str::json($prov['Pictures'], 'decode');
													$url = url::set($prov,'wb_products.detail');
												?>
													<div class="slide block">
														<a href="<?=$url; ?>" class="img block relative m-pic over">
															<img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" />
														</a>

														<div class="pro_name flex-center flex-middle2">
															<a href="<?=$url; ?>" class="txt block trans text-over"><?=$prov['Name']?></a>
														</div>
													</div>
												<?php }?>
											</div>

											<div class="prev m-pic pointer absolute pn trans">
												<img src="/images/icon/prev.svg" class="svg trans" alt="">
											</div>
											<div class="next m-pic pointer absolute pn trans">
												<img src="/images/icon/next.svg" class="svg trans" alt="">
											</div>
										</div>
									</div>

									<? // 行业 ?>
									<div class="industry">
										<div class="tit text-center"><?=l('适用行业','Industry'); ?></div>
										<div class="container maxw control" view="1" space="9" effect="fade" <?=$proCount>=1?'observer':''?> observeParents loading speed="1" center="" page="none" noSwipingSelector="#ind_pro .top .right .industry .control .slide">
											<div class="wrapper">
												<?php foreach((array)$nav_pro as $prok => $prov){
													$ind_id = $prov['wb_industry_id'];
													if($ind_id){
														$where = "Id in ({$ind_id}) and IsSaleOut != 1";
														$rel_row = db::get_all('wb_industry', "Language = '{$c['lang']}' and ".$where, '*', 'MyOrder asc, Id asc');
													}													
												?>
													<div class="slide flex-wrap flex-between">
														<?php foreach((array)$rel_row as $indk => $indv){
															if($indk>9){continue;}
															$icon = str::json($indv['Pictures3'], 'decode');
															$url = url::set($item, 'wb_industry.detail');
															?>
															<div class="li trans flex-center flex-middle2">
																<a href="<?=$url;?>" class="box trans">
																	<div class="icon svg m-pic trans">
																		<img class="svg" src="<?=img::get($icon[0]['path']);?>" alt="<?=$icon[0]['alt']; ?>"  title="<?=$icon[0]['title']; ?>" />
																	</div>
																	<div class="txt trans text-over"><?=$indv['Name']?></div>
																</a>
															</div>
														<?php }?>
													</div>
												<?php }?>
											</div>
										</div>
									</div>
								</div>
							<?php $proCount++;} else { ?>
								<div class="right_bind hide">
									<div class="not_tip"><?=l('目前没有产品信息','There is currently no product information available!')?></div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>

				<?php 
				$count = 0;
				foreach((array)$nav['factory']['children'] as $k => $v){
					if($count < 2){
						$count++;
						continue;
					}
					$imgPath = '';
					$img_ext = array('jpg', 'png', 'jpge');
					if($v['subname'] == 'mold'){
						$imgPath = str::json($ind_factory['Pictures3'], 'decode');
					}else if($v['subname'] == 'automation'){
						$imgPath = str::json($ind_factory['Pictures4'], 'decode');
					}
					$img = $imgPath[0]['path'];
					$file_data = pathinfo($img);
				?>
					<div class="top_bind hide">
						<?php
							if($imgPath){
								if(in_array($file_data['extension'], $img_ext)){
									?>
									<div class="img m-pic flex-center flex-middle">
										<img src="<?=$img; ?>" alt="<?=$imgPath[0][ln('alt')]; ?>" title="<?=$imgPath[0][ln('title')]; ?>" />
									</div>
								<?php }else {?>
									<div class="video flex-center flex-middle">
										<video src="<?=$img; ?>" controls muted autoplay loop webkit-playsinline="true" playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>
									</div>
								<?php }?>
						<?php }else{?>
							<div class="not_tip">
								<?=l('暂时没有产品信息','There is currently no product information available');?><?=$k;?>
							</div>
						<?php }?>
					</div>
				<?php }?>
			</div>
		</div>
	</section>
	
	<? // 在您身边-地图 ?>
	<section id="ind_branch">
		<div class="cw1680">
			<div class="tit" wow="fadeInUp"><?=nl2br($ind_branch[ln('Name')]); ?></div>
			<div class="brief" wow="fadeInUp"><?=nl2br($ind_branch[ln('BriefDescription')]); ?></div>

			<div class="list flex-between flex-top2" wow="fadeInUp">
				<?php foreach((array)$ind_branch_data as $k => $v) {?>
				<div class="li" >
					<div class="num"><span ly-number-roll><?=$v[ln('unit')]['number']; ?></span><?=$v[ln('unit')]['unit']; ?></div>
					<div class="name"><?=$v[ln('name')]; ?></div>
				</div>
				<?php }?>
			</div>
		</div>
		<div class="bot">
			<div class="map relative over">
				<?php if(server::mobile(1)) { ?>
					<div class="pic m-pic">
						<?php if(c('lang') == 'en'){?>
						<img src="/images/map-en1.jpg" alt="">
						<?php } else { ?>
						<img src="/images/map-cn1.jpg" alt="">
						<?php }?>
					</div>
				<?php } else { ?>
					<div class="pic m-pic">
						<img src="/images/ind_map.png" alt="">
					</div>
					<?php 
						/*
						$branch = array(
							array(
								'Name' 	  => l('深圳','ShenZhen'),
								'Brief'   => l('深圳','Shenzhen'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jnavId',
								'Class'   => 'ShenZhen',
							),
							array(
								'Name' 	  => l('广州','Guangzhou'),
								'Brief'   => l('广州','Guangzhou'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '',
								'Class'   => 'Guangzhou',
							),
							array(
								'Name' 	  => l('北京','Beijing'),
								'Brief'   => l('北京','Beijing'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '',
								'Class'   => 'Beijing',
							),
							array(
								'Name' 	  => l('新加坡','Singaporean'),
								'Brief'   => l('新加坡','Singaporean'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com.cn',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '',
								'Class'   => 'Singaporean',
							),
							array(
								'Name' 	  => l('澳大利亚','Australia'),
								'Brief'   => l('澳大利亚','Australia'),
								'Phone'   => '0755－84139999',
								'Email'   => 'australia@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '',
								'Class'   => 'Australia',
							),
							array(
								'Name' 	  => l('日本','Japan'),
								'Brief'   => l('日本','Japan'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com.cn',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Japan',
							),
							array(
								'Name' 	  => l('俄罗斯','Russian'),
								'Brief'   => l('俄罗斯','Russian'),
								'Phone'   => '0755－84139999',
								'Email'   => 'russia@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Russian',
							),
							array(
								'Name' 	  => l('中国','China'),
								'Brief'   => l('中国','China Operations Headquarters'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'China',
							),
							array(
								'Name' 	  => l('中国香港','Hong Kong, China'),
								'Brief'   => l('中国香港','China Hong Kong'),
								'Phone'   => '0755－84139999',
								'Email'   => 'sales@chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Hongkong',
							),
							array(
								'Name' 	  => l('中国台湾','China, Taiwan'),
								'Brief'   => l('中国台湾','China Taiwan'),
								'Phone'   => '0755－84139999',
								'Email'   => 'sales@chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Taiwan',
							),
							array(
								'Name' 	  => l('越南','Vietnam'),
								'Brief'   => l('越南','Vietnam'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com.cn',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Vietnam',
							),
							array(
								'Name' 	  => l('迪拜','Dubai'),
								'Brief'   => l('迪拜','Dubai'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com.cn',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Dubai',
							),
							array(
								'Name' 	  => l('土耳其','Turkey'),
								'Brief'   => l('土耳其','Turkey'),
								'Phone'   => '0755－84139999',
								'Email'   => 'turkey@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Turkey',
							),
							array(
								'Name' 	  => l('德国','German'),
								'Brief'   => l('德国','German'),
								'Phone'   => '0755－84139999',
								'Email'   => 'service@chenhsong.com.cn',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'German',
							),
							array(
								'Name' 	  => l('印度','India'),
								'Brief'   => l('印度','India'),
								'Phone'   => '0755－84139999',
								'Email'   => 'india@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'India',
							),
							array(
								'Name' 	  => l('巴西','Brazilian'),
								'Brief'   => l('巴西','Brazilian'),
								'Phone'   => '0755－84139999',
								'Email'   => 'brasil@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Brazilian',
							),
							// array(
							// 	'Name' 	  => '意大利',
							// 	'Brief'   => '意大利',
							// 	'Phone'   => '0755－84139999',
							// 	'Email'   => 'service@chenhsong.com.cn',
							// 	'Address' => '深圳市坪山区坑梓街人民路177号',
							// 	'Picture' => '/images/ind-branch.jpg',
							// ),
							// array(
							// 	'Name' 	  => '英国',
							// 	'Brief'   => '英国',
							// 	'Phone'   => '0755－84139999',
							// 	'Email'   => 'service@chenhsong.com.cn',
							// 	'Address' => '深圳市坪山区坑梓街人民路177号',
							// 	'Picture' => '/images/ind-branch.jpg',
							// ),
							array(
								'Name' 	  => l('美国','America'),
								'Brief'   => l('美国','America'),
								'Phone'   => '0755－84139999',
								'Email'   => 'usa@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'America',
							),
							array(
								'Name' 	  => l('加拿大','Canada'),
								'Brief'   => l('加拿大','Canada'),
								'Phone'   => '0755－84139999',
								'Email'   => 'usa@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Canada',
							),
							array(
								'Name' 	  => l('新西兰','New Zealand'),
								'Brief'   => l('新西兰','New Zealand'),
								'Phone'   => '0755－84139999',
								'Email'   => 'australia@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Newzealand',
							),
							array(
								'Name' 	  => l('阿根廷','Argentina'),
								'Brief'   => l('阿根廷','Argentina'),
								'Phone'   => '0755－84139999',
								'Email'   => 'argentina@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Argentina',
							),
							array(
								'Name' 	  => l('墨西哥','Mexico'),
								'Brief'   => l('墨西哥','Mexico'),
								'Phone'   => '0755－84139999',
								'Email'   => 'mexico@support.chenhsong.com',
								'Address' => '深圳市坪山区坑梓街人民路177号',
								'Picture' => '/images/ind-branch.jpg',
								'Class'   => 'Mexico',
							),
						);
						*/
						$branch = array(
							array(
								'Name' 	  => l('澳大利亚','Australia'),
								'Brief'   => l('澳大利亚','Australia'),
								'Phone'   => '',
								'Email'   => 'australia@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Australia',
							),
							array(
								'Name' 	  => l('俄罗斯','Russian'),
								'Brief'   => l('俄罗斯','Russian'),
								'Phone'   => '',
								'Email'   => 'russia@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Russian',
							),
							array(
								'Name' 	  => l('中国','China'),
								'Brief'   => l('中国','China Operations Headquarters'),
								'Phone'   => '',
								'Email'   => 'service@chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'China',
							),
							array(
								'Name' 	  => l('中国香港','Hong Kong, China'),
								'Brief'   => l('中国香港','China Hong Kong'),
								'Phone'   => '',
								'Email'   => 'sales@chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Hongkong',
							),
							array(
								'Name' 	  => l('中国台湾','China, Taiwan'),
								'Brief'   => l('中国台湾','China Taiwan'),
								'Phone'   => '',
								'Email'   => 'sales@chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Taiwan',
							),
							array(
								'Name' 	  => l('土耳其','Turkey'),
								'Brief'   => l('土耳其','Turkey'),
								'Phone'   => '',
								'Email'   => 'turkey@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Turkey',
							),
							array(
								'Name' 	  => l('印度','India'),
								'Brief'   => l('印度','India'),
								'Phone'   => '',
								'Email'   => 'india@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'India',
							),
							array(
								'Name' 	  => l('巴西','Brazilian'),
								'Brief'   => l('巴西','Brazilian'),
								'Phone'   => '',
								'Email'   => 'brasil@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Brazilian',
							),
							array(
								'Name' 	  => l('美国','America'),
								'Brief'   => l('美国','America'),
								'Phone'   => '',
								'Email'   => 'usa@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'America',
							),
							array(
								'Name' 	  => l('加拿大','Canada'),
								'Brief'   => l('加拿大','Canada'),
								'Phone'   => '',
								'Email'   => 'usa@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Canada',
							),
							array(
								'Name' 	  => l('新西兰','New Zealand'),
								'Brief'   => l('新西兰','New Zealand'),
								'Phone'   => '',
								'Email'   => 'australia@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Newzealand',
							),
							array(
								'Name' 	  => l('阿根廷','Argentina'),
								'Brief'   => l('阿根廷','Argentina'),
								'Phone'   => '',
								'Email'   => 'argentina@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Argentina',
							),
							array(
								'Name' 	  => l('墨西哥','Mexico'),
								'Brief'   => l('墨西哥','Mexico'),
								'Phone'   => '',
								'Email'   => 'mexico@support.chenhsong.com',
								'Address' => '',
								'Picture' => '',
								'Class'   => 'Mexico',
							),
						);
					?>
					<div class="address">
						<?php foreach((array)$branch as $k => $v){?>
							<div class="add add<?=$k+1?> <?=$v['Class']; ?> absolute">
								<div class="cont pointer">
									<div class="item flex-middle2 <?=$v['IsLeft']?'txt_left':''?>">
										<div class="icon m-pic">
											<img src="/images/icon/address.png" class="i1" alt="">
											<img src="/images/icon/address2.png" class="i2 hide" alt="">
										</div>
										<div class="add_name trans nowrap"><?=$v['Name']?></div>
									</div>
									<div class="hide">
										<!-- <div class="img m-pic">
											<img src="/images/ind-branch.jpg" alt="">
										</div> -->
										<div class="txt1"><?=$v['Brief']?></div>
										<!-- <div class="txt2"><?//=l('电话','Phone'); ?>：<?//=$v['Phone']?></div> -->
										<div class="txt3"><?=l('邮箱','Email'); ?>：<?=$v['Email']?></div>
										<!-- <div class="txt4"><?//=l('地址','Address'); ?>：<?//=$v['Address']?></div> -->
									</div>
								</div>
							</div>
						<?php }?>
					</div>
					<!-- 信息盒子 -->
					<div class="box absolute">
						<div class="box_cont flex-middle2 relative">
							<!-- <div class="box_left">
								<div class="img relative m-pic">
									<img src="" class="absolute max" alt="">
								</div>
							</div> -->
							<div class="box_right">
								<div class="add_tit txt1"></div>
								<!-- <div class="add_txt txt2"></div> -->
								<div class="add_txt txt3"></div>
								<!-- <div class="add_txt txt4"></div> -->
							</div>
							<div class="close pointer absolute m-pic">
								<img src="/images/ind_map_close.svg" class="svg trans" alt="">
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</section>
	
	<div class="ind_box2">
		<? // 我们的责任 ?>
		<section id="ind_duty">
			<div class="cw1680">
				<div class="top">
					<div class="tit" wow="fadeInUp"><?=nl2br($ind_duty[ln('Name')]); ?></div>
					<div class="txt" wow="fadeInUp"><?=nl2br($ind_duty[ln('BriefDescription')]); ?></div>
				</div>

				<div class="cont relative" wow="fadeInUp">
					<div class="item swiBox relative">
						<div class="pn m-pic pointer absolute trans prev">
							<img src="/images/icon/prev.svg" class="svg trans" alt="">
						</div>
						<div class="container main" loading mousewheel page="none" delay="10s" speed='3' view="1" thumbs="#ind_duty .cont .thumbs" prev="#ind_duty .cont .item .prev" next="#ind_duty .cont .item .next">
							<div class="wrapper">
								<?php foreach((array)$ind_duty_list as $k => $v) {
									$back1 = img::get($v['Pictures']);
									?>
									<div class="slide" style="background-image: url(<?=$back1?$back1:"/images/dutybg.jpg";?>);">
										<div class="text">
											<div class="name"><?=$v['Name']; ?></div>
											<div class="brief"><?=nl2br($v['Brief']); ?></div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="pn m-pic pointer absolute trans next">
							<img src="/images/icon/next.svg" class="svg trans" alt="">
						</div>
					</div>
					<div class="tab absolute">
						<div class="container thumbs" view="3" space="23" page="none" loading abserver>
							<div class="wrapper flex-center">
								<?php foreach((array)$ind_duty_list as $k => $v) {?>
								<div class="slide"><?=$v['Name']; ?></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		
		<? // 新闻 ?>
		<section id="ind_news">
			<div class="cw1680">
				<div class="top flex-between flex-bottom2" wow="fadeInUp">
					<div class="tit"><?=l('媒体中心','Media Center'); ?></div>

					<div class="tab flex" tab="{hover:}" to="#ind_news .bind">
						<?php foreach((array)$blog_cate as $k => $v) {?>
							<a href="<?=url::set($v, 'wb_blog.list'); ?>" class="li cur"><?=$v[ln('Name')]; ?></a>
						<?php }?>
					</div>
				</div>
				<div class="bind" wow="fadeInUp">
					<?php foreach((array)$blog_cate as $k => $v) {
						$ind_blog = db::get_limit('wb_blog',"Language = '{$c['lang']}' and wb_blog_category_id = '{$v['Id']}' and IsSaleOut != 1 and IsIndex = 1",'*','MyOrder asc,AddTime desc',0,8);
						?>
						<div class='container <?=$k==0?'':'hide'?>' view="4" h5="{321:{view:1},751:{view:3},1025:{view:4}}" observer observeParents space="26" loading>
							<div class='wrapper'>
								<?php foreach((array)$ind_blog as $k1 => $v1){
									$url = $v1['Url'] ? $v1['Url'] : url::set($v1, 'wb_blog.detail');
									$pic = str::json($v1['Pictures'], 'decode');
									?>
									<div class="slide b-pic">
										<div class="pic relative i-pic">
											<a href="<?=$url; ?>" <?=$v1['Url'] ?"target='_blank'":''; ?> class="absolute max i-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="absolute max"/></a>

											<?php if(img::get($v1['Video'])){ ?>
												<div class="play trans5 absolute m-pic pointer" ly-video src="<?=img::get($v1['Video']); ?>">
													<img src="/images/icon/play.svg" class="svg trans" alt="<?=$v1['Name']?>" />
												</div>
											<?php }?>
										</div>
										<div class="item trans">
											<a href="<?=$url; ?>" <?=$v1['Url'] ?"target='_blank'":''; ?> class="name block trans text-line2"><?=$v1['Name']?></a>
											<div class="brief trans text-line2"><?=$v1['BriefDescription']?></div>
											<div class="time trans"><?=date('Y.m.d', (int)$v1['AddTime']); ?></div>
										</div>
									</div>
								<?php }?>
							</div>
						</div>
					<?php }?>
				</div>
			</div>
		</section>
	</div>

	<i class="ind_line block cw1680"></i>
	
	<div class="ind_box3">
		<section id="ind_partner">
			<div class="cw1680">
				<div class="tit" wow="fadeInUp"><?=$ind_custom[ln('Name')]; ?></div>
				<div class="list over" wow="fadeInUp">
					<div class="li aniLeft">
						<?php foreach((array)$ind_custom_logo as $k => $v) {?>
							<a href="<?=$v['url']?$v['url']:'javascript:;';?>" class="slide inline-block">
								<span class="img m-pic">
									<img class="inline-block" src="<?=img::get($v['path']);?>" alt="<?=$v[ln('alt')]; ?>" title="<?=$v[ln('title')]; ?>"/>
								</span>
							</a>
						<?php }?>
					</div>
				</div>
			</div>
		</section>

		<i class="ind_line block cw1680"></i>
		
		<section id="ind_join" class="over">
			<div class="cw1680">
				<div class="cont flex-between flex-middle2">
					<div class="left" wow="fadeInUp">
						<div class="tit"><?=$ind_join[ln('Name')]; ?></div>
						<div class="brief"><?=nl2br($ind_join[ln('BriefDescription')]); ?></div>
					</div>
					<div class="right" wow="fadeInUp">
						<div class="list flex-between">
							<?php foreach((array)$ind_join_data as $k => $v) {?>
							<a href="/contact#contact_three" class="li trans flex-max2">
								<div class="icon m-pic">
									<img src="<?=img::get($v['icon']); ?>" class="svg trans" alt="" />
								</div>
								<div class="txt trans"><?=$v[ln('name')]; ?></div>
							</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<i class="ind_line block cw1680"></i>
	
	<?php include 'inc/footer.php'; ?>
	
</body>
</html>