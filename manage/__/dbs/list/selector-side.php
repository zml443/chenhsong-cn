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
if($this->dbc['Name']){
	if ($this->dbc['Name']['Lang']) {
		$title_name = ln('Name');
	} else {
		$title_name = 'Name';
	}
}else{
	if ($this->dbc['FirstName']) {
		$title_name = 'FirstName';
	}elseif ($this->dbc['Email']) {
		$title_name = 'Email';
	}elseif ($this->dbc['Phone']){
		$title_name = 'Phone';
	}
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
body .wcb_alert_side{width: 500px}
</style>

<body class="maxvh flex-column <?=$_GET['_popup_left_']?'flex-left':'flex-right'?>">
	<script class="wcb_alert_side_init_data" type="text"><?=str::json($current)?></script>
	<!-- 点击空白关闭 -->
	<div class="absolute max" hr-ef="back()"></div>
	<!-- 弹窗 -->
	<div class="wcb_alert_side relative flex-column" ajax-change="list">
		<!-- 顶部 -->
		<div class="sticky" style="top:0px">
			<?php $lyCssConf=[]; include c('dbs.inc').'title-side.php';?>
			<!-- 搜索 -->
			<div class="p_20_30px" bg="white">
				<div class="flex"><?php $lyCssConf=[]; include c('dbs.inc').'search.php';?></div>
				<?php $lyCssConf=['class'=>'mt_10px']; include c('dbs.inc').'search_xz.php';?>
			</div>
		</div>

		<!-- 中间 -->
		<div class="flex-1 scrollbar" style="height:0px">
			<div class="list">
				<?php foreach($this->row as $k => $v){ ?>
					<label class="flex-middle2 pointer p_20_30px xxxxxxxxLI" data-id="<?=$v['Id']?>" bg="white">
					<i class="ly_checkbox lyicon-select-bold mr_15px"></i>
					<input class="hide" type="<?=$_GET['_radio_']?'radio':'checkbox'?>" <?=in_array($v['Id'],$choice_ids)?'checked':''?> name="Id" data-name="<?=$v[$title_name]?>" data-path="<?=img::get($v[$picture_name])?>" value="<?=$v['Id']?>" fn="bendi.choice"/>
						<?php if($picture_name){ ?>
							<div class='ly_img mr_15px'><img src='<?=img::get($v[$picture_name])?>'></div>
						<?php } ?>
						<?php if($title_name=='FirstName'){ ?>
							<div class="fz16"><?=str::real_name($v['FirstName'],$v['LastName'])?></div>
						<?php }else{ ?>
							<div class="fz16"><?=$v[$title_name]?></div>
						<?php } ?>
					</label>
				<?php } ?>
			</div>
		</div>

		<!-- 底部 -->
		<div class="sticky" style="bottom:0px">
			<!-- 分页 -->
			<div><?php $lyCssConf=['class'=>'flex-left p_20_30px fz12', 'bg'=>'white']; include c('dbs.inc').'paging2.php';?></div>

			<!-- 提交 -->
			<div class="maxw sticky" style="bottom:0;z-index:5">
				<div class="tPage flex-wrap" bg="white"></div>
				<div class="p_20_30px flex-middle2" bg="default">
					<?php if($_GET['_radio_']){ ?>
						<label class="pointer mr_20px fz16"><?=language('{/global.select/}')?></label>
					<?php }else{ ?>
						<label class="selector_side_checkall pointer mr_20px fz16">
							<i class="ly_checkbox lyicon-select-bold mr_5px"></i>
							<input class="hide" type="checkbox" name="checkbox" all=".list [name='Id']" />
							<?=language('{/global.all/}')?>
						</label>
					<?php } ?>
					<div class="at-confirm ly_btn_radius width100 mr_25px submit pointer2" bg="main" size="small"><?=language('{/global.confirm/}')?></div>
				</div>
			</div>
		</div>

	</div>
</body>
</html>


<script>
// 筛选、搜索和分页无刷新写法
/////////////////////////////////////////
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
$.G.event.paging.ajax_change = ['list','page'];
// 搜索完成后调用回调函数
$.G.event.paging.before = function(){
	this.lo = $.alert('loading...');
};
$.G.event.paging.after = function(result){
	this.lo.popup_remove();
	bendi.bjChoice();
};
/////////////////////////////////////////


// 记录对象
var returnResult = [];
var CONFIG = <?=str::json(array('nopic'=>$picture_name?1:0))?>;
var bendi = {
	...CONFIG,
	// 初始化
	init(){
		// 选中的完整数据
		let cur = $('.wcb_alert_side_init_data').json();
		cur.forEach( v => {
			returnResult.push({id:v.Id,name:v.Name})
		});
		bendi.bjChoice();
	},
	// 比较勾选状态
	bjChoice(){
		let is_all = 1;
		$('.xxxxxxxxLI').each(function(){
			let el = $(this);
			let id = parseInt(el.attr('data-id'));
			let index = returnResult.findIndex(v=>{return id==v.id})
			if (index>-1) {
				el.addClass('cur');
				el.find('input').prop('checked','checked');
			} else {
				el.removeClass('cur');
				el.find('input').removeProp('checked');
				is_all = 0
			}
		});
		// 全选
		if(is_all){
			$('.selector_side_checkall').addClass('cur').find('input').prop('checked','checked');
		}else{
			$('.selector_side_checkall').removeClass('cur').find('input').removeProp('checked');
		}
	},
	// 勾选回调
	choice:{
		click(el, checked){
			let type = el.attr('type');
			let id = el.val();
			let path = el.attr('data-path');
			let name = el.attr('data-name');
			let para = {id,name,path};
			if(type=='radio'){
				returnResult = [para];
			}else{
				let index = returnResult.findIndex(v=>{return id==v.id})
				if(checked){
					if(index<0) returnResult.push(para)
				}else{
					if(index>-1) returnResult.splice(index,1);
				}
			}
		}
	}
};

bendi.init();

</script>