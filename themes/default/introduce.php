<?php

// 防止胡乱进入
isset($c) || exit;

$navId = 'about';
$footer_back = 'white';
$seo = db::seo('about');

$Id = (int)$_GET['id'];
$info = db::get_one('wb_about_director', "Id = '{$Id}'", '*');
if(!$info){return false;}
$info_pic = str::json($info['Pictures'], 'decode');
$info_pic2 = str::json($info['Picture'], 'decode');

$intro = str::json($info['Data'], 'decode');
$history = str::json($info['Data2'], 'decode');
$eulogy = str::json($info['Data4'], 'decode');

$pg = (int)$_GET['pg'];
if($Id == 2){
    $count = 8;
}else{
    $count = 12;
}
$intro_list = db::get_limit_page('wb_about_list', "wb_director_id = '{$Id}'", '*', 'MyOrder asc, AddTime asc', $pg,  $count);
if($pg>$intro_list['total_page']){return false;}

$honor_list = db::get_all('wb_about_glory', "wb_director_id = '{$Id}'", '*', 'MyOrder asc, AddTime asc');
$service_list = db::get_all('wb_about_service', "wb_director_id = '{$Id}'", '*', 'MyOrder asc, AddTime asc');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <?/*?>
    <section id="about_two" class="intro over">
        <div class="item over" wow="fadeInUp">
            <div class="box flex-between flex-middle2 cw1600">
                <div class="info">
                    <div class="p1"><span><?=$info[ln('Name')]; ?></span>&nbsp;<?=$info[ln('Job')]; ?></div>
                    <div class="p2"><?=nl2br($info[ln('Brief')]); ?></div>
                    <div class="brief"><?=nl2br($info[ln('BriefDescription2')]); ?></div>
                </div>

                <div class="pic relative over m-pic">
                    <img class="absolute max" src="<?=img::get($info_pic[0]['path']);?>" alt="<?=$info_pic[0][ln('alt')]; ?>"  title="<?=$info_pic[0][ln('title')]; ?>" />
                </div>
            </div>
        </div>
    </section>
    <?*/?>

    <section id="intro_about" class="over">
        <div class="box flex-between flex-middle2 cw1600">
            <div class="info"  wow="fadeInLeft">
                <div class="p1"><span><?=$info[ln('Name')]; ?></span>&nbsp;<?=$info[ln('Job')]; ?></div>
                <div class="p2"><?=nl2br($info[ln('Brief')]); ?></div>
                <div class="p3"><?=nl2br($info[ln('BriefDescription2')]); ?></div>
            </div>

            <div class="pic relative over m-pic"  wow="fadeInRight">
                <img class="absolute max" src="<?=img::get($info_pic[0]['path']);?>" alt="<?=$info_pic[0][ln('alt')]; ?>"  title="<?=$info_pic[0][ln('title')]; ?>" />
            </div>
        </div>
    </section>

    <?php if(!empty($info[ln('Job2')]) && !empty($honor_list[0][ln('Name')]) && !empty($service_list[0][ln('Name')])) {?>
    <section id="intro_honor" class="over">
        <div class="cw1600">
            <div class="title" wow="fadeInUp"><?=l('个人荣誉','Personal Honor');?></div>

            <div class="box">
                <div class="list flex-between"  wow="fadeInUp">
                    <div class="left"><?=l('职位','Position');?></div>

                    <div class="right">
                        <div class="job"><?=nl2br($info[ln('Job2')]); ?></div>
                    </div>
                </div>

                <div class="list flex-between" wow="fadeInUp">
                    <div class="left"><?=l('荣誉','Honor');?></div>

                    <div class="right flex-wrap flex-between">
                        <?php 
                        foreach((array)$honor_list as $k => $v) {
                            $data = str::json($v['Data'], 'decode');
                        ?>
                        <div class="item">
                            <div class="name"><?=nl2br($v[ln('Name')]); ?></div>

                            <div class="ul">
                                <?php foreach((array)$data as $k1 => $v1) {?>
                                <div class="li flex-between">
                                    <div class="year"><?=nl2br($v1[ln('year')]); ?></div>
                                    <div class="brief"><?=nl2br($v1[ln('brief')]); ?></div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="list flex-between" wow="fadeInUp">
                    <div class="left"><?=l('社会服务','Social Services');?></div>

                    <div class="right flex-wrap flex-between">
                        <?php 
                        foreach((array)$service_list as $k => $v) {
                            $data = str::json($v['Data'], 'decode');
                        ?>
                        <div class="item">
                            <div class="name"><?=nl2br($v[ln('Name')]); ?></div>

                            <div class="ul">
                                <?php foreach((array)$data as $k1 => $v1) {?>
                                <div class="li flex-between">
                                    <div class="year"><?=nl2br($v1[ln('year')]); ?></div>
                                    <div class="brief"><?=nl2br($v1[ln('brief')]); ?></div>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php }?>

    <section id="intro" class="over">
        <div class="cw1600">
            <?php foreach((array)$intro as $k => $v) {?>
                <div class="item flex-between flex-middle2" wow="fadeInUp">
                    <div class="info">
                        <?php if($v[ln('name')]) {?>
                        <div class="title"><?=nl2br($v[ln('name')]); ?></div>
                        <?php }?>
                        <div class="brief"><?=nl2br($v[ln('txt')]); ?></div>
                    </div>

                    <div class="pic">
                        <div class="img m-pic over"><img src="<?=img::get($v['pic']); ?>" /></div>
                        <?php if($v[ln('pictxt')]) {?>
                        <div class="txt"><?=nl2br($v[ln('pictxt')]); ?></div>
                        <?php }?>
                    </div>
                </div>
            <?php }?>
        </div>
    </section>

    <?php // 生平 
        if(!empty($history[0][ln('name')])) {
    ?>
    <section id="intro_history" class="over">
        <div class="cw1600">
            <div id="about_tit" class="tit" wow='fadeInUp'><?=l('工业富民 民富国强','Industry enriches the people, the people are prosperous, and the country is strong')?></div>

            <div class="box container relative" wow='fadeInUp' page="none" h5="{1:{view:1},760:{view:1},1024:{view:2}}" loading="">
                <div class="wrapper">
                    <?php foreach ((array)$history as $k => $v) { ?>
                        <div class="li slide relative pointer">
                            <div class="icon absolute trans"></div>
                            <div class="line absolute"></div>
                            <div class="no trans"><?=($k+1)<10 ? '0'.($k+1):($k+1); ?></div>
                            <div class="title trans"><?=nl2br($v[ln('name')]); ?></div>
                            <div class="brief"><?=nl2br($v[ln('txt')]); ?></div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>
    <?php }?>

    <? // 历史列表  ?>
    <?php if($intro_list['row']) {?>
    <div>
    <section id="intro_list" class="over" <?=$Id == 2?"style='background: #f8f9fa;'":'';?> >
        <div class="cw1600">
            <div class="list flex-wrap"  wow='fadeInUp'>
                <?php foreach((array)$intro_list['row'] as $k => $v) { 
                    $pic = str::json($v['Pictures'], 'decode');
                ?>
                    <div class="item">
                        <div class="pic relative over i-pic pointer" image-show="组1|<?=img::get($pic[0]['path']);?>">
                            <img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0][ln('alt')]; ?>"  title="<?=$pic[0][ln('title')]; ?>" />
                        </div>
                        <div class="info flex">
                            <?php if($v['Year']) {?>
                            <div class="year"><?=$v['Year']; ?></div>
                            <?php }?>
                            <div class="title <?$v['Year']?'year':'';?>"><?=$v[ln('Name')]; ?></div>
                        </div>
                    </div>
                <?php }?>
            </div>

            <?php if($intro_list['total_page'] > 1){?>
                <div ajax-append="{page:<?=$intro_list['page']+1?>,total_page:<?=$intro_list['total_page']?>}" to="#intro_list .list" class="more flex-max2 trans pointer" wow='fadeInUp'>
                    <div class="txt trans"><?=l('加载更多','View More'); ?></div>
                    <div class="jt m-pic trans"><img class="svg" src="/images/about/introduce/more.svg" /></div>
                </div>
            <?php }?>
        </div>
    </section>
    </div>
    <?php } ?>

    <?php if(!empty($eulogy[0][ln('txt')])) {?>
        <?php if($info['IsPic'] == 1) {?>
            <section id="intro_eulogy" class="relative over flex-middle2 flex-between">
                <div class="left flex-left" wow='fadeInLeft'>
                    <div class="in"><?=nl2br($eulogy[0][ln('txt')]); ?></div>
                </div>

                <div class="right absolute">
                    <div class="pic_s absolute m-pic"><img src="<?=img::get($eulogy[0][ln('pic2')]); ?>" /></div>
                    <div class="pic_b absolute m-pic"><img src="<?=img::get($eulogy[0]['pic']); ?>" /></div>
                </div>
            </section>
        <?php } else {?>
            <section id="intro_info" class="over">
                <div class="cw1600">
                    <div class="cont text-center relative" wow='fadeInUp'><?=nl2br($eulogy[0][ln('txt')]); ?></div>
                </div>
            </section>
        <?php }?>
    <?php }?>

    <section id="intro_pic" class="relative over i-pic">
        <img class="absolute max" src="<?=img::get($info_pic2[0]['path']);?>" alt="<?=$info_pic2[0][ln('alt')]; ?>"  title="<?=$info_pic2[0][ln('title')]; ?>" />
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>