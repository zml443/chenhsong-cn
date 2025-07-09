<?php 
    $lang = db::get_all('wb_webhome_lang', '1', "*", 'MyOrder asc, Id asc');
?>
<section id="langouter" class="hidden">
    <div class="in cw1680 maxh">
        <div class="cont">
            <div class="tit"><?=l('选择区域/语言','Select Region/Language')?></div>
            <div class="list flex-wrap">
                <?php foreach((array)$lang as $k => $v){
                    $url = $v['Url']?$v['Url']:'javascript:;';
                    ?>
                    <a href="<?=$url; ?>" class="li trans <?//=$v['cur']?>"><?=$v['Name']?></a>
                <?php }?>
            </div>
            <a href="global.chenhsong.com" target="_blank" class="lang_en trans">Global - English</a>
        </div>
    </div>
</section>