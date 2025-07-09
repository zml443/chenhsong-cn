<?php

// 防止胡乱进入
isset($c) || exit;

$navId = 'contact';
$footer_back = 'white';
$seo = db::seo('contact');

$contact_list = db::get_all('wb_contact', '1', "*", 'MyOrder asc, Id asc');

$contact_affiliate = db::get_all('wb_contact_affiliate', '1', "*", 'MyOrder asc, Id asc');
$contact_category = db::get_all('wb_contact_category', '1', "*", 'MyOrder asc, Id asc');

$contact_become = db::get_one('wb_contact_become', '1', "*");
$contact_become_pic = str::json($contact_become['Pictures'], 'decode');
$contact_become_data = str::json($contact_become['Data'], 'decode');

?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
	
	<?php include 'inc/header.php'; ?>

    <div class="menuBox relative">
	    <?php include 'inc/banner.php'; ?>
        <?php include 'inc/menu.php'; ?>
    </div>

    <section id="contact_one">
        <? // 总部 ?>
        <div class="headquarters">
            <?php foreach((array)$contact_list as $k => $v) {
                if($k>1){continue;}
                $pic = str::json($v['Pictures'], 'decode');
            ?>
                <div id="contact<?=$k+1;?>" class="box flex-between flex-middle2 over" wow="fadeInUp">
                    <div class="left flex-right">
                        <div class="in">
                            <div class="name"><?=$v[ln('Name')]; ?></div>
                            <div class="type"><?=$v[ln('Type')]; ?></div>

                            <div class="info">
                                <div class="li addr">
                                    <div class="p1"><?=l('联系地址','Address'); ?></div>
                                    <div class="p2"><?=$v[ln('Address')]; ?></div>
                                </div>
                                <div class="li phone">
                                    <div class="p1"><?=l('联系电话','Phone'); ?></div>
                                    <div class="p2"><?=$v['Phone']; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pic relative over i-pic">
                        <img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" />
                    </div>
                </div>
            <?php }?>
        </div>

        <div class="base_tit cw1600"><?=l('全球制造基地','Global manufacturing base'); ?></div>

        <? // 分公司 ?>
        <div id="base" class="list">
            <?php 
            $count = 0;
            foreach((array)$contact_list as $k => $v) {
                if ($count < 2) { $count++; continue; }
                $pic = str::json($v['Pictures'], 'decode');
            ?>
                <div class="ul" wow="fadeInUp">
                    <div class="box cw1600 flex-between flex-middle2">
                        <div class="left">
                            <div class="name"><?=$v[ln('Name')]; ?></div>
                            <div class="type"><?=$v[ln('Type')]; ?></div>

                            <div class="info">
                                <div class="li addr">
                                    <div class="p1"><?=l('联系地址','Address'); ?></div>
                                    <div class="p2"><?=$v[ln('Address')]; ?></div>
                                </div>
                                <div class="li phone">
                                    <div class="p1"><?=l('联系电话','Phone'); ?></div>
                                    <div class="p2"><?=$v['Phone']; ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="right relative i-pic over">
                            <img class="absolute max" src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" />
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </section>

    <section id="contact_two">
        <div class="cw1600">
            <div class="top flex-between flex-middle2" wow="fadeInUp">
                <div class="left flex-middle2">
                    <div class="tit"><?=l('全球分公司','Global Subsidiaries'); ?></div>

                    <div class="cateBox relative">
                        <div class="selBtn right flex-middle2 flex-between trans pointer">
                            <span><?=l('请选择','Please Select')?></span>
                            <div class="icon m-pic"><img class="svg" src="/images/contact/jt.svg" /></div>
                        </div>

                        <div class="two_box absolute hide">
                            <div class="two">
                                <div data-cid="0" class="li pointer trans"><?=l('请选择','Please Select'); ?></div>
                                <?php foreach((array)$contact_category as $k => $v) {?>
                                <div data-cid="<?=$v['Id']; ?>" class="li pointer trans"><?=$v[ln('Name')]; ?></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/service-network#service_network" class="right flex-max2 trans">
                    <span><?=l('查看全球服务网络','Global Service Network')?></span>
                    <div class="icon m-pic"><img class="svg" src="/images/contact/jt.svg" /></div>
                </a>
            </div>

            <div class="ajaxBox">
                <div class="list flex-wrap">
                    <?php foreach((array)$contact_affiliate as $k => $v) {?>
                    <div class="li" wow="fadeInUp">
                        <div class="name"><?=$v[ln('Name')]; ?></div>
                        <a href="mailto:<?=$v['Email']; ?>" class="email inline trans"><?=$v['Email']; ?></a>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>

    <section id="contact_three">
        <div class="cw1600">
            <div class="top flex-between flex-middle2" wow="fadeInUp">
                <div class="left"><?=$contact_become[ln('Name')]; ?></div>
            </div>

            <div class="cont">
                <div class="pic relative over i-pic"><img class="absolute max" src="<?=img::get($contact_become_pic[0]['path']); ?>" alt="<?=$contact_become_pic[0][ln('alt')]?>" title="<?=$contact_become_pic[0][ln('title')]?>" /></div>

                <div class="list flex-center">
                    <?php foreach((array)$contact_become_data as $k => $v) {?>
                    <div class="li trans">
                        <div class="p1 text-center"><?=$v[ln('txt')]; ?></div>
                        <div class="p2 text-center">
                            <div class="name"><?=c('lang')=='en'?$v['txt3']:$v['txt2']; ?></div>
                            <div class="name_en"><?=$v['txt4']; ?></div>
                        </div>
                        <div class="p3 text-center">
                            <div class="name"><?=$v[ln('phone')]; ?></div>
                            <div class="name_en"><?=$v['email']; ?></div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </section>

	<?php include 'inc/contact_form.php'; ?>

	<?php include 'inc/footer.php'; ?>
	
</body>
</html>