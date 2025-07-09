<?php
function_exists('c')||exit();
$id = $_GET['Id'];
$this->row = db::result("select * from wb_site_nav where Id='$id'");
$this->row['Pictures'] = str::json($this->row['Pictures'], 'decode');
$this->row = str::code($this->row);
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
	<script type='text/javascript' src='/manage/site/nav/_js.js' ></script>
</head>

<body bg="default">
	
	<form class='maxvh2 flex-column _do_not_go_to_back' dbs='detail' action='<?=$this->query_string['post'];?>'>

		<!-- 头部 开始 -->
		<div class='fz16 flex-middle2 lh_1 p_30_0px' cw="<?=$_GET['_w_']?:'900'?>" bg="default">
			<i class="fz16 mr_5px lyicon-arrow-left-bold" hr-ef='back()'></i>
			<span hr-ef='back()'><?=permit::name();?></span>
			<span class="fz12 ml_20px flex-middle2" color="text3">
				<span class="mr_3px">/</span>
				<span><?=$this->is_add?language('{/global.add/}'):language('{/global.mod/}')?></span>
			</span>
		</div>
		<!-- 头部 结束 -->
		
		<!-- 开始 -->
		<div class="mb_20px flex-1" cw="<?=$_GET['_w_']?:'900'?>">
			<!--  -->
			<div class="_dbs_box maxw">
				<div class="_dbs_item ly-h4 flex-middle2 flex-between"><?=language('{/global.style/}')?></div>
				<div class="_dbs_item flex">
					<label class="zml_subnav_type flex-1 m-pic mr_15px">
						<img src="/static/images/nav/themes_type1.jpg" alt="">
						<input class="hide" type="radio" name="SubnavType" value="default" checked fn="zml_subnav_type_open" />
					</label>
					<label class="zml_subnav_type flex-1 m-pic mr_15px">
						<img src="/static/images/nav/themes_type2.jpg" alt="">
						<input class="hide" type="radio" name="SubnavType" value="picture" <?=$this->row['SubnavType']=='picture'?'checked':''?> fn="zml_subnav_type_open" />
					</label>
					<div class="flex-1"></div>
				</div>
			</div>
			<!-- end -->
			<!--  -->
			<div class="_dbs_box picture_box hide2">
				<div class="_dbs_item ly-h4"><?=language('{/global.picture/}')?></div>
				<div class="_dbs_item">
					<div class="subnav_pic_data"><script><?=str::json($this->row['Pictures'])?></script></div>
				</div>
			</div>
			<!-- end -->
		</div>
		<!-- 结束 -->
				
		<!--  -->
		<div class='_dbs_submit' ly-sticky="bottom">
			<div class=" flex-max2">
				<?php if (!$_GET['notback']) { ?>
					<label class='ly_btn min-width90 mr_30px pointer' hr-ef='back()'><?=language('{/global.back/}')?></label>
				<?php } ?>
				<?php if (!$this->set['NotSave']) { ?>
					<label class='ly_btn min-width90 pointer' bg="main"><input type='submit'><?=language('{/global.submit/}')?></label>
				<?php } ?>
			</div>
		</div>
		<!--  -->
		<input type='hidden' name='Id' value='<?=$this->row['Id']?>'>
		<input type='hidden' name='_incomplete_' value='1'>
	</form>


</body>
</html>