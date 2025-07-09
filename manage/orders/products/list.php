<?php
$row = db::get_limit_page($this->table, "1", "*", 'desc', 0, 12);
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body>

	<div class="wrap_for_list" <?=$this->set['list']['width']?"data-width='".$this->set['list']['width']."'":""?>>
		<div class="wbox_top"><?php include c('dbs.list').'/inc/top.php';?></div>
		<div class="wbox_list ly_bg_fff">
			<div class="" sticky="{}">
				<div class="ly_bg_fff ly_zindex21 clean">
					<?php include c('dbs.list').'/inc/header.php';?>
					<?php include c('dbs.list').'/inc/search.php';?>
				</div>
			</div>
			<!--  -->
			<section id="dbs_list_box" class="clean">
				
				<table class="ly_table_2">
					<thead>
						<tr>
							<td class="-td" d="_id"><?=$this->th('_Id')?></td>
							<td>参数</td>
							<td class="-td" d="name">名称</td>
							<td class="-td" d="price">价格</td>
							<td class="-td" d="stock">库存</td>
							<td class="-td" d="picture">图片</td>
							<td class="-td" d="addtime">时间</td>
							<!-- <td class="-td" d="_ope">操作</td> -->
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($row['row'] as $k => $v) {
								$v = str::code($v);
						?>
							<tr>
								<td class="-td" d="_id"><?=$this->li('_Id', $v)?></td>
								<td>
									<label class="ly_input width300">
										<b>数量</b>
										<input type="number" name="p-qty" />
									</label>
									<label class="ly_input width300 mt_5px">
										<b>备注</b>
										<input type="text" name="p-remark" />
									</label>
									<?php
										// $v['wb_products_parameter_id'] = trim($v['wb_products_parameter_id'], ',');
										// $v['wb_products_parameter_id'] || $v['wb_products_parameter_id'] = 0;
										$wb_products_parameter_id = explode(',', $v['wb_products_parameter_id']);
										$pro_param_id = '0';
										foreach ($wb_products_parameter_id as $vid) {
											$pro_param_id .= ','.(int)$vid;
										}
										$param = db::category('Id', '', 'wb_products_parameter', "Id in({$pro_param_id})");
									?>
									<table class="mt_5px">
										<tbody class="pro-parameter">
											<tr>
												<td>
													<label class="ly_input width200 mr_5px">
														<b>参数</b>
														<select name="p-param"><option value="">{/global.select_index/}</option><?=$param?></select>
													</label>
												</td>
												<td><div class="ly_color_a notcopy add">{/global.add/}</div></td>
											</tr>
										</tbody>
									</table>
								</td>
								<td class="-td" d="name"><?=$this->li('Name', $v)?></td>
								<td class="-td" d="price">
									<?=$this->li('Price', $v)?>
									<?=$this->li('MemberPrice', $v)?>
								</td>
								<td class="-td" d="stock"><?=$this->li('Stock', $v)?></td>
								<td class="-td" d="picture"><?=$this->li('Picture', $v)?></td>
								<td class="-td" d="addtime"><?=$this->li('AddTime', $v)?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<input type='hidden' name='ex_na' value='<?=$_GET['ex_na']?>' />
				<input type='hidden' name='ex_id' value='<?=$_GET['ex_id']?>' />
			</section>
			<!--  -->
		</div>
	</div>

</body>
</html>

<script>
	// 复制
	$(document).on('click', '.pro-parameter .add', function () {
		var p = $(this).parents('tbody:eq(0)');
		var copy = p.find('tr:eq(0)');
		var n = $('<tr>'+copy.html()+'</tr>');
		n.find('.add').addClass('remove').html('<img width="14px" src="/static/images/ico/del.svg" />').removeClass('add');
		p.append(n);
	});
	// 删除
	$(document).on('click', '.pro-parameter .remove', function () {
		$(this).parents('tr:eq(0)').remove();
	});
	// 提交
	$(document).on('click', '.submit_append_products_data', function () {
		var data = {
			iscalc: $('[name="p-iscalc"]').is(':checked')?1:0,
			id: $('[name="ex_id"]').val(),
			data: {}
		};
		var has = 0;
		$('.-list>*>tr').each(function(){
			var tr = $(this)
			var id = tr.find('[name="Id"]');
			if (id.is(':checked')) {
				has = 1;
				id = id.val();
				data.data[id] = {
					qty: tr.find('[name="p-qty"]').val()||1,
					remark: tr.find('[name="p-remark"]').val(),
					param: [],
				};
				tr.find('[name="p-param"]').each(function(){
					data.data[id].param.push($(this).val());
				});
			}
		});
		if (!has) {
			WP.$.alert('请选择添加的产品', 2000);
			return false;
		}
		var lo = WP.$.alert('loading...');
		$.async('POST', '?ma=orders/products/add', data, function(result){
			lo.popup_remove(function(){
				if (result.ret==1) {
					WP.$.alert(result.msg, 2000);
					WP.$('iframe[src*="m=orders&a=products&"],iframe[name="main_iframe"]').each(function(){
						$(this).attr('src', $(this).attr('src'));
					});
				} else {
					WP.$.alert(result.msg, 2000);
				}
			});
		}, 'json');
	});
</script>