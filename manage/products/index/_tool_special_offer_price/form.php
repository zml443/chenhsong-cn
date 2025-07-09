<?php
// 已被使用的变量
// $name, $value, $row, $cfg

?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<label class="switchery ml_5px" size="small">
			<input type='checkbox' value='1' fn='__special_offer_open_' <?=$row['SpecialOfferOpen']?'checked':''?>>
			<input type='hidden' name='SpecialOfferOpen' value='<?=$row['SpecialOfferOpen']?'1':'0'?>' />
		</label>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->

			<div class='flex-middle2'>
				<label class='ly_input width200'>
					<b><?=price::rate(0,1)?></b>
					<input type='number' name='SpecialOfferPrice' value="<?=$row['SpecialOfferPrice']?>" step='0.01' />
				</label>
				　{/products.special_offer_price_time/}：
				<label class='ly_input width200'>
					<input value='<?=date('Y-m-d', $row['SpecialOfferTimeStart']).' ~ '.date('Y-m-d', $row['SpecialOfferTimeEnd'])?>' laydate='' range='~' format='yyyy/MM/dd' fn="__special_offer_time_" />
				</label>
				<input class="start_time" type="hidden" name="SpecialOfferTimeStart" value="<?=$row['SpecialOfferTimeStart']?>" />
				<input class="end_time" type="hidden" name="SpecialOfferTimeEnd" value="<?=$row['SpecialOfferTimeEnd']?>" />
			</div>

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>