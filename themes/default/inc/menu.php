<?php if($navId != 'index') {?>
<section id="menu" class="absolute max" over>
    <div class="box cw1600 relative">
        <div class='container' view="auto" page='none' prev="#menu .prev" next="#menu .next">
            <div class='wrapper'>
                <?php foreach((array)$nav[$navId]['children'] as $k => $v) { ?>
                    <a href="<?=$v['href']; ?>" target="<?=$v['target']?>" class='slide block trans <?=$v['cur']?>'><?=$v['name']; ?></a>
                <?php }?>
            </div>
        </div>

        <div class="btn prev pointer absolute trans m-pic"><img class="svg trans" src="/images/icon/backTop.svg" /></div>
        <div class="btn next pointer absolute trans m-pic"><img class="svg trans" src="/images/icon/backTop.svg" /></div>
    </div>
</section>
<?php }?>