<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$table = 'wb_products_category';
$where = '1=1';
if ($cfg['Dept']) {
	$where .= ' and Dept<='.(int)$cfg['Dept'];
}

$category = db::ly_drop_select_category('Id', $table, $where);

?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
			<div class="tab_links mb_15px">
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="all" <?=$row[$name.'Type']?($row[$name.'Type']=='all'?'checked':''):'checked'?> fn="dbs_products_suit"></i>
					<span><?=language('panel.select_products.all')?></span>
				</label>
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="id" <?=$row[$name.'Id']?'checked':''?> fn="dbs_products_suit"></i>
					<span><?=language('panel.select_products.id')?></span>
				</label>
				<label class="ly_btn_radio pointer mr_10px">
					<i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="category" <?=$row[$name.'Category']?'checked':''?> fn="dbs_products_suit"></i>
					<span><?=language('panel.select_products.category')?></span>
				</label>
			</div>
			<div class="tab_content">
				<label class="hide2 ly_select_checkbox" data-type="checkbox" data-con="id" lydbs-association-list-drop="" data-ma="products/index">
					<input type="hidden" name="<?=$name?>Id" value="<?=$row[$name.'Id']?>">
					<i class="lyicon-arrow-down-bold"></i>
				</label>
				<label class="hide2 ly_select_checkbox" ly-drop-select data-type="checkbox" data-con="category">
					<div><input type="text" placeholder=""></div>
					<input type="hidden" name="<?=$name?>Category" value="<?=$row[$name.'Category']?>">
					<i class="lyicon-arrow-down-bold"></i>
					<script type="text"><?=str::json($category)?></script>
				</label>
				<label class="flex-btn pointer mt_20px">
					<i class="ly_checkbox lyicon-select-bold mr_10px"></i>
					<input type="checkbox" class="hide" value="1" <?=$row[$name.'DetailShow']?'checked':''?>/>
					<input type="hidden" name="<?=$name?>DetailShow" value="<?=$row[$name.'DetailShow']?>" />
					<span><?=language('panel.select_products.DetailShow')?></span>
				</label>
			</div>
		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>
