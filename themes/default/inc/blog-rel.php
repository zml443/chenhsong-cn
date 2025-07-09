<?php
// 推荐产品
$rel_pro = db::get_limit('wb_products', "IsSaleOut != 1 and Language = '{$c['lang']}'", '*', 'MyOrder asc, AddTime desc',0,4);

// 推荐方案
$rel_ind = db::get_limit('wb_industry', "Language = '{$c['lang']}'", '*', 'MyOrder asc, AddTime asc',0,4);
?>

<section id="media-activity-recommend">
    <div class="products cw1600" wow='fadeInUp'>
        <div class="top flex-between">
            <div class="title" wow='fadeInUp'>
                <?=l('推荐产品','Recommended Products')?>
            </div>
        </div>
        <div class="content">
            <?php foreach((array)$rel_pro as $k => $v) {
                $pic = str::json($v['Pictures'], 'decode');
                $url = url::set($v,'wb_products.detail');
            ?>
                <a href="<?=$url; ?>" class="box block b-pic" wow='fadeInUp'>
                    <div class="img m-pic trans over"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></div>
                    <div class="name trans"><?=$v['Name']?></div>
                    <div class="brief trans"><?=$v['BriefDescription']?></div>
                </a>
            <?php }?>
        </div>
    </div>

    <?php if($navTwoId == 'media_Detail'){ ?>
    <div class="case cw1600" wow='fadeInUp'>
        <div class="top flex-between">
            <div class="title" wow='fadeInUp'><?=l('推荐方案','Recommendation')?></div> 
            <a href="/industry" class="more trans"><?=l('了解更多','View More')?></a>
        </div>
        <div class="content">
            <?php  foreach((array)$rel_ind as $k => $v) {
                $pic1 = str::json($v['Pictures4'], 'decode');
                $pic2 = str::json($v['Picture'], 'decode');
                $pic = $pic1?$pic1:$pic2;

                $url = url::set($v, 'wb_industry.detail');
            ?>
                <a href="<?=$url; ?>" class="box block b-pic" wow='fadeInUp'>
                    <div class="img i-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute"></div>
                    <div class="name trans"><?=$v['Name'].l('行业方案',' Industry Solutions'); ?></div>
                </a>
            <?php }?>
        </div>
    </div>
    <?php }?>
</section>