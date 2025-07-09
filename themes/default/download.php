<?php
// 防止胡乱进入
isset($c) || exit;

$navId = 'media';
$navBanId = $navTwoId = 'download';
$footer_back = 'white';
$seo = db::seo('download');;

$CateId = (int)$_GET['cid'];

$where = "Language='{$c['lang']}'";
$CateId && $where .= " and wb_products_category_id = '{$CateId}'";

$pg = (int)$_GET['pg'];
$page_list = db::get_limit_page('wb_blog_download', $where,'*',db::get_order_by('new','wb_blog_download'),$pg, 8,
array(
	'prev' => '<div class="pn box trans m-pic l"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
	'next' => '<div class="pn box trans m-pic r"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
	)
);
if($pg>$page_list['total_page']){return false;}


// 表单地址
if(c('lang') == 'en') {
    $form_address = db::get_all('wb_address_country','Dept = 1','Name_en', 'MyOrder asc, Id asc');
}else{
    $form_address = db::get_all('wb_address','Dept = 1','Name_cn', 'MyOrder asc, Id asc');
}

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

    <!-- 下载专区 -->
    <section id="media-download">
        <div class="cw1600">

            <div class="choose">
                <div class="box trans <?=!$CateId?'cur':'';?>" wow='fadeInUp'><?=l('全部','ALL')?></div>
                <?php foreach((array)$nav['products']['children'] as $k => $v){
                    $url = url::set($v, 'wb_products_category.down');
                ?>
                    <a href="<?=$url; ?>#media-download" class="box block trans <?=$CateId == $v['Id']?'cur':'';?>" wow='fadeInUp'><?=$v['name'];?></a>
                <?php }?>
            </div>

			<div class="mobile">
				<div class="top">
					<div class="title trans"><?=l('下载专区','Download Zone')?></div>
					<div class="icon trans"><img src="/images/industry/pn.svg" alt="" class="svg" /></div>
				</div>
				<div class="out">
					<div class="info">
                        <?php foreach((array)$nav['products']['children'] as $k => $v){
                            $url = url::set($v, 'wb_products_category.down');
                        ?>
                            <div class="ul">
                                <a href="<?=$url; ?>#media-download" class="tit block trans <?=$CateId == $v['Id']?'cur':'';?>"><?=$v['name'];?></a>
                            </div>
                        <?php }?>
					</div>
				</div>
			</div>
            
            <?php if($page_list['row']) {?>
            <!-- 内容区 -->
            <div class="content">
                <?php foreach((array)$page_list['row'] as $k => $v){
                    $pic = str::json($v['Pictures'], 'decode');
                    ?>
                    <div onclick="file.down(<?=$v['Id']; ?>)"  class="box trans download-pup" wow='fadeInUp' file-download="" data-name="">
                        <div class="img m-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></div>
                        <div class="word">
                            <div class="name trans"><?=$v['Name']; ?></div>

                            <div class="icon m-pic trans">
                                <img src="/images/download/download.png" alt="">
                                <img src="/images/download/download_1.png" alt="">
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>

            <?php include 'inc/page.php';?>
            <?php } else { ?>
                <div class="not_tip blog" wow="fadeInUp"><?=l('暂时没有相关内容，敬请期待！','There is currently no relevant content, please stay tuned!');?></div>
			<?php }?>
        </div>
    </section>

    <?php include 'inc/blog-rel.php';?>
    <?php include 'inc/footer.php';?>
    <?php include 'inc/down-pop.php';?>
    
</body>
</html>