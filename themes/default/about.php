<?php

// 防止胡乱进入
isset($c) || exit;

$navId = $navTwoId = 'about';
$footer_back = 'white';
$seo = db::seo('about');

$about = db::get_one('wb_about',"1",'*');
$about_data = str::json($about['Data'], 'decode');
$about_video = str::json($about[ln('Pictures')], 'decode');

$about_intro = db::get_all('wb_about_director', "1", "*", 'MyOrder asc, Id asc');

$about_charity = db::get_one('wb_about_charitable',"1",'*');
$about_charity_pic = str::json($about_charity['Picture'], 'decode');
$about_charity_pic2 = str::json($about_charity['Pictures'], 'decode');

$about_cate = db::get_all('wb_about_category', "1", "*", 'MyOrder asc, AddTime desc');

$about_culture = db::get_one('wb_about_culture',"1",'*');
$about_culture_data = str::json($about_culture['Data'], 'decode');
$about_culture_pic = str::json($about_culture['Pictures'], 'decode');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>

	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="about_one" class="over">
        <div class="cw1600">
            <div class="partOne flex-between flex-middle2">
                <div class="left" wow="fadeInLeft">
                    <div id="about_tit" class="tit" ><?=nl2br($about[ln('Name')]); ?></div>
                    <div class="brief"><?=nl2br($about[ln('BriefDescription')]); ?></div>
                </div>

                <div class="right flex-wrap flex-between" wow="fadeInRight">
                    <?php foreach((array)$about_data as $k => $v) { ?>
                        <div class="li">
                            <div class="icon m-pic"><img src="<?=img::get($v['icon']); ?>" /></div>
                            <div class="num"><span ly-number-roll><?=$v[ln('unit')]['number']; ?></span><?=$v[ln('unit')]['unit']; ?></div>
                            <div class="txt"><?=$v[ln('name')]; ?></div>
                        </div>
                    <?php }?>
                </div>
            </div>

            <?/*?>
            <?php if(img::get($about_video[0]['path'])) { ?>
                <div class="partTwo over relative pointer" ly-video src="<?=img::get($about_video[0]['path']); ?>" wow="fadeInUp">
            <?php } else {?>
                <div class="partTwo over relative pointer" wow="fadeInUp">
            <?php }?>
                    <div class="pic relative i-pic over">
                        <img class="absolute max" src="<?=img::get($about_video[0]['pic']); ?>" alt="<?=$about_video[0]['alt']?>" title="<?=$about_video[0]['title']?>" />
                    </div>
                    <?php if(img::get($about_video[0]['path'])) { ?>
                    <div class="play absolute m-pic"><img src="/images/about/play.png" /></div>
                    <?php }?>
                </div>
            <?*/?>
            
            <?php if(img::get($about_video[0]['path'])) { ?>
                <div class="partTwo over relative pointer" wow="fadeInUp">
                    <div class="pic relative max i-pic over">
                        <img class="absolute max" src="<?=img::get($about_video[0]['pic']); ?>" alt="<?=$about_video[0]['alt']?>" title="<?=$about_video[0]['title']?>" />
                    </div>
                    
                    <div class="play absolute m-pic"><img src="/images/about/play.png" /></div>

                    <div class="video m-pic flex-max2 hide">
                        <video maxw maxh src="<?=img::get($about_video[0]['path']); ?>" controls muted autoplay loop webkit-playsinline="true" playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>
                    </div>

                </div>
            <?php } else { ?>
                <div class="partTwo over relative pointer" wow="fadeInUp">
                    <div class="pic relative i-pic over">
                        <img class="absolute max" src="<?=img::get($about_video[0]['pic']); ?>" alt="<?=$about_video[0]['alt']?>" title="<?=$about_video[0]['title']?>" />
                    </div>
                </div>
            <?php }?>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('#about_one .partTwo .play').click(function() {
                $(this).hide();
                $(this).siblings('.pic').hide();
                $(this).siblings('.video').css('display', 'flex');
                $('video').get(0).play();
            });
        });
    </script>

    <section id="about_two" class="over">
        <?php foreach((array)$about_intro as $k => $v) {
            $pic = str::json($v['Pictures'], 'decode');
            $url = url::set($v,'wb_about_director.detail');
        ?>
            <div class="item over" wow="fadeInUp">
                <div class="box flex-between flex-middle2 cw1600">
                    <div class="info">
                        <div class="p1"><span><?=$v[ln('Name')]; ?></span>&nbsp;<?=$v[ln('Job')]; ?></div>
                        <div class="p2"><?=nl2br($v[ln('Brief')]); ?></div>
                        <div class="p3"><?=nl2br($v[ln('BriefDescription')]); ?></div>
                        <a href="<?=$url; ?>" class="more text-center trans"><?=l('了解更多','Learn More')?></a>
                    </div>

                    <div class="pic relative over m-pic">
                        <img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0][ln('alt')]; ?>"  title="<?=$pic[0][ln('title')]; ?>" />
                    </div>
                </div>
            </div>
        <?php }?>
    </section>

    <section id="about_charity" class="over" style="background-image: url(<?=img::get($about_charity_pic2[0]['path']); ?>);">
        <div class="cw1600">
            <div class="in">
                <div class="logo relative m-pic" wow="fadeInUp">
                    <img class="absolute max" src="<?=img::get($about_charity_pic[0]['path']); ?>" alt="<?=$about_charity_pic[0][ln('alt')]?>" title="<?=$about_charity_pic[0][ln('title')]?>" />
                </div>
                <div class="info">
                    <div class="name" wow="fadeInUp"><?=nl2br($about_charity[ln('Name')]); ?></div>
                    <div class="brief" wow="fadeInUp"><?=nl2br($about_charity[ln('BriefDescription')]); ?></div>
                    <?php if($about_charity[ln('Url')]) {?>
                    <a href="<?=$about_charity[ln('Url')];?>" target="_blank" class="more text-center trans" wow="fadeInUp"><?=l('了解更多','Learn More')?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <section id="about_history" class="flex-between over">
        <div class="left">
            <div id="about_tit" class="tit" ><?=nl2br($about[ln('Name2')]); ?></div>
            <div class="txt" wow="fadeInUp"><?=nl2br($about[ln('BriefDescription2')]); ?></div>
            <div class="ul over" wow="fadeInUp">
                <div class="container" page="none" h5='{750:{view:auto,space:14},1024:{view:7,space:14},1366:{view:7,space:14}}' <?=server::mobile(1) ?'':'vertical'; ?> loading>
                    <div class='wrapper' tab="{}" to="#about_history .bind">
                        <?php
                        $last_key = count((array)$about_cate) - 1;
                        foreach((array)$about_cate as $k => $v){
                            $class = ($k == $last_key) ? 'cur' : '';
                        ?>
                            <div class='slide pointer <?=$class?>'><?=$v['Name']; ?></div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="btn_ul pc flex-middle2" wow="fadeInUp">
                <div class="pn prev m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
				<div class="pn next m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
            </div>
        </div>

        <div class="right bind over" wow="fadeInUp">
            <?php
            $hisCount=0;
            foreach((array)$about_cate as $k => $v){
                    $about_his = db::get_all('wb_about_history', "wb_year_id = '{$v['Id']}' and Language = '{$c['lang']}'", "*", 'MyOrder asc, AddTime desc');
                ?>
                <div class="swiBox swi<?=$k;?>">
                    <div class="container" loading <?=$hisCount>=1?'observer':''?> observeParents page="none" view="2"
                        h5='{750:{view:1,space:20},1024:{view:2,space:30},1366:{view:2,space:51}}'
                        prev="#about_history .prev" next="#about_history .next">
                        <div class='wrapper'>
                            <?php foreach((array)$about_his as $k1 => $v1) {
                                $pic = str::json($v1['Pictures'], 'decode');
                            ?>
                            <div class='slide'>
                                <div class="info">
                                    <div class="year"><?=$v1['Name']; ?></div>
                                    <div class="brief"><?=nl2br($v1['BriefDescription']); ?></div>
                                </div>
                                <div class="pic relative i-pic over">
                                    <img class="absolute max" src="<?=img::get($pic[0]['path']); ?>" alt="<?=$pic[0]['alt']?>" title="<?=$pic[0]['title']?>" />
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            <?php $hisCount++; }?>
        </div>
        <div class="btn_ul mobile flex-middle2" wow="fadeInUp">
            <div class="pn prev m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
            <div class="pn next m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
        </div>
    </section>

    <section id="about_honor" >
        <div class="cw1600">
            <div class="top flex-between flex-middle2" wow="fadeInUp">
                <div id="about_tit" class="tit"><?=nl2br($about[ln('Name3')]); ?></div>
                
                <div id="sel_ind" class="selectBox">
                    <div class="select relative">
                        <div class="inp tit1 pointer trans">
                            <?=l('根据年份查看','View by year'); ?>
                        </div>

                        <div class="two_box hide">
                            <div class="cont trans" tab="{}" to="#about_honor .bind" fn="change_fun">
                                <?php foreach((array)$about_cate as $k => $v){
                                    $about_honor = db::get_all('wb_about_honor', "wb_year_id = '{$v['Id']}'", "*", 'MyOrder asc, Id asc');
                                    if(!$about_honor){continue;}
                                    ?>
                                    <div class="li pointer trans"><?=$v['Name']; ?></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="over">
            <div class="cw1600">
                <div class="content bind">
                    <?php 
                    $hisCount=0;
                    foreach((array)$about_cate as $k => $v){
                        $about_honor = db::get_all('wb_about_honor', "wb_year_id = '{$v['Id']}'", "*", 'MyOrder asc, Id asc');
                        if(!$about_honor){continue;}
                    ?>
                        <div class="cont cont<?=$k;?>" wow="fadeInUp">
                            <div id="honSwi" class="container" loading observeParents center loop page="none" fn="__swiper_"
                                h5='{750:{view:auto},1024:{view:3},1450:{view:3.5}}' 
                                prev="#about_honor .cont<?=$k;?> .prev" 
                                next="#about_honor .cont<?=$k;?> .next"
                                >
                                <div class="wrapper">
                                    <?php foreach((array)$about_honor as $k1 => $v1){
                                        $pic = str::json($v1['Pictures'], 'decode');
                                    ?>
                                        <div class="slide trans">
                                            <div class="box trans">
                                                <div class="img m-pic relative trans">
                                                    <img class="absolute max trans" src="<?=img::get($pic[0]['path']); ?>" alt="<?=$pic[0][ln('alt')]?>" title="<?=$pic[0][ln('title')]?>" />
                                                </div>
                                                <div class="text text-center trans"><?=$v1[ln('Name')]; ?></div>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>

                            <?php if($about_honor) {?>
                            <div class="btn_ul flex-max2">
                                <div class="pn prev m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
                                <div class="pn next m-pic trans"><img src="/images/factory/pn.svg" alt="" class="svg" /></div>
                            </div>
                            <?php }?>
                        </div>
                    <?php $hisCount++; }?>
                </div>
            </div>
        </div>
    </section>

    <script>
        var change_fun = {
            change:function(a,b){
                var index = b.index;
                var obj = $("#about_honor .bind .cont").eq(index).children('.container');
                $(obj).o('swiper').update(true); 
            }
        }
    </script>

	<?php
		if(server::mobile(1)) {
			$about_src = img::get($about_culture_pic[1]['path']);
			$about_alt = $about_culture_pic[1][ln('alt')];
			$about_title = $about_culture_pic[1][ln('title')];
		} else {
			$about_src = img::get($about_culture_pic[0]['path']);
			$about_alt = $about_culture_pic[0][ln('alt')];
			$about_title = $about_culture_pic[0][ln('title')];
		}
	?>
    <section id="about_culture" class="relative over" style="background: url(<?=$about_src; ?>) no-repeat center / 100% 100%;">
        <div class="cont absolute max">
            <div class="in cw1600 relative">
                <div class="tit_info">
                    <div id="about_tit" class="tit" wow="fadeInUp">
                        <?=nl2br($about_culture[ln('Name')]); ?>
                    </div>
                    <?php if($about_culture[ln('BriefDescription')]) {?>
                    <div class="about_brief" class="brief" wow="fadeInUp">
                        <?=nl2br($about_culture[ln('BriefDescription')]); ?>
                    </div>
                    <?php }?>
                </div>

                <div class="info flex-between">
                    <?php foreach((array)$about_culture_data as $k => $v) {?>
                        <div class="item" wow="fadeInUp">
                            <div class="title"><?=nl2br($v[ln('name')]); ?></div>
                            <div class="brief"><?=nl2br($v[ln('brief')]); ?></div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>

</body>
</html>
<!-- <script>
    $(document).on('click','#about_honor .top .selectBox .two_box .cont .li',function(){
        setTimeout(function(){
            $('#about_honor .content').find('.cont').each(function(){
                if($(this).hasClass('cur')) {
                    $(this).find('.container').attr('observer', '');
                }
            });
        }, 1000);
    });
</script> -->