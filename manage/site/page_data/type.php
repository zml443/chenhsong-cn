<?php
function_exists('c') || exit;
$web_cur = db::result("select * from wb_site_web order by `Release` desc,Used desc limit 1");
if (!$web_cur) {
	js::location('/manage/?ma=website/module','','top');
}
?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body bg="default">

	<?php $lyCssConf=['class'=>'p_30_0px', 'cw'=>'1200']; include c('dbs.inc').'title.php'; ?>

	<div class="mb_20px flex-middle2" bg="white" cw="1200" style="padding:20px;">
		<div class="mr_20px"><?=language('panel.mainColor')?></div>
		<input class="ly_input" type='text' value='<?=g('website.mainColor')?>' size="small" color-selector="" fn="color_selector" />
		<div class="flex-1"></div>
		<?php if (c('FnType.truncate')) { ?>
			<div class="TRUNCATE pointer" color="main">清空草稿</div>
		<?php } ?>
	</div>

	<div class="" cw="1200" bg="white">
		<div class="themes_mdl flex-middle2 flex-between">
			<div class="view relative">
				<?php $web = lydb::result("select * from ss_web where Number='{$web_cur['Number']}' limit 1"); ?>
				<div class="view_pc absolute max over"><img src="<?=$web['Picture']?>" width="100%"></div>
				<div class="view_modile absolute over"><img src="<?=$web['PictureMobile']?>" width="100%"></div>
			</div>
			<div class="info flex-max">
				<div class="name"><?=$web['Number']?></div>
				<div class="time mt_10px mb_10px"><?=language('{/global.last_mod_time/}')?>：<?=date('Y-m-d H:i:s', $web_cur['EditTime'])?></div>
				<a class="btn bianjizhandiancaogao ly_btn" bg="main" data-id="<?=$web_cur['Id']?>"><?=language('{/global.edit/}')?></a>
				<?php if (c('HostType')=='saas') { ?>
					<div class="xuan_ze_feng_ge btn ly_btn pointer mt_10px" bg="light"><?=language('{/global.change_type/}')?></div>
				<?php } ?>
			</div>
		</div>
	</div>

	<script>
		$(document).on('click', '.TRUNCATE', function(){
			WP.$.alert({
				str: `<span color="red">清空草稿后，将无法恢复！</span>需要重新选择网站风格，重新编辑可视化内容，是否继续？`,
				wh:[400,0],
				confirm(alert_el){
					$.async('POST', '/manage/?ma=website/data/web_truncate', {x:1}, result=>{
						WP.$.alert(result.msg, 3000);
					}, 'json');
				}
			});
		});
		var color_selector = {
			confirm(el, color){
				$.async('POST', '/manage/?ma=website/data/web_color', {color:color.rgb}, result=>{
					WP.$.alert(result.msg, 3000);
				}, 'json');
			}
		}
		$(document).on('click', '.xuan_ze_feng_ge', function(){
			WP.$.iframeBox({
				url: '/manage/?ma=website/module&_w_=1',
			});
		});
	</script>


	<div class="mt_30px mb_30px" cw="1200" bg="white">
		<?php
		$web_row = db::query("select * from wb_site_web order by Used desc,Id desc");
		while ($v = db::result($web_row)) {
		?>
		<div class="themes_web flex-middle2 p_20px">
			<div class="name flex-1"><?=$v['Number']?></div>
			<span class="mr_50px" color="main"><?=$v['Release']?language('{/global.used2/}'):'';?></span>
			<span class="mr_50px" color="text3"><?=date('Y-m-d H:i:s', $v['AddTime']);?></span>
			<a 
				class="edit bianjizhandiancaogao ly_btn_round lyicon-bianji" bg='light'
				data-id="<?=$v['Id']?>" 
				ly-tip-bubble='{direction:top_center}' 
				data-tip-contents='<?=language('{/global.edit/}')?>'>
			</a>
			<a 
				class="fabu fabucaogao ly_btn_round ml_20px lyicon-fabu" bg='light'
				data-id="<?=$v['Id']?>"  
				ly-tip-bubble='{direction:top_center}' 
				data-tip-contents='<?=language('{/global.release/}')?>'>
			</a>
		</div>
		<?php } ?>
	</div>
	<script>
		// 编辑
		$(document).on('click', ".bianjizhandiancaogao", function(){
			var el = $(this);
			var data = {
				Id: el.attr('data-id')
			};
			$.async('POST', "/manage/?ma=website/data/web_restore", data, result=>{
				if (result.ret==1) {
					window.top.location.href = '/manage/?ma=website/index';
				} else {
					WP.$.alert(result.msg, 2500);
				}
			}, 'json');
		});
		// 发布
		$(document).on('click', ".fabucaogao", function(){
			var el = $(this);
			var data = {
				Id: el.attr('data-id')
			};
			$.async('POST', "/manage/?ma=website/data/web_release", data, result=>{
				WP.$.alert(result.msg, 2500);
			}, 'json');
		});
	</script>
	
</body>
</html>