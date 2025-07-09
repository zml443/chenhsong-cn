<section <?=r($lyCssConf)?>>
	<div class='fz20 flex-middle2 lh_1'>
		<i class="fz20 mr_5px lyicon-arrow-left-bold" hr-ef='back()'></i>
		<span hr-ef='back()'><?=permit::name();?></span>
		<span class="fz12 ml_20px flex-middle2" color="text3">
			<span class="mr_3px">/</span>
			<span><?=$this->is_add?language('{/global.add/}'):language('{/global.mod/}')?></span>
		</span>
	</div>
</section>