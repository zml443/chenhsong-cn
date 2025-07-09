<style>
#website_preview_model{width: 100%;height: 80px;position: fixed;left: 0px;bottom: -100px;z-index: 100;transition: all 0.8s ease-in-out 0s; background:rgba(0,0,0,.6)}
#website_preview_model .text{font-size:18px; margin-right:20px; color:#fff;}
#website_preview_model .btn{font-size:14px; margin-right:20px; height:30px; min-width:111px; border-radius:30px; background:#409EFF; color:#fff;}
#website_preview_model .btn2{font-size:14px; margin-right:20px; height:30px; min-width:111px; border-radius:30px; background:#fff; color:#333;}
</style>

<div id="website_preview_model" class="flex-max2">
	<div class="text">当前为预览模式</div>
	<a class="btn flex-max2" onclick="website_preview_model_out()">退出预览</a>
	<a class="btn2 flex-max2" onclick="website_preview_model_hide()">隐藏底部栏</a>
</div>

<script>
	var website_preview_model_hide_var = window.parent.is_visualization;
	function website_preview_model_hide(argument) {
		website_preview_model_hide_var = 1
		$('#website_preview_model').css({bottom:-100})
	}
	function website_preview_model_out(argument) {
		$.async('POST', '/api/website/preview_model', {unset:1}, result=>{
			location.reload()
		}, 'json');
	}
	$(document).scroll(function(){
		if (!website_preview_model_hide_var) {
			$('#website_preview_model').css({bottom:0})
		}
	});
</script>