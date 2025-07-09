<?php
// 服务&支持 - 服务易
// 防止胡乱进入
isset($c) || exit;

$navId = 'service';
$navTwoId = 'service';
$navThreeId = 'service';
$footer_back = 'white';
$seo = db::seo('service');

$server = db::get_one('wb_server_contact',"1",'*');
$server_pic = str::json($server['Picture'], 'decode');

$server_data = str::json($server['Data'], 'decode');

$server_data2 = str::json($server['Data2'], 'decode');

$server_pic2 = str::json($server['Pictures'], 'decode');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="service">
        <div class="cw1600">
            <div class="partOne">
                <div id="ser_tit">
                    <div class="tit text-center"><?=nl2br($server[ln('Name')]); ?></div>
                </div>

                <div class="cont relative">
                    <div class='item flex relative'>
                        <div class="left">
                            <div class="in">
                                <div class="box">
                                    <div class="name" wow="fadeInUp"><?=l('服务热线','Service Hotline');?></div>
                                    <div class="phone" wow="fadeInUp"><?=nl2br($server[ln('Phone')]); ?></div>
                                    <div class="brief" wow="fadeInUp"><?=nl2br($server[ln('BriefDescription')]); ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="pic absolute m-pic" wow="fadeInLeft">
                            <img src="<?=img::get($server_pic[0]['path']);?>" alt="<?=$server_pic[0]['alt']; ?>"  title="<?=$server_pic[0]['title']; ?>" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="partTwo">
                <div id="ser_tit">
                    <div class="tit text-center"  wow="fadeInUp"><?=nl2br($server[ln('Name2')]); ?></div>
                    <div class="txt text-center"  wow="fadeInUp"><?=nl2br($server[ln('BriefDescription2')]); ?></div>
                </div>

                <div class="ul flex-between">
                    <?php foreach((array)$server_data as $k => $v) {?>
                        <div class="li" wow="fadeInUp">
                            <div class="icon m-pic"><img src="<?=img::get($v['icon']); ?>" alt="<?=$v[ln('name')]; ?>" /></div>
                            <div class="info">
                                <div class="tit text-center"><?=$v[ln('name')]; ?></div>
                                <div class="brief text-center"><?=nl2br($v[ln('brief')]); ?></div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>

            <div class="partThree">
                <div id="ser_tit">
                    <div class="tit text-center"  wow="fadeInUp"><?=nl2br($server[ln('Name3')]); ?></div>
                </div>

                <div class="cont">
                    <div class="pic relative over i-pic"><img class="absolute max" src="<?=img::get($server_pic2[0]['path']);?>" alt="<?=$server_pic2[0]['alt']; ?>"  title="<?=$server_pic2[0]['title']; ?>" /></div>

                    <div class="list">
                        <div class="ul flex-center">
                            <?php foreach((array)$server_data2 as $k => $v){?>
                                <div class="li"  wow="fadeInUp">
                                    <div class="num relative text-center"><span ly-number-roll><?=$v[ln('unit')]['number']; ?></span><?=$v[ln('unit')]['unit']; ?></div>

                                    <div class="brief text-center" wow="fadeInUp"><?=nl2br($v[ln('name')]); ?></div>
                                </div>
                            <?php }?>
                        </div>

                        <!-- <div class="tip text-center"><?//=l('注：不可抗力原因除外','Note: Excluding force majeure reasons'); ?></div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

	<?php include 'inc/contact_form.php'; ?>
	<?php include 'inc/footer.php'; ?>
	
    
</body>
</html>