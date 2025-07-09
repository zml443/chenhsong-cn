<?php
isset($c) || exit;

?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>
<body class="pt_30px pb_30px pl_30px pr_30px">

		<!-- --------------------------------------------------------------- -->
		<div class="ly_step">
			<div class="cur next-cur">
				<div class="ly_step_bar"><i>1</i></div>
				<div class="ly_step_text">已發貨已發貨已發貨</div>
			</div>
			<div class="cur">
				<div class="ly_step_bar"><i>2</i></div>
				<div class="ly_step_text">運輸中運輸中運輸中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>3</i></div>
				<div class="ly_step_text">派送中派送中派送中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>4</i></div>
				<div class="ly_step_text">已簽收已簽收已簽收</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>5</i></div>
				<div class="ly_step_text">已簽收已簽收已簽收</div>
			</div>
		</div>

		<div class="ly_step width450 mt_30px" size="small">
			<div class="cur next-cur">
				<div class="ly_step_bar"><i>1</i></div>
				<div class="ly_step_text">已發貨</div>
			</div>
			<div class="cur">
				<div class="ly_step_bar"><i>2</i></div>
				<div class="ly_step_text">運輸中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>3</i></div>
				<div class="ly_step_text">派送中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>4</i></div>
				<div class="ly_step_text">已簽收</div>
			</div>
		</div>

		<div class="ly_step width300 mt_30px" size="mini">
			<div class="cur next-cur">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">已發貨</div>
			</div>
			<div class="cur">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">運輸中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">派送中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i></i></div>
				<div class="ly_step_text">已簽收</div>
			</div>
		</div>


		<div class="ly_step width450 mt_30px" align="center">
			<div class="cur next-cur">
				<div class="ly_step_bar"><i>1</i></div>
				<div class="ly_step_text">已發貨已發貨</div>
			</div>
			<div class="cur">
				<div class="ly_step_bar"><i class="lyicon-fabu"></i></div>
				<div class="ly_step_text">運輸中運輸中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>3</i></div>
				<div class="ly_step_text">派送中派送中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>4</i></div>
				<div class="ly_step_text">已簽收已簽收已簽收</div>
			</div>
		</div>

		<div class="ly_step width450 mt_30px fr" align="right">
			<div class="cur next-cur">
				<div class="ly_step_bar"><i>1</i></div>
				<div class="ly_step_text">已發貨已發貨</div>
			</div>
			<div class="cur">
				<div class="ly_step_bar"><i>2</i></div>
				<div class="ly_step_text">運輸中運輸中</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>3</i></div>
				<div class="ly_step_text">
					<div>adasd</div>
					<div>adasd</div>
				</div>
			</div>
			<div class="">
				<div class="ly_step_bar"><i>4</i></div>
				<div class="ly_step_text">已簽收已簽收已簽收</div>
			</div>
		</div>

		<div class="clean"></div>
		<!-- --------------------------------------------------------------- -->




		<div class="ly_history">
			<!--  -->
			<div class="cur">
				<div class="ly_history_time" color="text3">
					<?=date('Y-m-d')?><br/>
					<?=date('H:i:s')?>
				</div>
				<div class="ly_history_point"><i></i></div>
				<div class="ly_history_text">
					<div>已通过 Cash On Delivery 处理 101.00 USD 的付款。</div>
					<div color="text3">(管理员) uee18665946544</div>
				</div>
			</div>
			<!--  -->
			<div class="">
				<div class="ly_history_time" color="text3">
					<?=date('Y-m-d')?><br/>
					<?=date('H:i:s')?>
				</div>
				<div class="ly_history_point"><i></i></div>
				<div class="ly_history_text">
					<div>已通过 Cash On Delivery 处理 101.00 USD 的付款。</div>
					<div color="text3">(管理员) uee18665946544</div>
				</div>
			</div>
			<!--  -->
		</div>




</body>
</html>