<?php
$arr_u = @explode(',', $_GET['u']);
$app_info = language('menu.'.$arr_u[0].'.'.$arr_u[1]);
?>
<div <?=r($lyCssConf)?>>
	<div class="zml_title flex-middle2">
		<div class="ly_face i-pic mr_20px" size="small"><img src="<?=$app_info['module_pic']?>" alt=""></div>
		<div>
			<div class="mb_10px flex-middle2">
				<span class="name"><?=$app_info['module_name']?></span>
				<div class="back ml_25px" hr-ef='<?=c('manage.permit.allurl.'.$arr_u[0].'._')?>'>
					<i class="lyicon-arrow-left-bold"></i>
					<span><?=language('global.back')?></span>
				</div>
			</div>
			<div class="brief" color="text3"><?=$app_info['module_brief']?></div>
		</div>
	</div>
</div>