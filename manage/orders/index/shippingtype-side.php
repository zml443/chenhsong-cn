<?php
// 防止胡乱进入
function_exists('c')||exit;

$wb_orders_id = (int)$_GET['wb_orders_id'];
$row = db::result("select * from wb_orders where Id='{$wb_orders_id}'");

$orders_shipping_address = db::result("select * from wb_orders_address where wb_orders_id='{$row['Id']}' and Type='shipping'");
$orders_shipping_address = str::code($orders_shipping_address);


$shipping = ly200::shipping_all_price(array(
    'weight' => $row['Weight'],
    'country' => $orders_shipping_address['Country'],
    'province' => $orders_shipping_address['Province'],
    'price' => $row['TotalPrice'],
    // 'lane' => $row['lang'],
));

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}

</style>

<body class="maxvh flex-column <?=$_GET['_popup_left_']?'flex-left':'flex-right'?>">
	<!-- 点击空白关闭 -->
	<div class="absolute max" hr-ef="back()"></div>
	<!-- 弹窗 -->
	<div class="wcb_alert_side relative flex-column">
		<!-- 顶部 -->
		<div class="sticky" style="top:0px">
			<?php $lyCssConf=[]; include c('dbs.inc').'title-side.php';?>
		</div>

		<!-- 中间 -->
		<div class="flex-1 scrollbar" style="height:0px" ajax-change="list">
			<form class="p_20px" lydbs-detail="" action='<?=$this->query_string['post'];?>'>
				<div class="mb_20px">请选择运输方式：</div>
				<label class="ly_input_suffix inline-flex width300" ly-drop-select data-type="radio">
					<input type="text" placeholder="请选择">
					<input type="hidden" name="wb_shipping_id" value="<?=$row['wb_shipping_id']?>">
					<i class="lyicon-arrow-down-bold"></i>
					<?php 
						$drop_data = array();
						foreach ($shipping as $k => $v) {
							$drop_data[] = array(
								'label' => $v['Name'],
								'value' => $v['Id'],
							);
						};
					?>
					<script type="text"><?=str::json($drop_data)?></script>
				</label>
				<!--  -->
				<input type='hidden' name='Id' value='<?=$row['Id']?>'>
				<!-- 以下是草稿专用字段 -->
				<input type='hidden' name='_save_copy_' value=''>
				<input type='hidden' name='_release_copy_' value=''>
			</form>
		</div>

		<!-- 底部 -->
		<div class="sticky" style="bottom:0px">
			<div class="p_20px flex-middle2" bg="default">
				<div class="ly_btn_radius width100 pointer2" bg="main" size="small" onclick="$('form[lydbs-detail]').submit()"><?=language('{/global.confirm/}')?></div>
				<div class="ly_btn_radius width100 ml_25px pointer2" bg="white" size="small" hr-ef="back()"><?=language('{/global.cancel/}')?></div>
			</div>
		</div>
	</div>


</body>
</html>

