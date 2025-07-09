<?php
$Id = (int)$_GET['Id'];
$orders_row = db::get_one('wb_orders',"Id='{$Id}'");
$orders_row = str::code($orders_row);
if (!$orders_row) {
	return '';
}
$orders_products = db::all("select * from wb_orders_products where wb_orders_id='{$orders_row['Id']}'");
$orders_products_qty = db::result("select sum(Qty) as a from wb_orders_products where wb_orders_id='{$orders_row['Id']}'", 'a');
$orders_products_weight = db::result("select sum(Qty*Weight) as a from wb_orders_products where wb_orders_id='{$orders_row['Id']}'", 'a');

$orders_shipping_address = db::result("select * from wb_orders_address where wb_orders_id='{$orders_row['Id']}' and Type='shipping'");
$orders_shipping_address = str::code($orders_shipping_address);

// 当前用户购买订单数量
if ($orders_row['wb_member_id']) {
	$has_orders = db::result("select count(*) as a from wb_orders where wb_member_id='{$orders_row['wb_member_id']}'", 'a');
	$has_pay_orders = db::result("select count(*) as a from wb_orders where wb_member_id='{$orders_row['wb_member_id']}' and PayTime>0", 'a');
} else {
	if ($orders_row['Email']) {
		$email = addslashes($orders_row['Email']);
		$has_orders = db::result("select count(*) from wb_orders where Email='{$email}'", 'a');
		$has_pay_orders = db::result("select count(*) from wb_orders where Email='{$email}' and PayTime>0", 'a');
	} else {
		$Tel = addslashes($orders_row['Tel']);
		$has_orders = db::result("select count(*) from wb_orders where Tel='{$Tel}'", 'a');
		$has_pay_orders = db::result("select count(*) from wb_orders where Tel='{$Tel}' and PayTime>0", 'a');
	}
}
// 发货信息
$orders_shipping_info = db::result("select * from wb_orders_shipping_info where wb_orders_id='{$Id}'");
$orders_shipping_info = str::code($orders_shipping_info);
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
	<script type='text/javascript' src='/manage/orders/index/_js.js' ></script>
</head>

<body bg="default">
	
	<form class='maxvh2 flex-column <?=$this->is_mod?'_do_not_go_to_back':''?>' dbs='detail' action='<?=$this->set['query_string']['post'];?>' data-gotourl="<?=$this->set['query_string']['list']?>">
		<!-- 开始 -->
		<div class='p_30_0px ly-h3 flex-middle2' cw="<?=$_GET['_w_']?:'1300'?>">
			<i class="ly-h3 mr_5px lyicon-arrow-left-bold" hr-ef="back()"></i>
			<span hr-ef="back()">NO.#<?=$orders_row['OrderNumber']?></span>
		</div>
		<!-- 结束 -->

		<!-- 开始 -->
		<div class="et_orders_ly_step ly_step p_30_0px" align="center" size="mini" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class="cur <?=$orders_row['Status']>0?'next-cur':''?>">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div><?=language('orders.status_wait_pay')?></div>
					<div class="time mt_5px"><?=date('Y-m-d H:i:s', $orders_row['AddTime'])?></div>
				</div>
			</div>
			<div class="<?=$orders_row['Status']>=1?'cur':''?> <?=$orders_row['Status']>1?'next-cur':''?>">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div><?=language('orders.status_pay')?></div>
				</div>
			</div>
			<div class="<?=$orders_row['Status']>=2?'cur':''?> <?=$orders_row['Status']>2?'next-cur':''?>">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div><?=language('orders.status_wait_shipping')?></div>
					<?php if ($orders_row['PayTime']) { ?>
						<div class="time mt_5px"><?=date('Y-m-d H:i:s', $orders_row['PayTime'])?></div>
					<?php } ?>
				</div>
			</div>
			<div class="<?=$orders_row['Status']>=3?'cur':''?> <?=$orders_row['Status']>3?'next-cur':''?>">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div><?=language('orders.status_shipping')?></div>
					<!-- <div class="time mt_5px"></div> -->
				</div>
			</div>
			<div class="<?=$orders_row['Status']>=5?'cur':''?>">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div><?=language('orders.status_finished')?></div>
					<!-- <div class="time mt_5px"></div> -->
				</div>
			</div>
		</div>
		<!-- 结束 -->

		<div class="ly_main_tip p_30px mb_20px flex-middle2" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class="txt fz14"><?=language('orders.send_tip')?></div>
			<div class="ly_btn_radius ml_15px fz14" size="small" bg="main"><?=language('orders.send_notice')?></div>
			<div class="ly_btn_radius ml_15px fz14" size="small" bg="main"><?=language('orders.copy_url')?></div>
		</div>
		
		<!-- 开始 -->
		<div class="flex-between flex-wrap flex-1 mb_20px" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class='content_left flex-column'>
				<!-- 订单基础信息 开始 -->
				<div class="_dbs_box maxw">
					<div class="_dbs_item">
						<div class="ly-h4 mb_10px">NO.#<?=$orders_row['OrderNumber']?></div>
						<div class="pb_20px flex-middle2">
							<div class="mr_15px" color="text3">
								<?=str_replace('{{time}}', date('Y-m-d H:i:s', $orders_row['AddTime']), language('orders.created_on'))?>
							</div>
							<?php
								if ($orders_row['Status']==5) {
									echo '<div class="ly_btn_radius mr_15px" size="mini" bg="light">'.language('orders.status_finished').'</div>';
								} else {
									echo '<div class="ly_btn_radius mr_15px" size="mini" bg="warning-light">'.language('orders.status_not_finished').'</div>';
								}
								if ($orders_row['PayTime']) {
									echo '<div class="ly_btn_radius mr_15px" size="mini" bg="light">'.language('orders.status_pay').'</div>';
								} else {
									echo '<div class="ly_btn_radius mr_15px" size="mini" bg="warning-light">'.language('orders.status_unpay').'</div>';
								}
								if ($orders_row['ShippingTime']) {
									echo '<div class="ly_btn_radius mr_15px" size="mini" bg="light">'.language('orders.status_shipping').'</div>';
								} else {
									echo '<div class="ly_btn_radius mr_15px" size="mini" bg="warning-light">'.language('orders.status_unshipping').'</div>';
								}
							?>
						</div>
						<!--  -->
						<ul class="pb_20px b-bottom">
							<li class="flex-middle2">
								<span class="width100 fz14"><?=language('orders.products_price')?></span>
								<span class="flex-1" color="text3"><?=str_replace('{{qty}}', (int)$orders_products_qty, language('orders.products_qty'))?></span>
								<span class=""><?=price::rate($orders_row['Price'])?></span>
							</li>
							<li class="flex-middle2 mt_20px">
								<span class="width100 fz14"><?=language('orders.shipping_price')?></span>
								<span class="flex-1"></span>
								<span class=""><?=price::rate($orders_row['ShippingPrice'])?></span>
							</li>
							<li class="flex-middle2 mt_20px">
								<span class="width100 fz14"><?=language('orders.pay_additional_fee')?></span>
								<span class="flex-1"></span>
								<span class=""><?=price::rate($orders_row['PayAdditionalFee'])?></span>
							</li>
							<?php if ($orders_row['FreeType']=='1') { ?>
								<li class="flex-middle2 mt_20px">
									<span class="width100 fz14"><?=language('global.discount')?></span>
									<span class="flex-1" color="text3"><?=$orders_row['FreeDiscount']?></span>
									<span class="">- <?=price::rate($orders_row['FreeDiscount'] * $orders_row['Price'])?></span>
								</li>
							<?php } else { ?>
								<li class="flex-middle2 mt_20px">
									<span class="width100 fz14"><?=language('global.less_cash')?></span>
									<span class="flex-1"></span>
									<span class="">- <?=price::rate($orders_row['FreeMoney'])?></span>
								</li>
							<?php } ?>
						</ul>
						<ul class="global_price_info p_20_0px b-bottom">
							<li class="flex-middle2">
								<span class="width100 fz14"><?=language('orders.real_price')?></span>
								<span class="flex-1"></span>
								<span class="fz20"><?=price::rate($orders_row['TotalPrice'])?></span>
							</li>
						</ul>
						<?php if ($orders_row['Message']) { ?>
						<ul class="global_price_info p_20_0px b-bottom">
							<li class="flex-middle2">
								<span class="width100 fz14"><?=language('orders.message')?></span>
								<span class="flex-1" color="text3"><?=$orders_row['Message']?></span>
							</li>
						</ul>
						<?php } ?>
						<ul class="global_price_info p_20_0px">
							<li class="flex-middle2">
								<span class="width100 fz14"><?=language('orders.payment')?>:</span>
								<span class="flex-1" color="text3"><?=$orders_row['Payment']?></span>
								<?php if ($orders_row['Status']<1) { ?>
									<a class="ly_btn_radius orders_to_pay_status" size="mini" bg="main" data-id="<?=$orders_row['Id']?>"><?=language('orders.pay_over')?></a>
								<?php } ?>
							</li>
						</ul>
					</div>
				</div>
				<!-- 订单基础信息 结束 -->

				<!-- 订单产品 开始 -->
				<div class="_dbs_box maxw flex-1">
					<div class="_dbs_item">
						<div class="flex-between mb_15px">
							<div class="flex-middle2">
								<?php if ($orders_row['ShippingTime']) { ?>
									<div class="ly-h4" color="text"><?=language('orders.shipping_finished')?></div>
									<div class="ly_main_tag ml_10px" size="mini"><?=language('orders.shipping_id')?>:<?=$orders_shipping_info['Name']?></div>
								<?php } else { ?>
									<div class="ly-h4" color="text"><?=language('orders.shipping_not_finished')?></div>
								<?php } ?>
								<div class="ly_main_tag ml_10px" size="mini"><?=str_replace('{{qty}}', (int)$orders_products_qty, language('orders.products_qty'))?></div>
							</div>
							<div class="flex-middle2">
								<?php if ($orders_row['ShippingTime']) { ?>
									<a class="ml_15px" color="main" hr-ef="?u=<?=$_GET['u']?>&ma=orders/shipping_info&E=edit&wb_orders_id=<?=$orders_row['Id']?>"><?=language('orders.mod')?></a>
									<a class="ml_15px" color="text3"><?=language('orders.shipping_cancel')?></a>
								<?php } else { ?>
									<a class="ly_btn_radius" size="mini" bg="main" hr-ef="?u=<?=$_GET['u']?>&ma=orders/shipping_info&E=edit&wb_orders_id=<?=$orders_row['Id']?>"><?=language('orders.shipping_over')?></a>
								<?php } ?>
							</div>
						</div>
						<div class="pb_25px fz14" color="text3">
							<span class="mr_15px"><?=language('orders.shipping_type')?>: <?=$orders_row['ShippingType']?></span>
							<span class="mr_15px"><?=language('orders.shipping_price')?>: <?=price::rate($orders_row['ShippingPrice'])?></span>
							<span class="mr_15px"><?=language('global.weight')?>: <?=$orders_products_weight?>KG</span>
						</div>
						<ul class="">
							<?php
								foreach($orders_products as $k => $v){
									$v['Parameter'] = str::json($v['Parameter'], 'decode');
									$v = str::code($v, 'htmlspecialchars');
							?>
								<li class="flex-middle2 <?=$k?'mt_20px':''?>">
									<div class="num mr_20px"><?=$k+1?></div>
									<div class="ly_img m-pic mr_20px"><img src="<?=$v['Picture']?>" alt=""></div>
									<div class="flex-1">
										<div class="fz14"><?=$v['Name']?></div>
										<div class="flex-wrap">
											<?php if ($v['Category']) { ?>
												<div class="ly_main_tag mr_10px mt_10px" size="mini"><?=$v['Category']?></div>
											<?php } ?>
											<?php foreach ($v['Parameter'] as $k1 => $v1) { ?>
												<div class="ly_main_tag mr_10px mt_10px" size="mini"><?=/*$v1['title'].' : '.*/$v1['value']?></div>
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
				<!-- 订单产品 结束 -->
				
				<?php /*?>
				<!-- 订单日志 开始 -->
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="global_top_title">
							<div class="name mb_10px" color="text">日志</div>
						</div>
						<div class="ly_history">
							<div class="cur">
								<div class="ly_history_time" color="text3">
									2023-02-14<br/>
									14:25:43
								</div>
								<div class="ly_history_point"><i></i></div>
								<div class="ly_history_text">
									<div>已通过 Cash On Delivery 处理 101.00 USD 的付款。</div>
									<div color="text3">(管理员) uee18665946544</div>
								</div>
							</div>
							<div class="">
								<div class="ly_history_time" color="text3">
									2023-02-14<br/>
									14:25:43
								</div>
								<div class="ly_history_point"><i></i></div>
								<div class="ly_history_text">
									<div>已通过 Cash On Delivery 处理 101.00 USD 的付款。</div>
									<div color="text3">(管理员) uee18665946544</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- 订单日志 结束 -->
				<?php /*/?>
			</div>

			<div class='content_right'  ly-sticky="center">
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="flex-between flex-wrap mb_20px">
							<div class="ly-h4" color="text"><?=language('orders.customer')?></div>
							<!-- <a href="javascript:void(0);" class="mod fz14 inline-block v-middle" color="main">修改</a> -->
						</div>
						<div class="fz16 mb_10px"><?=$orders_row['Email']?:($orders_row['Tel']?:language('member.null_tel'))?></div>
						<div class="fz14" color="main">
							(<?=$orders_row['wb_member_id']?language('orders.visitor'):language('orders.customer')?>) 
							<?=str_replace(array('{{qty}}', '{{times}}'), array((int)$has_orders, (int)$has_pay_orders), language('orders.buy_tip'))?>
						</div>
						<?php
							if ($orders_row['Ip']) {
								$ip_info = ip::info($orders_row['Ip']);
						?>
						<div class="mt_10px flex-middle2">
							<i class="lyicon-electronics fz20"></i>
							<span class="ml_10px mr_10px">IP: <?=$orders_row['Ip']?> <?=$ip_info['country'].' '.$ip_info['province'].' '.$ip_info['city']?></span>
							<!-- <a href="" class="lyicon-xiaoxi fz20"></a> -->
						</div>
						<?php } ?>
					</div>
				</div>
				<!--  -->
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="ly-h4 mb_20px"><?=language('form.shipping2')?></div>
						<div class="ly_tip p_20px">
							<div class="top flex-between mb_15px">
								<i class="fz30 lyicon-map-filling" color="text2"></i>
								<a class="xiu_gai_ding_da_di_zhi pointer" color="main" data-id="<?=$orders_shipping_address['Id']?>"><?=language('global.mod')?></a>
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
				</div>
				<!--  -->
				<!-- <div class="_dbs_box">
					<div class="_dbs_item">
						<div class="ly-h4 mb_20px">订单来源</div>
						<div class="fz14">流量来源: 手动创建</div>
					</div>
				</div> -->
				<!--  -->
				<?php /*?>
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="global_top_title flex-between flex-wrap mb_25px">
							<div class="name" color="text">备注<span class="sub fz12 ml_5px" color="text3">( 此备注仅提供后台管理员查看 )</span></div>
						</div>
						<label class="ly_input ly_not_border width300">
							<input type="text" name="name" placeholder="请输入 ...">
							<b class="bg_pane">发送</b>
						</label>
						<div class="ly_history mt_30px">
							<div class="cur">
								<div class="ly_history_time" color="text3">
									2023-02-14<br/>
									14:25:43
								</div>
								<div class="ly_history_point"><i></i></div>
								<div class="ly_history_text">
									<div>已通过 Cash On Delivery 处理 101.00 USD 的付款。</div>
									<div color="text3">(管理员) uee18665946544</div>
								</div>
							</div>
							<div class="">
								<div class="ly_history_time" color="text3">
									2023-02-14<br/>
									14:25:43
								</div>
								<div class="ly_history_point"><i></i></div>
								<div class="ly_history_text">
									<div>已通过 Cash On Delivery 处理 101.00 USD 的付款。</div>
									<div color="text3">(管理员) uee18665946544</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--  -->
				<div class="_dbs_box">
					<div class="_dbs_item">
						<div class="global_top_title flex-between flex-wrap mb_25px">
							<div class="name" color="text">标签<span class="sub fz12 ml_5px" color="text3">( 仅后台可见 )</span></div>
							<a href="javascript:void(0);" class="mod fz14 inline-block v-middle" color="main">修改</a>
						</div>
						<div class="label_box">
							<div class="ly_btn_radius not-hover mr_10px" size="mini" bg="light2" color="text">标签1</div>
							<div class="ly_btn_radius not-hover mr_10px" size="mini" bg="light2" color="text">标签2</div>
						</div>
					</div>
				</div>
				<!--  -->
				<?php /*/?>
			</div>
		</div>
		<!-- 结束 -->
	</form>


</body>
</html>