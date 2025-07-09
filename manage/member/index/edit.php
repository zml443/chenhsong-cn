<?php
$Id = (int)$_GET['Id'];
$this->row = db::get_one('wb_member',"Id='{$Id}'");
$this->row = str::code($this->row);
if (!$this->row) {
	return '';
}
// 子账号数量
$sunUserCount = db::get_row_count('wb_member', "wb_member_id='$Id'");

// 发货信息
$shipping_address = db::result("select * from wb_member_address where wb_member_id='{$Id}' and Type='shipping' order by IsDefault desc");
$shipping_address = str::code($shipping_address);

$billing_address = db::result("select * from wb_member_address where wb_member_id='{$Id}' and Type='billing' order by IsDefault desc");
$billing_address = str::code($billing_address);
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
	<script type='text/javascript' src='/manage/member/index/_js.js' ></script>
</head>

<body bg="default">
	
	<form class='maxvh2 flex-column' dbs='detail' action='<?=$this->set['query_string']['post'];?>' data-gotourl="<?=$this->set['query_string']['list']?>">
		

		<!-- 头部 开始 -->
		<ul cw="<?=$_GET['_w_']?:'1300'?>">
			<li class="p_30_0px flex-between" bg="default">
				<?php $lyCssConf=[]; include c('dbs.inc').'title-edit.php'; ?>
				<?php $lyCssConf=[]; include c('dbs.inc').'lang.php'; ?>
			</li>
		</ul>
		<!-- 头部 结束 -->
		
		<!-- 开始 -->
		<div class="flex-between flex-wrap flex-1 mb_20px" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class='content_left flex-column'>
				<!-- 订单基础信息 开始 -->
				<div class="_dbs_box maxw" ajax-change="info">
					<div class="_dbs_item flex-middle2 flex-between">
						<div class="ly-h4"><?=language('dbs.group.base')?></div>
						<!-- <a class="xiu_gai_huiyuan" color="main" data-id="<?=$this->row['Id']?>"><?=language('global.mod')?></a> -->
						<a color="main" hr-ef="?ma=member/index&e=side&Id=<?=$this->row['Id']?>&_popup_right_=1" is-end-flush="info"><?=language('global.mod')?></a>
					</div>
					<div class="_dbs_item gai_bian_huiyuanxinxi">
						<div class="fz14 mb_10px"><?=str::real_name($this->row['FirstName'], $this->row['LastName'])?></div>
						<div class="fz14 mb_10px"><?=$this->row['Email']?></div>
						<div class="flex-middle2">
							<?php
								if(0){
									echo '<div class="ly_main_tag mr_15px" size="mini">'.language('member.developers').'</div>';
								}
								if(0){
									echo '<div class="ly_main_tag mr_15px" size="mini">'.language('member.direct_visit').'</div>';
								}
							?>
						</div>
					</div>
				</div>
				<!-- 订单基础信息 结束 -->


				<!-- 子账号 开始 -->
				<div class="_dbs_box maxw">
					<div class="_dbs_item flex-middle2 flex-between">
						<div class="ly-h4">子账号</div>
						<a class="" color="main" hr-ef="?ma=member/index&wb_member_id=<?=$this->row['Id']?>&_alert_side_=1&_w_=1200" is-end-flush="zizhanghao"><?=language('global.edit')?></a>
					</div>
					<div class="_dbs_item gai_bian_huiyuanxinxi" ajax-change="zizhanghao">
						拥有子账号 <span class="m_0_5px" color="main"><?=$sunUserCount?></span> 个
					</div>
				</div>
				<!-- 子账号 结束 -->


				<!-- 订单基础信息 开始 -->
				<div class="_dbs_box maxw">
					<div class="_dbs_item ly-h4"><?=language('member.buy_info')?></div>
					<div class="_dbs_item flex-between">
						<div class="ly_tip p_20px flex-1">
							<div class="mb_15px"><?=language('member.buy_qty')?></div>
							<strong class="fz24">0</strong>
						</div>
						<div class="ly_tip p_20px flex-1 ml_10px">
							<div class="mb_15px"><?=language('member.goods_qty')?></div>
							<strong class="fz24">0</strong>
						</div>
						<div class="ly_tip p_20px flex-1 ml_10px">
							<div class="mb_15px"><?=language('member.price_sum')?></div>
							<strong class="fz24"><?=price::rate(0)?></strong>
						</div>
					</div>
				</div>
				<!-- 订单基础信息 结束 -->

				<!-- 订单产品 开始 -->
				<div class="_dbs_box flex-1">
					<div class="_dbs_item ly-h4"><?=language('member.orders_last')?></div>
					<div class="_dbs_item">
						<div class="height200 flex-max"><img src="/images/global/null2.png" alt=""><span><?=language('member.orders_null')?></span></div>
					</div>
				</div>
				<!-- 订单产品 结束 -->
				
			</div>

			<div class='content_right'  ly-sticky="center">
				<!-- 顾客行为 开始 -->
				<div class="_dbs_box">
					<div class="_dbs_item ly-h4"><?=language('member.customer_behavior')?></div>
					<div class="_dbs_item">
						<div class="ly_tip p_20px">
							<div class="mb_15px flex-between">
								<span><?=language('member.add_cart')?><span color="text3">(<?=language('member.goods')?>)</span></span>
								<a color="main" href=""><?=language('global.detail')?></a>
							</div>
							<div class="fz24">0</div>
						</div>
						<div class="ly_tip p_20px mt_10px">
							<div class="mb_15px flex-between">
								<span><?=language('member.collect_add')?><span color="text3">(<?=language('member.goods')?>)</span></span>
								<a color="main" href=""><?=language('global.detail')?></a>
							</div>
							<div class="fz24">0</div>
						</div>
					</div>
				</div>
				<!-- 顾客行为 结束 -->

				<!-- 顾客行为 开始 -->
				<div class="_dbs_box">
					<div class="_dbs_item ly-h4"><?=language('dbs.group.detail')?></div>
					<div class="_dbs_item">
						<table class="ly_table_edit lh_1_8">
							<tr>
								<td><?=language('member.register_time')?></td>
								<td><?=date('Y-m-d H:i:s', $this->row['AddTime'])?></td>
							</tr>
							<tr>
								<td><?=language('member.register_ip')?></td>
								<td>
									<?php 
										$ipinfo = ip::info($this->row['Ip']);
										echo $ipinfo['ip'] ."【".$ipinfo['country'].$ipinfo['province'].$ipinfo['city']."】";
									?>
								</td>
							</tr>
							<?php if ($this->row['data_number_login']) { ?>
								<tr>
									<td class="v-top"><?=language('member.login_last')?></td>
									<td>
										<div><?=date('Y-m-d H:i:s', $this->row['LastLoginTime'])?></div>
										<div>
										<?php 
											$ipinfo = ip::info($this->row['LastLoginIp']);
											echo $ipinfo['ip'] ."【".$ipinfo['country'].$ipinfo['province'].$ipinfo['city']."】";
										?>
										</div>
									</td>
								</tr>
								<tr>
									<td><?=language('member.login_qty')?></td>
									<td><?=$this->row['data_number_login']?></td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
				<!-- 顾客行为 结束 -->

				<!-- 收货地址 开始 -->
				<div class="_dbs_box">
					<div class="_dbs_item flex-middle2">
						<div class="ly-h4 flex-1"><?=language('form.shipping')?></div>
						<a hr-ef="?ma=member/address&wb_member_id=<?=$this->row['Id']?>&Type=shipping&_alert_side_=1" is-end-flush="" color="text3"><?=language('global.more')?></a>
					</div>
					<div class="_dbs_item" ajax-change="address">
						<div class="ly_tip p_20px mb_15px">
							<i class="fz30 lyicon-map-filling" color="text3"></i>
							<div class="lh_1_8 fz14 mt_15px gai_bian_ding_da_di_zhi">
								<div class=""><span class="pr_10px"><?=language('form.name')?>:</span><span><?=str::real_name($shipping_address['FirstName'], $shipping_address['LastName'])?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.phone')?>:</span><span><?=$shipping_address['Phone']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.address')?>:</span><span><?=$shipping_address['Country']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.province')?>:</span><span><?=$shipping_address['Province']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.city')?>:</span><span><?=$shipping_address['City']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.address')?>:</span><span><?=$shipping_address['Address']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.postcode')?>:</span><span><?=$shipping_address['Postcode']?:'-'?></span></div>
							</div>
						</div>
					</div>
				</div>
				<!-- 收货地址 结束 -->

				<!-- 收货地址 开始 -->
				<div class="_dbs_box">
					<div class="_dbs_item flex-middle2">
						<div class="ly-h4 flex-1"><?=language('form.billing')?></div>
						<a hr-ef="?ma=member/address&wb_member_id=<?=$this->row['Id']?>&Type=billing&_edit_insert_=1&_alert_side_=1" is-end-flush="" color="text3"><?=language('global.more')?></a>
					</div>
					<div class="_dbs_item" ajax-change="billing">
						<div class="ly_tip p_20px mb_15px">
							<i class="fz30 lyicon-map-filling" color="text3"></i>
							<div class="lh_1_8 fz14 mt_15px gai_bian_ding_da_di_zhi">
								<div class=""><span class="pr_10px"><?=language('form.name')?>:</span><span><?=str::real_name($billing_address['FirstName'], $billing_address['LastName'])?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.phone')?>:</span><span><?=$billing_address['Phone']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.address')?>:</span><span><?=$billing_address['Country']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.province')?>:</span><span><?=$billing_address['Province']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.city')?>:</span><span><?=$billing_address['City']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.address')?>:</span><span><?=$billing_address['Address']?:'-'?></span></div>
								<div class=""><span class="pr_10px"><?=language('form.postcode')?>:</span><span><?=$billing_address['Postcode']?:'-'?></span></div>
							</div>
						</div>
					</div>
				</div>
				<!-- 收货地址 结束 -->
				
			</div>
		</div>
		<!-- 结束 -->
	</form>


</body>
</html>