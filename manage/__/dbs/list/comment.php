<?php
// 防止胡乱进入
function_exists('c')||exit;
// 
$pg = $_GET['pg']-1;
$pg<0 && $pg = 0;
$this->row = db::get_comment($this->table, $this->where);
// $this->total = db::get_row_count($this->table, $this->where);

$isnull = !$this->total && language('menu.'.implode('.', $this->u).'.module_null_title');

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}
body .wcb_alert_side{width: 600px}
</style>

<body class="maxvh flex-column <?=$_GET['_popup_left_']?'flex-left':'flex-right'?>">
	<script class="wcb_alert_side_init_data" type="text"><?=str::json($current)?></script>
	<!-- 点击空白关闭 -->
	<div class="absolute max" hr-ef="back()"></div>
	<!-- 弹窗 -->
	<div class="wcb_alert_side relative flex-column">
		<!-- 顶部 -->
		<div class="sticky" style="top:0px">
			<?php $lyCssConf=[]; include c('dbs.inc').'title-side.php';?>
		</div>

		<!-- 中间 -->
		<div class="flex-1 scrollbar combody" style="height:0px" ajax-change="list">
			<script class="chankangengxin" type="text"><?=$this->query_string['comment_new_data'];?>&_min_id=<?=$this->row['last']['Id'];?></script>
			<div class="p_30px">
				<?php 
				$i = 0;
				$end_i = count((array)$this->row[$this->row['uid']]);
				foreach((array)$this->row[$this->row['uid']] as $k => $v){ 
					$i++;
				?>
					<div class="ul">
						<div class="zml_coment_li <?=$i==1?'first':''?> li">
							<div class="fz16 name">
								<?php
									if ($v['wb_member_id']) {
										echo "会员";
									} else if ($v['wb_manage_id']) {
										echo "管理员";
									} else {
										echo "游客";
									}
								?>
							</div>
							<div class="fz14 mt_10px msg"><?=$v['Message']?></div>
							<div class="fz14 mt_10px flex">
								<div class="flex-1" color="text3"><?=date('Y-m-d H:i:s', $v['AddTime'])?></div>
								<a color="text1" onclick="LiuYanHF.reply(this)" data-uid="<?='0,'.$v['Id'].','?>"><?=language('{/global.reply/}')?></a>
							</div>
						</div>
						<?php foreach((array)$this->row[$v['Id']] as $k1 => $v1){ ?>
							<div class="zml_coment_li_reply li">
								<div class="fz16 name flex-middle2">
									<span>
										<?php
											if ($v1['wb_member_id']) {
												echo "会员";
											} else if ($v1['wb_manage_id']) {
												echo "管理员";
											} else {
												echo "游客";
											}
										?>
									</span>
									<?php 
										if ($v1['_reply_id_'] && $v1['Dept']>2) {
											$v2 = $this->row['id'][$v1['_reply_id_']];
											if ($v2['wb_member_id'] || $v1['wb_member_id']) {
												$v2_show = $v2['wb_member_id']!=$v1['wb_member_id'];
											} else if ($v2['wb_manage_id'] || $v1['wb_manage_id']) {
												$v2_show = $v2['wb_manage_id']!=$v1['wb_manage_id'];
											} else {
												$v2_show = 1;
											}
											if ($v2_show) {
									?>
										<span class="p_0_10px fz12" color="text3">&gt;</span>
										<span class="fz12" color="text3">
											<?php
												if ($v2['wb_member_id']) {
													echo "会员";
												} else if ($v2['wb_manage_id']) {
													echo "管理员";
												} else {
													echo "游客";
												}
											?>
										</span>
									<?php 
										}
									} 
									?>
								</div>
								<div class="fz14 mt_10px msg"><?=$v1['Message']?></div>
								<div class="fz14 mt_10px flex">
									<div class="flex-1" color="text3"><?=date('Y-m-d H:i:s', $v1['AddTime'])?></div>
									<a color="text2" onclick="LiuYanHF.reply(this)" data-uid="<?='0,'.$v['Id'].','.$v1['Id'].','?>"><?=language('{/global.reply/}')?></a>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>

		<!-- 底部 -->
		<form class="sticky p_15px LiuYanHF" style="bottom:0px" bg="default" action='<?=$this->query_string['post'];?>'>
			<div class="relative">
				<label class='ly_input' bg="white"><textarea size="default" autoHeight name='Message' placeholder="输入内容开始聊天 ( Enter 发送，Shift + Enter 换行 )"></textarea></label>
				<input type="hidden" name="CUId" value="0," />
				<?php 
					foreach ($this->is_keep_GET as $k => $v) {
						echo '<input type="hidden" name="'.$k.'" value="'.$_GET[$k].'" />';
					} 
				?>
				<div class="absolute flex-btn pointer" style="bottom: 0;right: 0;padding: 10px" onclick="$('.LiuYanHF').submit()"><i class="lyicon-fabu fz24" color="main"></i></div>
			</div>
			<div class="text-over tip"></div>
		</form>

	</div>
</body>
</html>


<script>
var LiuYanHF = {
	// 回复
	reply(el){
		el = $(el);
		var li = el.parents('.li:eq(0)');
		var co = li.find('.msg');
		var na = li.find('.name');
		$('.LiuYanHF [name="CUId"]').val(el.attr('data-uid')||'');
		$('.LiuYanHF .tip').html(`
			<div class="flex-middle2 mt_5px" style="padding:5px;border-radius:5px" bg="white">
				<div class="nowrap pointer mr_15px" onclick="LiuYanHF.cancel(this)" style="width:16px;height:16px;border-radius:50%;" bg="default"><i class="lyicon-close"></i></div>
				<div class="flex-1 text-over w_1" color="text3"><span color="main">回复</span> : ${na.html()} : ${co.html()}</div>
			</div>
		`);
		$('.LiuYanHF textarea').focus();
	},
	// 取消回复
	cancel(){
		$('.LiuYanHF [name="CUId"]').val('');
		$('.LiuYanHF .tip').html(``)
	},

	// 检查更新
	gengxin(){
		var time = 0;
		var loaded = 0;
		var url = $('.chankangengxin').html();
	    $.async('POST', url, {_:1}, result=>{
	    	if (result.has_new_data) {
	    		$.flush('', ()=>{
		    		LiuYanHF.top();
					loaded = 1;
		    	});
	    	} else {
				loaded = 1;
	    	}
		}, 'json');
		function xxx(){
			if (time==400 && loaded) {
				LiuYanHF.gengxin();
			} else {
				requestAnimationFrame(xxx);
			}
			time = time+1;
		}
		xxx();
	},

	// 返回当前回复的位置
	go_to_uid: '',
	top(){
		let t = 0;
		if (this.go_to_uid) {
			let u = $('[data-uid="'+this.go_to_uid+'"]').parents('.ul:eq(0)').find('[data-uid]').last();
			let par = u[0].offsetParent;
			t += u[0].offsetTop
			if (par.nodeName.toLowerCase()!='body') {
				while(par){
					t += par.offsetTop
					par = par.offsetParent
				}
			}
			t -= 300
		} else {
			t = $('.combody')[0].scrollHeight;
		}
		$('.combody').animate({scrollTop: t});
	}
}
setTimeout(()=>{
	LiuYanHF.top();
},100);

LiuYanHF.gengxin();

$(document).on('submit', '.LiuYanHF', function(){
	var el = $(this);
	var url = el.attr('action');
    var formdata = new FormData(el[0]);
    $.async('POST', url, {newFormData:formdata}, result=>{
        if (result.ret==1) {
        	LiuYanHF.go_to_uid = el.find('[name="CUId"]').val();
 	       	$.alert(result.msg, 1500);
        	$.flush('', ()=>{
        		LiuYanHF.top();
        	});
        	$('.LiuYanHF textarea').val('');
        	LiuYanHF.cancel();
        } else {
        	$.alert(result.msg, 3000)
        }
    }, 'json');
	return false;
});

$(document).on('keydown','.LiuYanHF textarea', function(e){
	var el = $(this);
	if (e.shiftKey) {
        // 
    } else if (e.key=='Backspace') {
    	if (!el.val()) {
    		LiuYanHF.cancel();
    	}
    } else if (e.key=='Enter') {
    	$('.LiuYanHF').submit();
        e.preventDefault();
        return false;
    }
});
</script>