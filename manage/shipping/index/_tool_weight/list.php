<?php
// 已被使用的变量
// $name, $value, $row, $cfg
// d($name, $value, $row, $cfg);

?>
<a class="wb_shipping_price_set">
	<?=language('{/global.set/}')?>
	<script type="json" class="wb_shipping_price_url">
		<?=str::json(array(
			array(
				'name' => '中国国内地区',
				'url' => "?ma=shipping/price&L=list&{$this->table}_id={$row['Id']}&_popup_=1",
			),
			array(
				'name' => '国家地区',
				'url' => "?ma=shipping/country_price&L=list&{$this->table}_id={$row['Id']}&_popup_=1",
			),
		))?>
	</script>
</a>
<script>$.include('<?=file::self_dir(__FILE__)?>list.js');</script>