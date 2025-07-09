<?php
// 关于我们-先进技术
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'technology';
$footer_back = 'white';
$seo = db::seo('technology');

$tech = db::get_all('wb_about_technology', "1", '*','MyOrder asc, AddTime asc');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="technology">
        <div class="list">
            <?php foreach((array)$tech as $k => $v) {
                if($k>2){continue;}
                $pic = str::json($v['Pictures'], 'decode');
                ?>
                <div id="tech<?=$v['Id']; ?>" class="item over">
                    <div class="cw1600">
                        <div class="tit"  wow="fadeInUp"><?=$v[ln('Name')]; ?></div>
                        <div class="info" wow="fadeInUp">
                            <div class="brief1"><?=nl2br($v[ln('Brief')]); ?></div>
                            <div class="brief2"><?=nl2br($v[ln('BriefDescription')]); ?></div>
                        </div>
                        <div class="pic relative over i-pic" wow="fadeInUp"><img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>" title="<?=$pic[0]['title']; ?>" /></div>
                    </div>
                </div>
            <?php }?>
        </div>

        <?php 
        $last_key = count((array)$tech) - 1;
        foreach((array)$tech as $k => $v) {
            if($k == $last_key){
            $pic = str::json($v['Pictures'], 'decode');
            $data = str::json($v['Data'], 'decode');
        ?>
            <div class="box item">
                <div class="cw1600">
                    <div class="tit"  wow="fadeInUp"><?=$v[ln('Name')]; ?></div>
                    <div class="info"  wow="fadeInUp">
                        <div class="brief1"><?=nl2br($v[ln('Brief')]); ?></div>
                        <div class="brief2"><?=nl2br($v[ln('BriefDescription')]); ?></div>
                    </div>

                    <div class='swi2 container thumbs moblie' view="auto" space="40" page="none"  wow="fadeInUp">
                        <div class='wrapper'>
                            <?php foreach((array)$data as $k1 => $v1) { ?>
                                <div class='slide pointer'><?=$v1[ln('title')]; ?></div>
                            <?php }?>
                        </div>
                    </div>

                    <div class="cont over" style="background-image: url(<?=img::get($pic[0]['path']);?>);">
                        <div class='swi1 container' view="auto" page="none" effect="fade" thumbs="#technology .box <?=server::mobile(1)?".moblie":".pc"; ?>">
                            <div class='wrapper'>
                                <?php foreach((array)$data as $k1 => $v1) { ?>
                                    <div class='slide'>
                                        <div class="tit"  wow="fadeInUp"><?=$v1[ln('title')]; ?></div>
                                        <div class="ul">
                                            <div class="li"  wow="fadeInUp">
                                                <div class="p1"><?=$v1[ln('name')]; ?></div>
                                                <div class="p2"><?=nl2br($v1[ln('brief')]); ?></div>
                                            </div>
                                            <div class="li"  wow="fadeInUp">
                                                <div class="p1"><?=$v1[ln('name2')]; ?></div>
                                                <div class="p2"><?=nl2br($v1[ln('brief2')]); ?></div>
                                            </div>
                                            <div class="li"  wow="fadeInUp">
                                                <div class="p1"><?=$v1[ln('name3')]; ?></div>
                                                <div class="p2"><?=nl2br($v1[ln('brief3')]); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>

                        <div class='swi2 container thumbs pc' view="auto" space="40" page="none"  wow="fadeInUp">
                            <div class='wrapper'>
                                <?php foreach((array)$data as $k1 => $v1) { ?>
                                    <div class='slide pointer'><?=$v1[ln('title')]; ?></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <?php }?>
        <?php }?>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>
<script>
</script>