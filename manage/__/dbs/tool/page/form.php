<?php
// 已被使用的变量
// $name, $value, $row, $cfg




?>

<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content'>
		<!-- 开始 -->
		
			<label class="ly_input_suffix" ly-drop-select="" fn="dbs_tool_page">
				<input type="text" value="" placeholder="" />
				<input type="hidden" name="<?=$name?>" value="<?=$row[$name]?>" />
				<i class="lyicon-arrow-down-bold"></i>
				<script type="json">
					<?php
						$nav = wb_site_page::url();
						echo str::json($nav);
					?>
				</script>
			</label>
			<input type="hidden" name="page_url_type" value="<?=$row['page_url_type']?>" />

		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>/form.js');</script>