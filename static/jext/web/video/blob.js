
/*
<video autoplay poster preload loop muted width="100%" video-src="<?=$advideo;?>" webkit-playsinline="true" playsinline="true" x5-video-player-type="h5" x5-video-player-fullscreen="true"></video>
<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
*/

/*视频重名*/
$('[video-src]').each(function(){
	var slide_this = $(this);// 视频对象
	var src = slide_this.attr('video-src');// 视频路径
	
	var ua = navigator.userAgent.toLowerCase();// 获取手机对象
	if(ua.match(/MicroMessenger/i) != "micromessenger" || 1){// 判断是否微信打开
		var xhr = new XMLHttpRequest();
		
		xhr.open('GET',src,true);
		
		xhr.responseType = 'blob';
		
		xhr.onload = function(e){
			if(this.status == 200){
				var blob = this.response;
				slide_this.attr('src',URL.createObjectURL(blob));
				slide_this[0].play();
				document.addEventListener("WeixinJSBridgeReady",function(){
					slide_this[0].play();
				},false);
				document.addEventListener('YixinJSBridgeReady', function() {
					slide_this[0].play();  
				}, false);
			}
		}
		xhr.send();
	}else{
		slide_this.attr('src',src);
		slide_this[0].play();
	}
});