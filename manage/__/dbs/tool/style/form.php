<?php
// $row 和 $this->row 是不一样的，
// 在json组件里面 $row 是指当前json的数据，$this->row 是数据库查询出来的数据

foreach ($cfg['Args'] as $k => &$v) {
	$v['url'] = str_replace('{{id}}', $this->row['Id'], $v['url']);
}

// d($row);
?>

<div class='_dbs_item <?=$cfg['EditShow']?'-show':''?> <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>' data-dbs-type='<?=$name?>'>
	<div class='_dbs_tit'>
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
	</div>
	<div class='_dbs_content flex-middle2'>
		<!-- 开始 -->

			<?php if ($cfg['Args'][0]['image']) { ?>
				<div class="pic ly_img mr_20px"><img src="" /></div>
			<?php } ?>
			<label class="ly_input_suffix inline-flex mr_20px" ly-drop-select="" fn="dbs_tool_style">
				<input type="text" placeholder="<?=language('global.select_index')?>">
				<input type="hidden" name="<?=$name?>" value="<?=$row[$name]?>">
				<script type="text"><?=str::json($cfg['Args']);?></script>
				<i class="lyicon-arrow-down-bold"></i>
			</label>
			<a class="ly_btn lianjie" bg="main"><?=language('global.edit')?></a>

		<!-- 结束 -->
	</div>
</div>

<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>