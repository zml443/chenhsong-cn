<?php
// 关于我们-投资者关系-汇总
// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$navTwoId = 'invest';
$footer_back = 'white';
$seo = db::seo('invest');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="invest_one">
        <div class="cont flex-between cw1600">
            <?php foreach((array)$nav[$navId]['children'][8]['children'] as $k => $v) {
                if($k>2){continue;}
            ?>
            <a href="<?=$v['href']; ?>" class="item block b-pic" wow="fadeInUp">
                <div class="pic relative over i-pic"><img class="absolute max" src="<?=$v['pic']?>" /></div>

                <div class="info">
                    <div class="tit text-center trans"><?=$v['name']; ?></div>
                    <div class="more flex-max2 trans">
                        <?=l('了解更多','Learn More'); ?>
                        <div class="icon m-pic trans"><img class="svg trans" src="/images/about/invest/jt2.svg" /></div>
                    </div>
                </div>
            </a>
            <?php }?>
        </div>
    </section>

    <section id="invest_two">
        <div class="cont flex-wrap flex-between cw1600">
            <?php 
            $count = 0;
            foreach((array)$nav[$navId]['children'][8]['children'] as $k => $v) {
                if ($count < 3){
                    $count++;
                    continue;
                }
                if($k>6){continue;}
                $where = "Language = '{$c['lang']}' and IsSaleOut != 1 and wb_type_id = '{$v['Id']}'";
                $list = db::get_limit('wb_invest_announcements', $where." and IsHot = 1", "*", 'MyOrder asc, AddTime desc',0,3);
                if(!$list){
                    $list = db::get_limit('wb_invest_announcements', $where, "*", 'MyOrder asc, AddTime desc',0,3);
                }
            ?>
            <div class="box">
                <div class="top">
                    <div class="title"><?=$v['name']; ?></div>
                    <i> | </i>
                    <a href="<?=$v['href'];?>" class="a trans"><?=l('查看更多','View More'); ?></a>
                </div>

                <div class="list over">
                    <?php foreach((array)$list as $k1 => $v1) {?>
                        <div class="item trans flex-middle2 flex-between" wow="fadeInUp">
                            <div class="time">
                                <div class="day trans text-center"><?=date('d', (int)$v1['AddTime']); ?></div>
                                <div class="year trans text-center"><?=date('Y.m', (int)$v1['AddTime']); ?></div>
                            </div>

                            <a href="<?=img::get($v1['File']); ?>" target="_blank" class="name block trans">
                                <div class="txt <?=server::mobile(1)?'':'text-line2';?>"><?=$v1['Name']; ?></div>
                            </a>

                            <a href="<?=img::get($v1['File']); ?>" target="_blank" class="down flex-max2 trans">
                                <div class="icon m-pic trans"><img class="svg" src="/images/about/invest/down.svg" /></div>
                                <div class="txt text-center">PDF</div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php }?>
        </div>
    </section>

    <section id="invest_three">
        <div class="cont flex-between cw1600">
            <?php 
            $count = 0;
            foreach((array)$nav[$navId]['children'][8]['children'] as $k => $v) {
                if ($count < 7){
                    $count++;
                    continue;
                }
                $pic = str::json($v['icon'], 'decode');
            ?>
            <a href="<?=$v['href'];?>" class="box trans" wow="fadeInUp">
                <div class="icon m-pic trans">
                    <img class="i1" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0][ln('alt')]; ?>"  title="<?=$pic[0][ln('title')]; ?>" />
                    <img class="i2" src="<?=img::get($pic[1]['path']);?>" alt="<?=$pic[1][ln('alt')]; ?>"  title="<?=$pic[1][ln('title')]; ?>" />
                </div>

                <div class="txt relative">
                    <div class="title text-center text-over"><?=$v['name']; ?></div>
                    <?php if($v['tip']) {?>
                    <div class="tip absolute max text-center">(<?=$v['tip']; ?>)</div>
                    <?php }?>
                </div>

                <div class="more flex-max2 trans">
                    <?=l('了解更多','Learn more'); ?>
                    <div class="jt m-pic trans"><img class="svg trans" src="/images/about/invest/jt2.svg" /></div>
                </div>
            </a>
            <?php }?>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>
<script>
</script>