<?php
// 服务&支持 
// 防止胡乱进入
isset($c) || exit;

$navId = 'service';
$navTwoId = 'network';
$footer_back = 'white';
$seo = db::seo('network');

$service_layout = db::get_one('wb_server',"1",'*');
$service_layout_data = str::json($service_layout['Data'], 'decode');

$service_network = db::get_one('wb_server_network',"1",'*');
$service_network_data = str::json($service_network['Data'], 'decode');

$service_accessory = db::get_one('wb_server_accessory',"1",'*');
$service_accessory_pic = str::json($service_accessory['Picture'], 'decode');

$service_address = db::get_all('wb_server_address', '1', "*", 'MyOrder asc, Id asc');

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
    <section id="service_layout" class="over">
        <div class="one">
            <div class="cw1600">
                <div id="ser_tit"><div class="tit text-center"  wow="fadeInUp"><?=nl2br($service_layout[ln('Name')]); ?></div></div>

                <div class="brief text-center" wow="fadeInUp"><?=nl2br($service_layout[ln('BriefDescription')]); ?></div>

                <div class="jt trans m-pic">
                    <img class="svg" src="/images/service/jt2.png" />
                </div>
            </div>
        </div>

        <div class="two">
            <div class="cw1600">
                <div class="pic_swi relative" wow="fadeInUp">
                    <div class="container main" thumbs="#service_layout .thumbs" page="none" effect="fade" loading 
                    prev="#service_layout .two .pic_swi .prev"
                    next="#service_layout .two .pic_swi .next"
                    >
                        <div class="wrapper">
                            <?php foreach((array)$service_layout_data as $k => $v) {?>
                            <div class="slide relative">
                                <div class="pic relative over i-pic">
                                    <img class="absolute max" src="<?=img::get($v['pic']); ?>" alt="<?=$v[ln('title')]; ?>" />
                                </div>

                                <div class="text_box absolute max">
                                    <div class="name"><?=$v[ln('title')]; ?></div>
                                    <div class="brief"><?=nl2br($v[ln('brief')]); ?></div>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>

                    <div class="prev btn trans pointer m-pic absolute"><img class="svg" src="/images/service/prev.svg" /></div>
                    <div class="next btn trans pointer m-pic absolute"><img class="svg" src="/images/service/prev.svg" /></div>
                </div>

                <div class="name_swi container thumbs" view="5" space="45" page="none" loading wow="fadeInUp">
                    <div class="wrapper">
                        <?php foreach((array)$service_layout_data as $k => $v) {?>
                        <div class="slide text-center pointer trans"><?=$v[ln('title')]; ?></div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?*/?>

    <section id="service_network" class="over">
        <div class="cw1600">
            <div class="top">
                <div id="ser_tit">
                    <div class="tit" wow="fadeInUp"><?=nl2br($service_network[ln('Name')]); ?></div>
                </div>

                <div class="info flex-middle2 flex-between">
                    <div class="left"  wow="fadeInUp"><?=nl2br($service_network[ln('BriefDescription')]); ?></div>

                    <a href="/contact#contact_two" class="right flex-max2 trans"  wow="fadeInUp">
                        <span><?=l('联系全球分公司','Contact Global Branches'); ?></span>
                        <div class="icon m-pic"><img class="svg" src="/images/contact/jt.svg" /></div>
                    </a>
                </div>
            </div>

            <div class="box">
                <div class="cont relative">
                    <div class="map relative m-pic">
                        <img class="absolute max" src="/images/service/map2.png" />
                    </div>

                    <div class="add_ul absolute max">
                        <?php foreach((array)$service_address as $k => $v) { 
                            $data = str::json($v['Data'], 'decode');
                        ?>
                            <div class="add add<?=$k?> absolute">
                                <div class="one">
                                    <div class="name"><?=$v[ln('Name')]; ?></div>
                                    <div class="icon"></div>
                                </div>
                                <div class="two absolute hide">
                                    <div class="tit"><?=$v[ln('Name')]; ?></div>
                                    <div class="ul">
                                        <?php foreach((array)$data as $k1 => $v1) { ?>
                                            <div class="li trans"><?=$v1[ln('name')];?></div>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>

            <div class="data flex-center">
                <?php foreach((array)$service_network_data as $k => $v) {?>
                <div class="item"  wow="fadeInUp">
                    <div class="num flex-center"><span ly-number-roll><?=$v[ln('unit')]['number']; ?></span><?=$v[ln('unit')]['unit']; ?></div>
                    <div class="txt text-center"><?=$v[ln('name')]; ?></div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section> 

    <section id="service_accessory" class="over">
        <div class="cw1600">
            <div id="ser_tit">
                <div class="tit" wow="fadeInUp"><?=nl2br($service_accessory[ln('Name')]); ?></div>
            </div>

            <div class="brief" wow="fadeInUp"><?=nl2br($service_accessory[ln('BriefDescription')]); ?></div>

            <div class="pic relative over i-pic" wow="fadeInUp">
                <img class="absolute max" src="<?=img::get($service_accessory_pic[0]['path']);?>" alt="<?=$service_accessory_pic[0]['alt']; ?>"  title="<?=$service_accessory_pic[0]['title']; ?>" />
            </div>
        </div>
    </section>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>
<script>
    // $(document).on('hover','#service_network .cont .add_ul .add .one',function(){
    //     $(this).toggleClass('cur');
    //     $(this).parents('.add').toggleClass('cur');
    //     $(this).next('.two').slideToggle();
    // });
    $(document).ready(function(){
        $("#service_network .cont .add_ul .add .one").mouseenter(function(){
            // 鼠标移入
            $(this).toggleClass('cur');
            $(this).parents('.add').toggleClass('cur');
            $(this).next('.two').slideToggle();
        });
        $("#service_network .cont .add_ul .add .two").mouseleave(function(){
            // 鼠标移出
            $(this).prev('.two').toggleClass('cur');
            $(this).parents('.add').toggleClass('cur');
            $(this).slideToggle();
        });
    });
</script>