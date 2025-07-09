<section class="flex-middle2 <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
<?php if (!$this->is_monolingual) { ?>
		<?php if (count(c('language'))<6) { ?><div class='tit'><?=language('language.change')?>：</div><?php } ?>
		<div class="ly_btn_group_radius" size="small" bg="white" ly-tab="{}" to='[mLanguage]'>
			<?php foreach (c('language') as $k => $v) { ?>
				<div class="<?=$v==c('lang')?'cur':''?>" lang='<?=$v?>'><?=language('language.'.$v)?></div>
			<?php } ?>
		</div>
<?php } ?>
</section>