

<?php 
if(server::mobile()){
    $service_mobile_list = g('wb_service_mobile.list');
    $new_service_mobile_list = array();
    foreach ($service_mobile_list as $k => $v) {
        if ($v['open']) {
            $new_service_mobile_list[$k] = $v;
        }
    }
    if ($new_service_mobile_list) {
?>

    <link rel="stylesheet" href="/themes/__/service_mobile/css/01.css">

    <section class="flex" id="footer_fload_01">
        <?php if ($new_service_mobile_list['home']) { ?>
            <a class="li flex-1 flex-btn" href="/">
                <span class="icon lyicon-home"></span>
                <span class="name">首页</span>
            </a>
        <?php } ?>
        <?php if ($new_service_mobile_list['tel']) { ?>
            <a class="li flex-1 flex-btn" href="tel:<?=$new_service_mobile_list['tel']['phone']?>">
                <span class="icon lyicon-telephone"></span>
                <span class="name">拨打电话</span>
            </a>
        <?php } ?>
    </section>

<?php 
    } 
}
?>