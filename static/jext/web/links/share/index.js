/*
 分享插件
 作者：林庭
 整理：zinn
*/

$.eval('qrcode', function () {
	// 加载二维码生成器
});

$(document).on('click', '[share],[ly-share]', function () {
	var el = $(this),
		data = {
			url: el.attr('data-url')||document.location.href||'',
			title: el.attr('data-title')||document.title||'',
			brief: el.attr('data-brief')||document.title||'',
			img: el.attr('data-img')||$('img').attr('src')||'',
			imgtitle: el.attr('data-img-title')||document.title||'',
			from: el.attr('data-from')||window.location.host||'',
		};
	_links_share(el.attr('ly-share')||el.attr('share'), data);
});

_links_share = function (to_api, config) {
	var url = config.url,
		title = config.title,
		brief = config.brief,
		img = config.img,
		img_title = config.imgtitle,
		from = config.from;

	this.urlEncode = function(param, key, encode){
		var _result = [];
		for (var key in param) {
			var value = param[key];
			if (value.constructor==Array) {
				value.forEach(function(_value) {
					_result.push(key + "=" + encodeURIComponent(_value));
				});
			} else {
				_result.push(key + '=' + encodeURIComponent(value));
			}
		}
		return _result.join('&');
	};
	if (to_api=='sina') {//新浪微博
		// var apiUrl = "http://v.t.sina.com.cn/share/share.php";
		var apiUrl = "http://service.weibo.com/share/share.php";
		var v = {
			appkey:"",
			title: title,
			url: url,
			pic: img
		}
	} else if (to_api=='facebook') {//脸谱
		var apiUrl = "http://www.facebook.com/sharer.php";
		var v = {
			u: url,
			t: title
		}
	} else if (to_api=='twitter') {//推特
		var apiUrl = "https://twitter.com/intent/tweet";
		var v = {
			text:title+" "+url
		}
	} else if (to_api=='douban') {//豆瓣
		var apiUrl = "https://www.douban.com/share/service";
		var v = {
			href: url,
			name: title,
			text: brief,
			image: img
		}
	} else if (to_api=='reddit') {//reddit
		var apiUrl = "http://www.reddit.com/submit";
		var v = {
			url: url,
			title: title,
		}
	} else if (to_api=='linkedin') {//领英
		var apiUrl = "http://www.linkedin.com/shareArticle";
		var v = {
			mini: 'true',
			url: url
		}
	} else if (to_api=='qzone') {//QQ空间
		var apiUrl = "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey";
		var v = {
			url: url,
			title: title,
			pics: img
		}
	} else if (to_api=='pinterest') {//QQ好友
		var apiUrl = 'https://www.pinterest.com/pin/create/button/';
		var v = {
			url: url,
			description: title,
			media: img
		}
	} else if (to_api=='tieba') {//贴吧
		var apiUrl = 'http://tieba.baidu.com/f/commit/share/openShareApi';
		var v = {
			url: url,
			title: title,
			desc: brief,
			pic:img
		}
	} else if (to_api=='amazon') {//亚马逊
		var apiUrl = 'https://www.amazon.com/gp/wishlist/static-add';
		var v = {
			u: url,
			t: title
		}
	} else if (to_api=='google') {
		var apiUrl = 'https://www.google.com/bookmarks/mark';
		var v = {
			op: 'add',
			bkmk: url,
			title: title,
			annotation: brief
		}
	} else if (to_api=='qq') {//QQ好友
		var apiUrl = "https://connect.qq.com/widget/shareqq/index.html";
		var v = {
			url: url,
			title: title,
			pics: img
		}
	} else if (to_api=='wechat') {//微信
		$.alert({
			title: $.lang.panel.share_wx_title,
			str: 
				'<div style="height:250px; padding:20px;" class="m-pic" qrcode="{wh:[190,190]}" href="'+url+'"></div>' +
				'<div style="font-size:12px; color:#000; padding:10px; border-top:1px solid #ddd;">'+$.lang.panel.share_wx_tip+'</div>'
			,
			type: 'border',
			wh: [360, 0]
		});
	}
	if (apiUrl) {
		window.open(apiUrl + '?' + this.urlEncode(v), '_blank');
	}
};
