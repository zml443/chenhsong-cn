<?php
// 已被使用的变量
// $name, $value, $row, $cfg


?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			
			<div class="flex-middle2">
				<a class="ly_btn mr_30px" bg="main" hr-ef="<?=href('app.exhibition.products_category', 'wb_exhibition_id='.$row['Id'])?>"><?=language('{/menu.app.exhibition.products_category.module_name/}')?></a>
				<a class="ly_btn" bg="main" hr-ef="<?=href('app.exhibition.products', 'wb_exhibition_id='.$row['Id'])?>"><?=language('{/menu.app.exhibition.products.module_name/}')?></a>
			</div>

		<!-- 结束 -->
	</div>
</div>