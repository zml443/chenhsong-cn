<?php
// 关于我们-投资者关系-创办人之言
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'invest';
$navThreeId = 'founder';
$footer_back = 'white';
$seo = db::seo('invest');

$founder = db::get_one('wb_invest_founder',"1",'*');
$founder_pic = str::json($founder['Pictures'], 'decode');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="invest">
        <div class="box flex-between cw1600">
            <div class="left-menu">
                <?php include 'inc/menu-invest.php'; ?>
            </div>
            <div class="right-cont">
                <div id="invest_founder" class="info over">
                    <div id="inv_title" class="title" wow="fadeInUp"><?=$nav[$navId]['children'][8]['children'][0]['name']; ?></div>

                    <div class="slogan" wow="fadeInUp"><?=nl2br($founder[ln('Name')]);?></div>

                    <div class="brief" wow="fadeInUp"><?=nl2br($founder[ln('Brief')]);?></div>

                    <div class="cont flex-between" wow="fadeInUp">
                        <div class="left">
                            <div class="text"><?=nl2br($founder[ln('BriefDescription')]);?></div>
                            <div class="text2 text-right"><?=nl2br($founder[ln('BriefDescription2')]);?></div>
                        </div>

                        <div class="pic relative over i-pic">
                            <img class="absolute max" src="<?=img::get($founder_pic[0]['path']); ?>" alt="<?=$founder_pic[0][ln('alt')]?>" title="<?=$founder_pic[0][ln('title')]?>" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>
<script>
</script>