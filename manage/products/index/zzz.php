<?php
// 防止胡乱进入
function_exists('c')||exit;

// 获取字段名
if ($this->dbc['Picture']) {
	$picture_name = 'Picture';
} else if ($this->dbc['Pictures']) {
	$picture_name = 'Pictures';
} else {
	$picture_name = '';
}
if ($this->dbc['Name']['Lang']) {
	$title_name = ln('Name');
} else {
	$title_name = 'Name';
}
// end

$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;

$this->row = db::get_limit($this->table, $this->where, '*', $this->orderby, $pg*$this->limit, $this->limit);
$this->total = db::get_row_count($this->table, $this->where);

// 已选择的数据
$choice_ids = explode(',',$_GET['_choice_ids']);
foreach($choice_ids as &$v){ $v = (int)$v; }
$current = db::get_all($this->table, 'Id in('.implode(',',$choice_ids).')', '*', $this->orderby);

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}
.wcb_alert_box { width: 90vw; height: 90vh; position: relative; max-width: 1200px; max-height: 760px; overflow: hidden; border-radius: 5px; background: #fff; }

/* 顶部标题部分 */
.wcb_alert_title{height: 60px;display: flex;justify-content: space-between;align-items: center;padding: 0 30px;border-bottom: 1px solid #e0e3e5;background: #fff;font-size: 16px;}
.wcb_alert_title .at-close{font-size: 24px;}

/* 中间列表部分 */
.wcb_alert_list{background: #fff;max-height: calc(90vh - 200px - 55px);border-radius: 5px;overflow: hidden;}
</style>

<body class="maxvh flex-max" style="background:rgba(0,0,0,.3)">
	<div class="wcb_alert_box flex-column">
		<script class="wcb_alert_box_init_data" type="text"><?=str::json($current)?></script>
		<!-- 顶部标题 -->
		<div class="wcb_alert_title">
			<div class="">选择器22222222222</div>
			<div class="at-close lyicon-guanbi pointer"></div>
		</div>
		<!-- 中间区域 -->
		<div class="flex relative flex-1 p_20px" ajax-change="list">
			<!-- 右侧栏 -->
			<div class="wcb_alert_list flex-column flex-1 fz14">
				<!-- 搜索 -->
				<div class="" bg="white">
					<div class="" ly-sticky="top">
						<div class="pb_20px pr_5px flex-middle2" bg="white">
							<?php $lyCssConf=[]; include c('dbs.inc').'search_xz.php';?>
							<div class="flex-1"></div>
							<?php $lyCssConf=[]; include c('dbs.inc').'search.php';?>
						</div>
					</div>
				</div>
				<!-- 列表 -->
				<div class='flex-1 scrollbar maxw maxh'>
					<div class="bendi_file_span_box flex-wrap <?=$has_picture?'':'no_picture'?>">
						<?php if($picture_name){ ?>
							<?php foreach($this->row as $k => $v){ ?>
								<label class='wcb_fileitem xxxxxxxxLI' data-id="<?=$v['Id']?>">
									<input type='checkbox' name='Id[]' <?=in_array($v['Id'],$choice_ids)?'checked':''?> class='hide' value='<?=$v['Id']?>' data-path="<?=img::get($v[$picture_name])?>" data-name="<?=$v[$title_name]?>" fn="bendi.choice" />
									<div class='img notcopy choice'>
										<div class="absolute max m-pic"><img src='<?=img::get($v['Pictures'])?>' /></div>
										<div class="is_check lyicon-select-bold"></div>
									</div>
									<div class="filename" data-id="<?=$v['Id']?>" stopPropagation><?=$v[$title_name]?></div>
								</label>
							<?php } ?>
						<?php }else{ ?>
							<?php foreach($this->row as $k => $v){ ?>
								<label class='wcb_fileitem_nopic xxxxxxxxLI' data-id="<?=$v['Id']?>">
									<input type='checkbox' name='Id[]' <?=in_array($v['Id'],$choice_ids)?'checked':''?> class='hide' value='<?=$v['Id']?>' data-name="<?=$v[$title_name]?>" fn="bendi.choice" />
									<div class="filename flex" data-id="<?=$v['Id']?>">
										<div class="is_check lyicon-select-bold"></div>
										<?=$v[$title_name]?>
									</div>
								</label>
							<?php } ?>
						<?php } ?>
					</div>
					<!-- end -->
					<div class="bendi_file_page">
						<?php $lyCssConf=['class'=>'flex-right p_20px fz12', 'bg'=>'white']; include c('dbs.inc').'paging.php';?>
					</div>
					<!-- end -->
				</div>
				<!--  -->
			</div>
		</div>

		<!-- 底部按钮 -->
		<div class="wcb_alert_btn flex-middle2 flex-between">
			<div class="file_ckeck_list_box flex-middle2 relative">
				<div class="file_ckeck_list flex-middle2"></div>
			</div>
			<div class="file_ckeck_list_num flex-1 hide2">
				<span></span>
			</div>
			<div class="wcb_alert_btn_submit at-confirm flex-btn" bg="main" color="white"><?=language('{/global.confirm/}')?></div>
		</div>

	</div>
</body>
</html>


<script>
// 让搜索执行Ajax刷新，并且更换指定 div
$.G.event.search.ajax_change = ['list'];
// 搜索完成后调用回调函数
$.G.event.search.before = function(){
	this.lo = $.alert('loading...');
};
$.G.event.search.after = function(result){
	this.lo.popup_remove();
	bendi.bjChoice();
};
// 让搜索执行Ajax刷新，并且更换指定 div
$.G.event.paging.ajax_change = ['list'];
// 搜索完成后调用回调函数
$.G.event.paging.before = function(){
	this.lo = $.alert('loading...');
};
$.G.event.paging.after = function(result){
	this.lo.popup_remove();
	bendi.bjChoice();
};

// 记录对象
var returnResult = [];
var CONFIG = <?=str::json(array('nopic'=>$picture_name?1:0))?>;
var bendi = {
	...CONFIG,
	// 初始化
	init(){
		let cur = $('.wcb_alert_box_init_data').json();
		cur.forEach( v => {
			let src = $.json(v.Pictures)[0];
			let para = {id:v.Id, path:src?src.path:'', name:v.Name};
			bendi.add(para);
		});
		bendi.limit();
		// 绑定展开
		$(document).on('click','.file_ckeck_list_num',function(){
			let ele = $('.wcb_alert_btn .file_ckeck_list');
			if(ele.is('.expand')){
				ele.removeClass('expand');
			}else{
				ele.addClass('expand');
			}
			bendi.limit();
		});
		bendi.bjChoice();
	},
	// li模板
    li(v){
		if(bendi.nopic){
			var li = `
				<div class="file_ckeck_list_li relative" data-id="${v.id}">
					<span>${v.name}</span>
					<i class="delete" onclick="bendi.del(this)"></i>
				</div>
			`;
		}else{
			var li = `
				<div class="file_ckeck_list_li m-pic relative" data-id="${v.id}">
					<img class="absolute" src="${v.path}" alt="${v.name}">
					<i class="delete" onclick="bendi.del(this)"></i>
				</div>
			`;
		}
		return li
    },
	// 判断是否到了省略个数
	limit(){
		var ele = $('.wcb_alert_btn .file_ckeck_list_num');
		// 判断长度
		if(returnResult.length > 5){
			let num = returnResult.length - 5;
			ele.removeClass('hide2').find('span').html(num+'+');
			if($('.wcb_alert_btn .file_ckeck_list').is('.expand')){
				ele.find('span').html('<i class="lyicon-arrow-up-bold"></i>');
			}
		}else{
			ele.addClass('hide2');
			$('.wcb_alert_btn .file_ckeck_list').removeClass('expand')
		}
	},
	// 删除数据
	del(opt){
		if(typeof opt === "number" || (typeof opt === "string" && !isNaN(opt))){
			var id = opt;
		}else{
			var id = $(opt).parent().attr('data-id');
		}
		// 删除预览li
		$('.wcb_alert_btn .file_ckeck_list').find('[data-id="'+id+'"').remove();
		// 取消勾选
		$('.bendi_file_span_box [name="Id[]"]').each(function(){
			if($(this).val() == id){
				$(this).removeAttr('checked');
				$(this).parent().removeClass('cur');
			}
		})
		// 删除数据
		for (let i = 0; i < returnResult.length; i++) {
			if(returnResult[i] == id){
				returnResult.splice(i, 1);
			  	i--;
			}
		}

		bendi.limit();
	},
	// 添加数据
	add(para){
		returnResult.push(parseInt(para.id));
		$('.wcb_alert_btn .file_ckeck_list').append(bendi.li(para));
		$('.ly_drop_content').append(bendi.li(para));
		bendi.limit();
	},
	// 比较勾选状态
	bjChoice(){
		$('.xxxxxxxxLI').each(function(){
			var el = $(this);
			var id = parseInt(el.attr('data-id'));
			if (returnResult.includes(id)) {
				el.addClass('cur');
				el.find('input').prop('checked','checked');
			} else {
				el.removeClass('cur');
				el.find('input').removeProp('checked');
			}
		});
	},
	// 勾选回调
	choice:{
		click(el, checked){
			var val = el.val();
			var path = el.attr('data-path');
			var name = el.attr('data-name');
			let para = {id:val,path:path,name:name};
			if(checked) {
				bendi.add(para);
			} else {
				$('.wcb_alert_btn .file_ckeck_list').find('[data-id="'+val+'"').remove();
				bendi.del(val);
			}
		}
	}
};

bendi.init();
</script>