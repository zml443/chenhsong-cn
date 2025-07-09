<?php
// 防止恶意进入
function_exists('c')||exit;


// $this->where = '1';
// 取消订单
if ($_GET['CancelStatus']) {
	$this->where .= " and CancelStatus='{$_GET['CancelStatus']}'";
}
// 状态
switch ($_GET['oStatus']) {
	case 'unpay':
		$this->where .= " and PayTime=0";
		break;
	case 'pay':
		$this->where .= " and PayTime>0";
		break;
	case 'wait':
		$this->where .= " and Status in(2)";
		break;
	case 'unshipping':
		$this->where .= " and ShippingTime=0";
		break;
	case 'finished':
		$this->where .= " and Status=5";
		break;
	case 'cancel':
		$this->where .= " and CancelStatus=1";
		break;
}

$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;
$this->row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
$this->total = db::get_row_count($this->table, $this->where);


?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">
	<div class="mt_20px p_20px b-bottom flex-between" cw="<?=$_GET['_w_']?>"  bg="white">
		<div class="ly-h3"><?=language('{/menu.orders.module_name/}')?></div>
		<div class="ly_btn_group_radius">
			<a hr-ef="<?=$this->query_string['list']?>" class="<?=!$_GET['oStatus']?'cur':''?>"><?=language('global.all')?></a>
			<a hr-ef="<?=$this->query_string['list']?>&oStatus=unpay" class="<?=$_GET['oStatus']=='unpay'?'cur':''?>"><?=language('orders.status_unpay')?></a>
			<a hr-ef="<?=$this->query_string['list']?>&oStatus=pay" class="<?=$_GET['oStatus']=='pay'?'cur':''?>"><?=language('orders.status_unpay')?></a>
			<!-- <a hr-ef="<?=$this->query_string['list']?>&oStatus=wait" class="<?=$_GET['oStatus']=='wait'?'cur':''?>"><?=language('orders.status_wait')?></a> -->
			<a hr-ef="<?=$this->query_string['list']?>&oStatus=unshipping" class="<?=$_GET['oStatus']=='unshipping'?'cur':''?>"><?=language('orders.status_unshipping')?></a>
			<a hr-ef="<?=$this->query_string['list']?>&oStatus=finished" class="<?=$_GET['oStatus']=='finished'?'cur':''?>"><?=language('orders.status_finished')?></a>
			<a hr-ef="<?=$this->query_string['list']?>&oStatus=cancel" class="<?=$_GET['oStatus']=='cancel'?'cur':''?>"><?=language('orders.status_cancel')?></a>
		</div>
	</div>

	<div class="mb_20px" bg="white" cw="100%">
		<div class="" ly-sticky="top">
			<div class="ly_zindex21" bg="white">
				<div class="flex-between p_20px">
					<?php $lyCssConf=[]; include c('dbs.inc').'search.php';?>
					<?php $lyCssConf=[]; include c('dbs.inc').'tool.php';?>
				</div>
				<div class="p_20px pt_0px"><?php $lyCssConf=[]; include c('dbs.inc').'search_xz.php';?></div>
			</div>
		</div>
		<!--  -->
		<!-- 系统表格 -->
		<section class="ly_table_box">
			<table class='ly_table_list maxw'>
				<thead>
					<tr>
						<td class="width70 sticky relative"><?php $lyCssConf=[]; include c('dbs.inc').'id-all.php';?></td>
						<?php if ($this->permit['myorder']) { ?><td d='myorder'><?=language('{/global.my_order/}')?></td><?php } ?>
						<?php foreach ($this->layout as $k => $v) { ?>
							<td class="nowrap <?=$v['class']?>" d="<?=strtolower($k)?>"><?=$v['name']?></td>
						<?php } ?>
						<?php if ($this->table_copy) { ?><td></td><?php } ?>
						<?php if ($this->permit['_ope']) { ?><td class="sticky"></td><?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($this->row as $k => $v) {
							$v = str::code($v);
							if ($this->table_copy) {
								$v_status = '<span color="success">'.language('{/global.release2/}').'</span>';
								if ($v['IsUnpublished']) {
									$v_status = '<span color="main">'.language('{/global.update2/}').'</span>';
								}
							}
					?>
						<tr>
							<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold ly_table_strip_ml" size="big"><input type='checkbox' name='Id' value='<?=$v['Id']?>'></label></td>
							<?php if ($this->permit['myorder']) { ?><td class="w_1 sticky"><?=$this->li('_MyOrder', $v)?></td><?php } ?>
							<?php foreach ($this->layout as $k1 => $v1) { ?>
								<td class="<?=$v1['class']?>">
									<?php
										$ki = 0;
										foreach ($v1['field'] as $k2 => $v2) {
											echo "<div class='".($ki?'mt_10px':'')."'>".$this->li($k2, $v)."</div>";
											$ki++;
										}
									?>
								</td>
							<?php } ?>
							<?php if ($this->table_copy) { ?><td class="w_1"><?=$v_status;?></td><?php } ?>
							<?php if ($this->permit['_ope']) { ?><td class="w_1 width200 sticky"><?=$this->li('_Ope', $v)?></td><?php } ?>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</section>


		<div class="" ly-sticky="bottom">
			<div class="p_20px flex-right" bg="white"><?php include c('dbs.inc').'/paging.php';?></div>
		</div>
		<!--  -->
	</div>

</body>
</html>