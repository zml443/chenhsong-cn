<?php
// 已被使用的变量
// $name, $value, $row, $cfg

// d($cfg);
?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class="wb_pro_price_type">
				<label class="li">
					<div class="name"><?=language('{/orders.products_one_sp/}')?></div>
					<div class="brief"><?=language('{/orders.products_one_sp_brief/}')?></div>
					<input class="hide" type="radio" name="ProPriceType" value="0" <?=$row['ProPriceType']==0?'checked':''?> />
				</label>
				<label class="li">
					<div class="name"><?=language('{/orders.products_more_sp/}')?></div>
					<div class="brief"><?=language('{/orders.products_more_sp_brief/}')?></div>
					<input class="hide" type="radio" name="ProPriceType" value="1" <?=$row['ProPriceType']==1?'checked':''?> />
				</label>
			</div>

			<div class="wb_products_parameter_tab__box relative">
				<div class="wb_products_parameter_tab__0  <?=$row['ProPriceType']==0?'':'absolute goaway'?>">
					<ul class="flex mt_30px">
						<li class="flex-1">
							<div class="mb_10px"><?=language('{/orders.sale_price/}')?>（<?=price::rate(0,1)?>）</div>
							<label class="ly_input mr_10px"><input type="number" step="0.01" name="Price" value="<?=$row['Price']?>" /></label>
						</li>
						<li class="flex-1">
							<div class="mb_10px"><?=language('{/orders.original_price/}')?>（<?=price::rate(0,1)?>）</div>
							<label class="ly_input mr_10px"><input type="number" step="0.01" name="OriginalPrice" value="<?=$row['OriginalPrice']?>" /></label>
						</li>
						<li class="flex-1">
							<div class="mb_10px"><?=language('{/orders.cost_price/}')?>（<?=price::rate(0,1)?>）</div>
							<label class="ly_input"><input type="number" step="0.01" name="CostPrice" value="<?=$row['CostPrice']?>" /></label>
						</li>
					</ul>
					<ul class="flex mt_20px">
						<li class="flex-1">
							<div class="mb_10px"><?=language('{/global.weight/}')?>（<?=price::rate(0,1)?>）</div>
							<label class="ly_input mr_10px"><input type="number" step="0.001" name="Weight" value="<?=$row['Weight']?>" /></label>
						</li>
						<li class="flex-1">
							<div class="mb_10px"><?=language('{/orders.stock/}')?>（<?=price::rate(0,1)?>）</div>
							<label class="ly_input mr_10px"><input type="number" step="0" name="Stock" value="<?=$row['Stock']?>" /></label>
						</li>
						<li class="flex-1">
							<div class="mb_10px">SKU</div>
							<label class="ly_input"><input type="text" name="SKU" value="<?=$row['SKU']?>" /></label>
						</li>
					</ul>
				</div>
				<div class="wb_products_parameter_tab__1 <?=$row['ProPriceType']==1?'':'absolute goaway'?>">
					<!-- 开始 -->
					<div class="wb_pro_parameter_type_null wb_pro_parameter_type_null__1 flex-max">
						<div class="pic"><img class="svg" src="/images/global/null.svg" alt=""></div>
						<div class="txt"><?=language('{/notes.null/}')?></div>
						<div class="lydbs_add_pro_parameter ly_btn_radius pointer width90" bg="main" size="small">
							<?=language('{/global.add/}')?>
						</div>
					</div>
					<div class="wb_pro_parameter_type_list">
						<div class="ul"></div>
						<div class="b-bottom pb_30px mb_30px">
							<div class="lydbs_add_pro_parameter ly_btn_radius pointer2" bg="light" size="small"><?=language('{/orders.products_add_parameter/}')?></div>
						</div>
					</div>
					<div class="wb_pro_parameter_type_table__1">
						<div class="wb_pro_parameter_type_table_bat flex-right">
							<div class="btn ly_btn_radius pointer" bg="main" size="mini"><?=language('{/global.fill_bat/}')?></div>
						</div>
						<div class="ly_table_box mt_10px"><table class="wb_pro_parameter_type_table ly_table_line maxw"></table></div>
					</div>
					<div class="wb_pro_parameter_type_null wb_pro_parameter_type_null__2 flex-max">
						<div class="pic"><img class="svg" src="/images/global/null.svg" alt=""></div>
						<div class="txt"><?=language('{/notes.null/}')?></div>
					</div>
					<script class="wb_products_parameter_data" type="json"><?=htmlspecialchars_decode($row['wb_products_parameter'])?></script>
					<script type="json" class="wb_products_parameter_price_data">
						<?php
							$price_items = str::json(htmlspecialchars_decode($row['wb_products_parameter_price']), 'decode');
							$price_array = array();
							foreach ($price_items as $k => $v) {
								$price_array[$v['parameter_id']] = $v;
							}
							echo str::json($price_array);
						?>
					</script>
					<!-- 结束 -->
				</div>
			</div>


		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>