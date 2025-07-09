<?php

// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'production';
$footer_back = 'white';
$seo = db::seo('production');

$production = db::get_one('wb_about_production', "1", '*');
$production_pic = str::json($production['Pictures'], 'decode');
$production_data = str::json($production['Data'], 'decode');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="production_info" class="flex-between flex-middle2 over">
        <div class="left flex-right"  wow="fadeInLeft">
            <div class="in">
                <div class="tit"><?=nl2br($production[ln('Name')]); ?></div>
                <div class="brief"><?=nl2br($production[ln('Brief')]); ?></div>
                <div class="info"><?=nl2br($production[ln('BriefDescription')]); ?></div>
            </div>
        </div>
        <div class="right relative over i-pic"  wow="fadeInRight"><img class="absolute max" src="<?=img::get($production_pic[0]['path']); ?>" alt="<?=$production_pic[0][ln('alt')]?>" title="<?=$production_pic[0][ln('title')]?>"  /></div>
    </section>

    <section id="production_framework" class="over">
        <div class="cw1600">
            <div id="about_tit" class="tit text-center"  wow="fadeInUp"><?=nl2br($production[ln('Name2')]); ?></div>

            <div class="cont">
                <div class="framework flex-between flex-middle2"  wow="fadeInUp">
                    <?php foreach((array)$production_data as $k => $v) { 
                        if($k == 0) {
                    ?>
                        <div class="item" >
                            <div class="p1"><?=$v['name_en']; ?></div>
                            <div class="p2"><?=c('lang')=='en'?'':$v['name_cn']; ?></div>
                            <div class="p3">
                                <?php 
                                $str = nl2br($v[ln('brief')]);
                                $lines = explode('<br />', $str);
                                foreach($lines as $line){
                                    echo "<div class='li'>$line</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <?php }?>
                    <?php }?>

                    <div class="pic relative over m-pic">
                        <img class="absolute max" src="/images/about/production/3.png" />
                    </div>

                    <?php foreach((array)$production_data as $k => $v) { 
                        if($k == 1) {
                    ?>
                        <div class="item item2">
                            <div class="p1"><?=$v['name_en']; ?></div>
                            <div class="p2"><?=c('lang')=='en'?'':$v['name_cn']; ?></div>
                            <div class="p3">
                                <?php 
                                $str = nl2br($v[ln('brief')]);
                                $lines = explode('<br />', $str);
                                foreach($lines as $line){
                                    echo "<div class='li'>$line</div>";
                                }
                                ?>
                            </div>
                        </div>
                        <?php }?>
                    <?php }?>
                </div>

                <div class="txt text-center"  wow="fadeInUp"><?=nl2br($production['SubName']); ?></div>
            </div>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>