<?php
// 已被使用的变量
// $name, $value, $row, $cfg


// 关联条件
$search_where_para = array();
$rs = db::query("select * from wb_products_search_where where 1");
while ($v=db::result($rs)) {
	$search_where_para[] = array(
		'label' => $v['Name'],
		'value' => 'param_id.'.$v['Id'],
	);
}

$search_para = array(
	array(
		'label' => '分类',
		'value' => 'cid',
	),
	array(
		'label' => '价格',
		'value' => 'price',
	),
	array(
		'label' => '标签',
		'value' => 'tag',
	)
);
$search_where_para && $search_para[] = array(
		'label' => '扩展条件',
		'children' => $search_where_para,
);
?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-max2 p_10_0px zIndex1' ly-sticky="center" bg="white">
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip flex-1'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
		<a class="PSearch_table_add ly_btn" bg="main" size="small"><?=language('{/global.add/}')?></a>
	</div>
	<div id="No000" class='_dbs_content'>
		<!-- 开始 -->
		<script class="PSearch_table_tr_data" type="text"><?=htmlspecialchars_decode($row['Data'])?></script>
		<script class="PSearch_table_drop_type" type="text"><?=str::json($search_para)?></script>
		<table class="PSearch_table ly_table_list maxw">
			<thead>
				<tr>
					<td class="w_1"></td>
					<td>名称</td>
					<td>类型</td>
					<td class="w_1">操作</td>
				</tr>
			</thead>
			<tbody ly-drag-sort fn="products_search_tool_parameter">
			</tbody>
		</table>
		<div class="PSearch_table_null_opt flex-max height200">
			<div class="m-pic"><img src="/images/global/null2.png"></div>
			<div class="text-center" color="text3">暂无数据~</div>
		</div>
		<!-- 结束 -->
	</div>
</div>
<script>$.include('<?=file::self_dir(__FILE__)?>form.js');</script>