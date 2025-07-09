<?php
$wb_orders_id = (int)$_GET['wb_orders_id'];
$orders_row = db::result("select * from wb_orders where Id='{$wb_orders_id}'");
$orders_row = str::code($orders_row);

$orders_products = db::all("select * from wb_orders_products where wb_orders_id='{$orders_row['Id']}'");

$orders_shipping_address = db::result("select * from wb_orders_address where wb_orders_id='{$orders_row['Id']}' and Type='shipping'");
$orders_shipping_address = str::code($orders_shipping_address);

$row = db::result("select * from ".$this->table." where Id='{$_GET['Id']}'");
$row = str::code($row);
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">
	
	<form class='maxvh2 flex-column' dbs='detail' action='<?=$this->set['query_string']['post'];?>'>
		<!-- 开始 -->
		<div class='p_30_0px ly-h3 flex-middle2' cw="<?=$_GET['_w_']?:'1300'?>">
			<i class="ly-h3 mr_5px lyicon-arrow-left-bold" hr-ef="back()"></i>
			<span hr-ef="back()">NO.#<?=$orders_row['OrderNumber']?></span>
		</div>
		<!-- 结束 -->
		
		<!-- 开始 -->
		<div class="flex-between flex-wrap flex-1 mb_20px" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class='content_left'>
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="ly-h4"><?=language('orders.goods_list')?></div>
					</div>
					<div class="_dbs_item">
						<ul class="">
							<?php
								foreach($orders_products as $k => $v){
									$v['Parameter'] = str::json($v['Parameter'], 'decode');
									$v = str::code($v, 'htmlspecialchars');
							?>
								<li class="flex-middle2 <?=$k?'mt_10px':''?>">
									<div class="num mr_20px"><?=$k+1?></div>
									<a class="ly_img m-pic mr_20px" href=""><img src="<?=$v['Picture']?>" alt=""></a>
									<div class="flex-1">
										<a href="" target="_blank" class="proname fz14"><?=$v['Name']?></a>
										<div class="tag">
											<?php if ($v['Category']) { ?>
												<div class="ly_btn mr_10px mt_10px" size="mini" bg="light2" color="text"><?=$v['Category']?></div>
											<?php } ?>
											<?php foreach ($v['Parameter'] as $k1 => $v1) { ?>
												<div class="ly_btn mr_10px mt_10px" size="mini" bg="light2" color="text"><?=/*$v1['title'].' : '.*/$v1['value']?></div>
											<?php } ?>
										</div>
									</div>
									<div class="text-right lh_1_8">
										<div color="text3"><?=price::rate($v['Price'])?></div>
										<div color="text3">x<?=$v['Qty']?></div>
										<div><?=price::rate($v['Qty']*$v['Price'])?></div>
									</div>
								</li>
							<?php }?>
						</ul>
					</div>
				</div>
				<!--  -->
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="ly-h4"><?=language('orders.shipping_info')?></div>
					</div>
					<div class="_dbs_item">
						<div class="ly-h5 mb_5px" color="text"><?=language('orders.shipping_number')?></div>
						<input class="ly_input width300" type="text" name="Name" value="<?=$row['Name']?>" autocomplete="off">
					</div>
					<!--  -->
					<div class="_dbs_item">
						<div class="fz14 mb_5px" color="text"><?=language('orders.shipping_time')?></div>
						<label class="ly_input_suffix width300">
							<input type="text" name="AddTime" placeholder="输入框" value="<?=$row['AddTime']?date('Y-m-d', $row['AddTime']):''?>" laydate>
							<i class="lyicon-calendar"></i>
						</label>
					</div>
					<!--  -->
					<div class="_dbs_item">
						<div class="fz14 mb_5px" color="text"><?=language('global.remark')?></div>
						<label class="ly_input"><textarea size="default" name="Remarks" autoheight><?=$row['Remarks']?></textarea></label>
					</div>
					<input type='hidden' name='Id' value='<?=$row['Id']?>'>
					<input type='hidden' name='wb_orders_id' value='<?=$_GET['wb_orders_id']?>'>
				</div>
				<!--  -->
			</div>

			<div class='content_right' ly-sticky="center">
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="ly-h4"><?=language('form.shipping2')?></div>
					</div>
					<!--  -->
					<div class="_dbs_item">
						<?=language('form.shipping_type2')?>： <?=$orders_row['ShippingType']?> ( <?=price::rate($orders_row['ShippingPrice'])?> )
					</div>
					<div class="_dbs_item">
						<div class="ly_tip p_20px">
							<div class="top flex-between mb_15px">
								<i class="fz30 lyicon-map-filling" color="text2"></i>
							</div>
							<div class="lh_1_8 fz14 gai_bian_ding_da_di_zhi">
								<div class=""><span class="pr_10px"><?=language('form.name')?>:</span><span><?=str::real_name($orders_shipping_address['FirstName'], $orders_shipping_address['LastName'])?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.phone')?>:</span><span><?=$orders_shipping_address['Phone']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.country')?>:</span><span><?=$orders_shipping_address['Country']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.province')?>:</span><span><?=$orders_shipping_address['Province']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.city')?>:</span><span><?=$orders_shipping_address['City']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.address')?>:</span><span><?=$orders_shipping_address['Address']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.postcode')?>:</span><span><?=$orders_shipping_address['Postcode']?:'-'?></span></div>
							</div>
						</div>
					</div>
					<!--  -->
				</div>
			</div>
		</div>
		<!-- 结束 -->

		<!-- 开始 -->
		<div class='_dbs_submit' ly-sticky="bottom">
			<div class="flex-max2">
				<label class='ly_btn mr_30px pointer' hr-ef='back()'><?=language('{/global.back/}')?></label>
				<label class='ly_btn pointer' bg="main"><input type='submit' hide><?=language('{/global.submit/}')?></label>
			</div>
		</div>
		<!-- 结束 -->

	</form>

</body>
</html>