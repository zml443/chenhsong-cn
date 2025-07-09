<?php
// 防止恶意进入
function_exists('c')||exit;
// 

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
			<span hr-ef="back()">订单关联/添加订单</span>
		</div>
		<!-- 结束 -->

		<!-- 开始 -->
		<div class="orders_index_add_step et_orders_ly_step ly_step p_30_0px" align="center" size="mini" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class="cur">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div>添加产品清单</div>
				</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div>添加顾客收货信息</div>
				</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">
					<div>计算价格和付款</div>
				</div>
			</div>
		</div>
		<!-- 结束 -->

		<!-- 开始 -->
		<div class="orders_index_add_tab_box" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class=""><?php include c('root').'manage/orders/index/add/1.php'; ?></div>
			<div class="hide2"><?php include c('root').'manage/orders/index/add/2.php'; ?></div>
			<div class="hide2"><?php include c('root').'manage/orders/index/add/3.php'; ?></div>
		</div>
		<!-- 结束 -->
	</form>
	
	<div ly-sticky="bottom">
		<div class="orders_index_add_tab_con p_20px flex-right" bg="white">
			<div class="">
				<a class="ly_btn_radius pointer" hr-ef="back()">返回</a>
				<div class="ly_btn_radius pointer ml_10px" bg="main" onclick="orders_index_add.page.tab(1)">下一步</div>
			</div>
			<div class="hide2">
				<div class="ly_btn_radius pointer" onclick="orders_index_add.page.tab(0)">上一步</div>
				<div class="ly_btn_radius pointer ml_10px" bg="main" onclick="orders_index_add.page.tab(2)">下一步</div>
			</div>
			<div class="hide2">
				<div class="ly_btn_radius pointer" onclick="orders_index_add.page.tab(1)">返回</div>
				<div class="ly_btn_radius pointer ml_10px" bg="main" onclick="orders_index_add.page.submit()">确认</div>
			</div>
		</div>
	</div>

</body>
</html>
<script>$.include('<?=file::self_dir(__FILE__)?>/add.js');</script>