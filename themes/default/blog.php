<?php
// 媒体中心
// 防止胡乱进入
isset($c) || exit;

$navId = 'media';
$navBanId = 'blog';
$footer_back = 'white';

$blog_cate = db::get_all('wb_blog_category', 'Dept = 1', "*", 'MyOrder asc, Id asc');
$CateId = (int)$_GET['bid']?$_GET['bid']:$blog_cate[0]['Id'];
$seo = db::seo('wb_blog_category',$CateId);

$where = "Language='{$c['lang']}' and IsSaleOut != 1";
$CateId && $where .= " and wb_blog_category_id = '{$CateId}'";

$hot_row = db::get_limit('wb_blog', $where.' and IsHot = 1', "*", 'MyOrder asc, AddTime desc',0,5);

$pg = (int)$_GET['pg'];
$page_list = db::get_limit_page('wb_blog', $where,'*',db::get_order_by('new','wb_blog'),$pg, 6,
array(
	'prev' => '<div class="pn box trans m-pic l"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
	'next' => '<div class="pn box trans m-pic r"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
	)
);
if($pg>$page_list['total_page']){return false;}

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body>
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?php include 'inc/menu.php'; ?>
	</div>	
	
	<section id="media-activity">
		<div class="cw1600">
			<?php if($hot_row) {?>
				<div class="hot" wow="fadeInUp">
					<div class='container word control' loop>
						<div class='wrapper'>
							<?php foreach((array)$hot_row as $k => $v ) {
								$url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
							?>
							<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class='slide block'>
								<div class="info">
									<div class="name text-line2 trans"><?=$v['Name']; ?></div>
									<div class="brief text-line3"><?=nl2br($v['BriefDescription']); ?></div>
								</div>
								<div class="bot">
									<div class="time"><?=date('Y.m.d', (int)$v['AddTime']); ?></div>
									<div class="btn trans m-pic"><img src="/images/industry/pn.svg" class="svg trans" alt="" /></div>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
					<div class='container img' loop control="#media-activity .control">
						<div class='wrapper'>
							<?php foreach((array)$hot_row as $k => $v ) {
								$url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
								$pic1 = str::json($v['Pictures'], 'decode');
								$pic2 = str::json($v['Picture'], 'decode');
								if($pic2){
									$pic = $pic2;
								}else {
									$pic = $pic1;
								}
							?>
								<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class='slide i-pic'><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></a>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			
			<?php if($page_list['row']) {?>
				<div class="content">
					<?php foreach((array)$page_list['row'] as $k => $v){
						$url = $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
						$pic = str::json($v['Pictures'], 'decode');
						?>
						<a href="<?=$url; ?>" <?=$v['Url'] ?"target='_blank'":''; ?> class="item block trans relative over"  wow="fadeInUp">
							<div class="bot">
								<div class="pic relative over">
									<div class="absolute max i-pic"><img class="trans" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" /></div>
								</div>

								<div class="info">
									<div class="name trans text-line2"><?=$v['Name']; ?></div>
									<div class="flex-between flex-middle2">
										<div class="time"><?=date('Y.m.d', (int)$v['AddTime']); ?></div>
										<div class="btn m-pic">
											<img src="/images/industry/pn.svg" class="svg trans" alt="" />
										</div>
									</div>
								</div>
							</div>
							<div class="top absolute max flex trans">
								<div class="one">
									<div class="name trans text-line2"><?=$v['Name']; ?></div>
									<div class="brief trans text-line4"><?=nl2br($v['BriefDescription']); ?></div>
								</div>

								<div class="flex-between flex-middle2">
									<div class="time"><?=date('Y.m.d', (int)$v['AddTime']); ?></div>
									<div class="btn m-pic">
										<img src="/images/industry/pn.svg" class="svg trans" alt="" />
									</div>
								</div>
							</div>
						</a>
					<?php }?>
				</div>

				<?php include 'inc/page.php';?>
			<?php } else { ?>
				<div class="cw1600">
					<div class="not_tip blog" wow="fadeInUp"><?=l('暂时没有相关内容，敬请期待！','There is currently no relevant content, please stay tuned!');?></div>
				</div>
			<?php }?>
		</div>
	</section>	

	<?php include 'inc/footer.php';?>
</body>
</html>