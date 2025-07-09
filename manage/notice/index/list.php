<?php

$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;

$where = '1';
// 取消订单
if ($_GET['CancelStatus']) {
	$where .= " and CancelStatus='{$_GET['CancelStatus']}'";
}
// 状态
switch ($_GET['oStatus']) {
	case 'unpay':
		$where .= " and PayTime=0";
		break;
	case 'pay':
		$where .= " and PayTime>0";
		break;
	case 'wait':
		$where .= " and Status in(2)";
		break;
	case 'unshipping':
		$where .= " and ShippingTime=0";
		break;
	case 'finished':
		$where .= " and Status=5";
		break;
	case 'cancel':
		$where .= " and CancelStatus=1";
		break;
}

$row = db::get_limit($this->table, $where, '*', $this->orderby, $pg*$this->limit, $this->limit);



?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<div class="p_30_0px flex-between" cw="<?=$_GET['_w_']?>"  bg="default">
		<div class="ly-h3"><?=language('{/menu.orders.module_name/}')?></div>
	</div>

	<div class="mb_20px" bg="white" cw="100%">
		<div class="" ly-sticky="top">
			<div class="ly_zindex21" bg="white">
				<div class="flex-between p_20px">
					<div class="ly_btn_group_radius">
						<a hr-ef="<?=$this->query_string['list']?>" class="<?=!$_GET['oStatus']?'cur':''?>"><?=language('global.all')?></a>
						<a hr-ef="<?=$this->query_string['list']?>&oStatus=unpay" class="<?=$_GET['oStatus']=='unpay'?'cur':''?>"><?=language('orders.status_unpay')?></a>
						<a hr-ef="<?=$this->query_string['list']?>&oStatus=pay" class="<?=$_GET['oStatus']=='pay'?'cur':''?>"><?=language('orders.status_unpay')?></a>
						<!-- <a hr-ef="<?=$this->query_string['list']?>&oStatus=wait" class="<?=$_GET['oStatus']=='wait'?'cur':''?>"><?=language('orders.status_wait')?></a> -->
						<a hr-ef="<?=$this->query_string['list']?>&oStatus=unshipping" class="<?=$_GET['oStatus']=='unshipping'?'cur':''?>"><?=language('orders.status_unshipping')?></a>
						<a hr-ef="<?=$this->query_string['list']?>&oStatus=finished" class="<?=$_GET['oStatus']=='finished'?'cur':''?>"><?=language('orders.status_finished')?></a>
						<a hr-ef="<?=$this->query_string['list']?>&oStatus=cancel" class="<?=$_GET['oStatus']=='cancel'?'cur':''?>"><?=language('orders.status_cancel')?></a>
					</div>
					<div class="search"><?php include c('dbs.inc').'/search.php';?></div>
				</div>
			</div>
		</div>
		<!--  -->
		
		<div class="ly_table_box">
			<table class="ly_table_list maxw">
				<thead>
					<tr>
						<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type="checkbox" all="[name=Id]" /></label></td>
						<td class="nowrap"><?=language('orders.number')?></td>
						<td class="nowrap"><?=language('orders.customer')?></td>
						<td class="nowrap"><?=language('orders.total_price')?></td>
						<td class="nowrap"><?=language('orders.status')?></td>
						<td class="nowrap"><?=language('orders.pay_status')?></td>
						<td class="nowrap"><?=language('orders.shipping_status')?></td>
						<td class="nowrap"><?=language('orders.products')?></td>
						<td class="nowrap"><?=language('orders.paytime')?></td>
						<td class="nowrap"><?=language('orders.addtime')?></td>
						<td class="w_1 sticky"></td>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($row as $k => $v) {
							$v = str::code($v);
							$address_info = str::code(db::result("select * from wb_orders_address where wb_orders_id='{$v['Id']}' and Type='shipping'"));
							$orders_products_qty = db::result("select sum(Qty) as a from wb_orders_products where wb_orders_id='{$v['Id']}'", 'a');
					?>
						<tr>
							<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type="checkbox" name='Id' value='<?=$v['Id']?>' /></label></td>	
							<td class="nowrap"><?=$v['OrderNumber']?></td>
							<td class="nowrap lh_2">
								<div class=""><?=$v['Email']?:$v['Phone']?></div>
								<div><?=str::real_name($address_info['FirstName'], $address_info['LastName'])?></div>
							</td>
							<td class="nowrap"><?=price::rate($v['TotalPrice'],3)?></td>
							<td class="nowrap">
								<?php
									if($v['Status'] == 5){
										echo '<div class="ly_btn_radius not-hover" size="mini" bg="light">'.language('orders.status_finished').'</div>';
									}else{
										echo '<div class="ly_btn_radius not-hover" size="mini" bg="warning-light">'.language('orders.status_not_finished').'</div>';
									}
								?>
							</td>
							<td class="nowrap">
								<?php
									if($v['PayTime']){
										echo '<div class="ly_btn_radius not-hover" size="mini" bg="light">'.language('orders.status_pay').'</div>';
									}else{
										echo '<div class="ly_btn_radius not-hover" size="mini" bg="warning-light">'.language('orders.status_unpay').'</div>';
									}
								?>
							</td>
							<td class="nowrap">
								<?php
									if($v['ShippingTime']){
										echo '<div class="ly_btn_radius not-hover" size="mini" bg="light">'.language('orders.status_shipping').'</div>';
									}else{
										echo '<div class="ly_btn_radius not-hover" size="mini" bg="warning-light">'.language('orders.status_unshipping').'</div>';
									}
								?>
							</td>
							<td class="nowrap">
								<div class="flex-middle2 pointer" data-orders-id="<?=$v['Id']?>">
									<span><?=str_replace('{{qty}}', (int)$orders_products_qty, language('orders.products_qty'))?></span>
									<i class="lyicon-arrow-down-bold ml_5px fz12"></i>
								</div>
							</td>
							<td class="nowrap"><?=$v['PayTime']?date('Y.m.d H:i:s',$v['PayTime']):'N/A'?><br><?=$v['Payment']?></td>
							<td class="nowrap"><?=date('Y.m.d H:i:s',$v['AddTime']);?></td>
							<td class="w_1 sticky width100">
								<div class="ly_gap_10px">
									<a class="ly_btn_round lyicon-file" bg="light" ly-tip-bubble="{}" data-tip-contents="<?=language('global.detail')?>" hr-ef="<?=$this->query_string['edit'].'&Id='.$v['Id']?>"></a>
								</div>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
		<div class="" ly-sticky="bottom">
			<div class="p_20px flex-right" bg="white"><?php include c('dbs.inc').'/paging.php';?></div>
		</div>
		
		<!--  -->
	</div>

</body>
</html>