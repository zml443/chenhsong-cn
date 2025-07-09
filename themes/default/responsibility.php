<?php
// 关于我们-社会责任
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'responsibility';
$footer_back = 'white';
$seo = db::seo('responsibility');

$about_resp = db::get_all('wb_about_responsibility', "Language = '{$c['lang']}'", "*", 'MyOrder asc, AddTime desc');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="responsibility">
        <div class="list">
            <?php foreach((array)$about_resp as $k => $v){
                $back = str::json($v['Pictures'], 'decode');
                if(server::mobile(1)){
                    $back1 = img::get($back[1]['path']);
                }else{
                    $back1 = img::get($back[0]['path']);
                }
                $url = url::set($v, 'wb_about_responsibility.detail');
                ?>
                <div class="item over" style="background-image: url(<?=$back1; ?>);">
                    <div class="box cw1600">
                        <div class="in">
                            <div class="tit"  wow="fadeInUp"><?=$v['Name']; ?></div>
                            <div class="info" wow="fadeInUp"><?=nl2br($v['BriefDescription']); ?></div>
                            <a href="<?=$v['Url']?$v['Url']:$url;?>" <?=$v['Url']?"target='_blank'":'';?> class="btn trans text-center upper" wow="fadeInUp">
                                <?=l('了解详情','Learn More')?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>
<script>
</script>