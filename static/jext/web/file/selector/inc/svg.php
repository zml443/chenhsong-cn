<?php
include '../../../../php/init.php';

?><!DOCTYPE html>
<html lang='zh-cn'>
<head>
	<meta charset='utf-8' language='<?=c('manage.lang');?>' website-language='<?=c('language');?>' />
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1' />
	<link href='../../../../css/lyicon/iconfont.css' rel='stylesheet' type='text/css' />
	<link href='../../../../css/global.css' rel='stylesheet' type='text/css' />
	<link href='../../../../css/ly2ui.css' rel='stylesheet' type='text/css' />
	<script src='../../../../a.js'></script>
	<script src='../../../../b.js'></script>
	<script>
		$.language.cur = '<?=c('manage.lang')?>';
		$.lang = <?=str::json(include c('language_pack').c('manage.lang').'/0.php')?>
	</script>
	<style>
		body,html{background:transparent;}
		.wcb_alert_box{width: 90vw;height: 90vh;position: relative;max-width: 1440px;max-height: 900px;overflow: hidden;border-radius: 10px;background: #fff;}
	</style>
	<link href='list.css' rel='stylesheet' type='text/css' />
</head>
<body class="flex-max maxvh">

	<div class="wcb_alert_box flex-column">
		<div class="wcb_alert_title">
			<div class="">文件选择器</div>
			<div class="at-close lyicon-guanbi pointer"></div>
		</div>
		<!--  -->
		<div class="flex relative flex-1" style="height: 0;">
			<div class="wcb_alert_menu flex-column"></div>
			<!--  -->
			<div class="wcb_alert_list flex-column flex-1 fz14"></div>
			<!--  -->
		</div>
		<!-- 底部按钮 -->
		<div class="wcb_alert_btn flex-middle2 flex-right">
			<div class="number flex-1"><span class="n">0</span> / <span class="m"></span></div>
			<div class="at-confirm fix">确认</div>
		</div>
	</div>
	<script>
		$(document).on('click', '.wcb_alert_menu_li, .category_nav_li', function(){
			var el = $(this);
			svglist._list({
				type: el.attr('data-type'),
				tag: el.attr('data-tag'),
				label: el.attr('data-label'),
				weight: el.attr('data-weight')
			});
		});
		var bendi = {};
		var returnResult = [];
		// bendi.files 数据拦截
		// ==============================================================================
		// 通过id删除文件
		bendi.filesDeleteId = (ids)=>{
			for (var i=0; i<returnResult.length;i++) if (ids.indexOf(returnResult[i].id)>=0) {
				returnResult.splice(i,1);
				i--;
			}
			bendi.filesChange();
		};
		// 更换添加文件
		bendi.filesChange = (data, x, y)=>{
			if (y) {
				returnResult.splice(x[0], 1);
			} 
			if (data) if (x) {
				returnResult.splice(x[0], 0, data);
			} else {
				returnResult.push(data);
			}
			// 改变勾选的数目
			$('.wcb_alert_btn .number .n').html(returnResult.length);
		};
		// ==============================================================================

		var choiceSvg = {
			click(el, checked){
				var val = el.val();
				var path = el.attr('data-file');
				if(checked) {
					bendi.filesChange({id:val, path:path});
				} else {
					bendi.filesDeleteId([val]);
				}
			}
		};
		var svglist = {
			_left(result){
				var menu = `
					<div class="text-center pt_20px">
						${(()=>{
							var x = '';
							for (var i in result.dir) {
								var v = result.dir[i];
								x += `<div class='wcb_alert_menu_li pointer mt_20px ${v._cur_?'cur':''}' data-type="${i}" data-tag="${v.tag}" data-weight="${v.weight}">${v.name}</div>`;
							}
							return x;
						})()}
					</div>
				`;
				$('.wcb_alert_menu').html(menu);
			},
			_right(result){
				var cont = `
					<div class="quanbuwenj scrollbar flex-1 maxw p_0_20px pb_20px">
						<div class="category_nav flex-middle2 pt_20px">
							${(()=>{
								var x = '';
								for (var i in result.dir) {
									var v = result.dir[i];
									if (v._cur_) for (var j in v.label) {
										var v2 = v.label[j];
										x += `<div class='category_nav_li pointer ${v2._cur_?'cur':''}' data-type="${i}" data-label="${j}" data-tag="${v.tag}" data-weight="${v.weight}">${v2.name}</div>`;
									}
								}
								return x;
							})()}
						</div>
						<div class="bendi_file_span_box flex-wrap">
							${result.list.map(v1=>{
								return `
								<label class='wcb_fileitem file'>
									<input type='checkbox' name='Id[]' class='hide' value='${v1.path}' data-file='${v1.path}' fn="choiceSvg" />
									<div class='img notcopy choice'>
										<div class="absolute max m-pic"><img class="svg" src='${v1.path}' big-img='${v1.path}' /></div>
										<div class="is_check lyicon-select-bold"></div>
									</div>
								</label>
								`;
							}).join('')}
						</div>
					</div>
				`;
				$('.wcb_alert_btn .number .m').html(result.list.length);
				$('.wcb_alert_list').html(cont);
			},
			_get(){
				$.async('POST', '/manage/?ma=jext/svg/_list', {all:1}, result => {
					this._left(result);
					this._right(result);
				}, 'json');
			},
			_list(data){
				$.async('POST', '/manage/?ma=jext/svg/_list', data, result => {
					this._left(result);
					this._right(result);
				}, 'json');
			}
		};
		svglist._get();
	</script>

</body>
</html>