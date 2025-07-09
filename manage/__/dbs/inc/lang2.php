<section class="flex-middle2 <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
	<!-- <?php if (count(c('language'))<6) { ?><div class='tit'><?=language('language.change')?>：</div><?php } ?> -->
	<div class="ly_btn_group_radius" size="small" bg="white">
		<?php foreach (c('language') as $k => $v) { ?>
			<div class="<?=$v==c('lang')?'cur':''?>" front-end-language="<?=$v?>"><?=language('language.'.$v)?></div>
		<?php } ?>
	</div>
</section>