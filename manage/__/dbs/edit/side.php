<?php
// 防止胡乱进入
function_exists('c')||exit;


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
				<?php 
					if ($this->dbg) {
						$row = $this->row = g($this->table);
					} else {
						$Id = (int)$_GET['Id'];
						$row = $this->row = str::code(db::result("select * from {$this->table} where Id='{$Id}'"));
					}
					foreach ($this->layout['field'] as $k => $v) {
						foreach ($v['field'] as $k1 => $v1) {
							echo $this->ed($k1, $row);
						}
					}
					foreach ($this->layout['right'] as $k => $v) {
						foreach ($v['field'] as $k1 => $v1) {
							echo $this->ed($k1, $row);
						}
					}
				?>
				<input type='hidden' name='Id' value='<?=$row['Id']?>'>
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

