<section id="menu-invest">
    <div class="title"><?=$nav[$navId]['children'][8]['name'];?></div>

    <div class="two">
        <div class="ul">
            <?php foreach((array)$nav[$navId]['children'][8]['children'] as $k => $v) { ?>
                <a href="<?=$v['href']; ?>" class="li <?=$v['cur']; ?> block trans">
                    <?=$v['name']; ?>
                    <?=$v['tip']?'<span>('.$v['tip'].')</span>':''?>
                </a>
            <?php }?>
        </div>
    </div>
</section>