<?php
// 防止胡乱进入
isset($c) || exit;

$navId = 'industry';
$footer_back = 'white';

$pg = (int)$_GET['pg'];
$page_row = db::get_limit_page('wb_industry', "Language = '{$c['lang']}' and IsSaleOut != 1", '*', 'MyOrder asc, AddTime asc', $pg, 4);
if($pg>$page_row['total_page']){return false;}

?>
<!DOCTYPE html>
<html lang="zh-cn">
<?php include 'inc/style_script.php';?>
<body>
	<div>
	<?php include 'inc/header.php';?>
	
	<div class="menuBox relative">
		<?php include 'inc/banner.php'; ?>
		<?php include 'inc/menu.php'; ?>
	</div>	
	
	<!-- 行业列表 -->
	<section id="industry">
		<div class="box" wow='fadeInUp'>
			<?php foreach((array)$page_row['row'] as $k => $v){
				$url = url::set($v, 'wb_industry.detail');
				$pic = str::json($v['Picture'], 'decode');
			?>
				<div class="list trans">
					<div class="cw1600">
						<div class="word">
							<a href="<?=$url; ?>" class="name block"><?=$v['Name']; ?><?=l('行业方案',' Industry Solutions')?></a>
							<div class="brief"><?=nl2br($v['BriefDescription']); ?></div>
						</div>

						<div class="bot b-pic" >
							<div class="img i-pic">
								<img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" />
							</div>

							<a href="<?=$url; ?>" class="out block trans">
								<div class="btn"><?=l('了解详情','Learn More')?></div>
							</a>
						</div>
					</div>
				</div>
			<?php }?>
		</div>
		
		<?php if($page_row['total_page'] > 1){?>
			<div class="endBtn" wow='fadeInUp'>
				<div class="cw1600">
					<a href="" ajax-append="{page:<?=$page_row['page']+1?>,total_page:<?=$page_row['total_page']?>}" to="#industry .box" class="btn trans">
						<?=l('更多方案','More Options')?>
						<div class="icon m-pic"><img src="/images/industry/pn.svg" class="svg trans" alt="" /></div>
					</a>
				</div>
			</div>
		<?php }?>

	</section>

	<?php include 'inc/footer.php';?>
	</div>
</body>
</html>