<?php
// 关于我们-投资者关系-董事会成员
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'invest';
$navThreeId = 'board';
$footer_back = 'white';
$seo = db::seo('invest');

$invest_board = db::get_all('wb_invest_board', "1", "*", 'MyOrder asc, AddTime desc');

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

            <divc class="right-cont">
                <div id="invest_board" class="board over">
                    <div id="inv_title" class="title" wow="fadeInUp"><?=$nav[$navId]['children'][8]['children'][1]['name']; ?></div>

                    <div class="list">
                        <?php foreach((array)$invest_board as $k => $v){ ?>
                            <div class="item flex-between" wow="fadeInUp">
                                <div class="left">
                                    <div class="name"><?=nl2br($v[ln('Name')]);?></div>
                                    <?php if($v[ln('SubName')]) {?>
                                    <div class="job alias"><?=l('别名','Alias');?>：<?=nl2br($v[ln('SubName')]);?></div>
                                    <?php }?>
                                    <div class="job"><?=nl2br($v[ln('Brief')]);?></div>
                                    <i></i>
                                </div>

                                <div class="brief"><?=nl2br($v[ln('BriefDescription')]);?></div>
                            </div>
                        <?php }?>
                    </div>
                </div>

                <?php include 'inc/invest-contact.php'; ?>
            </divc>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>