

<section class="zml_lang3 flex-middle2 relative pointer pb_5px pt_5px <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
	<span class="fzT2" color="text3"><?=language('{/language.change/}')?>:</span>
	<i class="fzT1 lyicon-language ml_10px mr_10px"></i>
	<span class="fzT2"><?=$_GET['Language']?language('language.'.$_GET['Language']):language('global.change')?></span>
	<i class="lyicon-arrow-down-bold fzT2 ml_15px"></i>
	<!--  -->
	<div class='ly_drop_right fzT2'>
		<div>
			<?php
			$language = c('language');
			foreach ($language as $k => $v) {
			?>
				<a class='ly_drop_item' href="?<?=url::query_string('Language').'&Language='.$v?>"><?=language('{/language.'.$v.'/}')?></a>
			<?php } ?>
		</div>
	</div>
	<?php if (!$this->is_monolingual) { ?>
		<div class="hide2" ly-tab="{}" to='[mLanguage]'>
			<?php foreach (c('language') as $k => $v) { ?>
				<div class="<?=$v==$_GET['Language']?'cur':''?>" lang='<?=$v?>'><?=language('language.'.$v)?></div>
			<?php } ?>
		</div>
	<?php } ?>
</section>
