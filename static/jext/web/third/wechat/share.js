;
/*
	微信分享接口
	作者：林庭
	
	【调用说明】
		示例：<body wx-share="分享的图片" tip="分享的标题" desc="分享介绍内容" debug>xx</body>
		1、必须放到body标签中
		2、微信公众号中必须获得分享权限
		3、微信公众号中必须添加IP白名单
		4、配置文件在jext插件目录下的PHP文件夹中的wechat/config.php中配置
		
	【必须的参数】
		wx-share：分享的图片完整路径，必须外网可以访问的
		
	【可选的参数】
		tip：分享的标题 默认网页title
		desc：分享的内容 默认description内容
		debug：是否开启调试
		link：网页的链接 默认使用当前页面链接地址
*/
$.post($.path + 'php/third/wechat/share.php', {url:$('body[wx-share]').attr('link') || window.location.href}, function (d) {
	if(d.ret){
		wx.config({
		    debug: typeof($('body[wx-share]').attr('debug')) != 'undefined'?true:false,
		    appId: d.msg.appId,
		    timestamp:d.msg.timestamp,
		    nonceStr: d.msg.nonceStr,
		    signature: d.msg.signature,
		    jsApiList: ['updateTimelineShareData','updateAppMessageShareData']
		});
		
		wx.ready(function () {
			var v = {
				title: $('body[wx-share]').attr('tip') || $('title').html(),
				desc: $('body[wx-share]').attr('desc') || $('meta[name='description']').attr('content'),
				link: d.msg.link,
				imgUrl: $('body[wx-share]').attr('wx-share'),
			};
			
		    wx.updateAppMessageShareData(v);
		
		    wx.updateTimelineShareData(v);
		
		});
	}
},'json');