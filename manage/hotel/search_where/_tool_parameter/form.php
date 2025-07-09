<?php
// 已被使用的变量
// $name, $value, $row, $cfg

$id = $this->row['Id'];
$all = db::all("select * from wb_hotel_search_where_extid where wb_hotel_search_where_id='{$id}' order by MyOrder asc,Id asc");



?>
<div class='_dbs_item <?=$cfg['Class']?>' data-dbs-type='<?=strtolower($cfg['Type'])?>'>
	<div class='_dbs_tit flex-max2 p_10_0px zIndex1' ly-sticky="center" bg="white">
		<span class="name"><?=$cfg['Name']?></span>
		<span class='tip flex-1'><?=$cfg['Tip']?'('.$cfg['Tip'].')':''?></span>
		<a class="PSearch_table_add ly_btn" bg="main" size="small"><?=language('{/global.add/}')?></a>
	</div>
	<div id="No000" class='_dbs_content'>
		<!-- 开始 -->
		<script class="PSearch_table_tr_data" type="text"><?=str::json($all)?></script>
		<script class="PSearch_table_drop_type" type="text"><?=str::json($search_para)?></script>
		<table class="PSearch_table ly_table_list maxw">
			<thead>
				<tr>
					<td class="w_1"></td>
					<td>选项</td>
					<td>关联</td>
					<td class="w_1">操作</td>
				</tr>
			</thead>
			<tbody ly-drag-sort fn="hotel_search_tool_parameter">
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