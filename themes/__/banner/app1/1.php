<?php
    $conf = $lyCssConf['cfg'];
    // d($conf);
?>
<link rel="stylesheet" href="/themes/__/banner/app1/1.css" />

<section class="ly_hengfu_app hide">
	<div class='container' delay="<?=$conf['autoloop']['open']?(int)$conf['autoloop']['text']:'0'?>">
		<div class='wrapper'>
			<?php foreach ((array)$conf['carousel'] as $k => $v) {?>
				<div class='slide <?='k'.$k?>'>
					<style class="css-root-var">
						.ly_hengfu_app .<?='k'.$k?> {
							--small_color:<?=$v['font']['color']?:'#fff'?>;
							--small_style:<?=$v['font']['font_style']?>;
						}
					</style>
					<a class="block" href="<?=$v['picture_link']['href']?$v['picture_link']['href']:'javascript:'?>" target="<?=$v['picture_link']['target']?>">
						<img class="img_app" src="<?=$v['picture_app']['path']?>" alt="<?=$v['picture_app']['alt']?>">
					</a>
					<div class="message flex-max">
                        <?php if($v['title']['open']){ ?>
                            <div class="name"><?=nl2br($v['title']['text'])?></div>
                        <?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>