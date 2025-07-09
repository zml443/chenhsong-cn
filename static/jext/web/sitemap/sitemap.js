$.__sitemap = {
	URL000: {}, // 采集的链接集合
	URL100: {}, // 处理队列
	URL500: {}, // 超时队列
	URL404: {}, // 404 队列
	URL400: {}, // 异常队列
	URL999: {}, // 经常出现的链接，比如导航的链接
	WWW: '', // 当前网站域名
	CUR: '', // 当前网站域名
	OVR: '', // 当前网站域名
	/*
	 * 初始化
	 * 
	**/
	init: function () {
		var thi = this;
		var url = location.href;
		thi.WWW = url.replace(/^(https?:\/\/)([^\/]*).*/, '$1$2');
		thi.POST();
		// 
	},
	/*
	 * 提交数据
	 *
	**/
	each: function () {
		var thi = this;
		var aaa = thi.WWW.replace(/https?::/, '');
		if (thi.LEN <= 0) {
			thi.POST();
			return;
		}
		for (var i in thi.URL100) {
			thi.CUR = thi.URL100[i].Href;
			delete(thi.URL100[i]);
			thi.LEN--;
			$('[deal-number]').html((thi.subtotal - thi.LEN) + ' / ' + thi.subtotal);
			if (thi.CUR.indexOf(aaa) < 0) {
				if (thi.CUR.search(/^(https?:\/\/)|\/\//) >= 0) {
					thi.status(200);
				} else {
					thi.status(404);
				}
				thi.eachtime();
			} else {
				thi.ajax();
			}
			break;
		}
	},
	eachtime: function () {
		var thi = this;
		setTimeout(function() {
			thi.each();
		},300);
	},
	/*
	 * 采集
	 * 
	**/
	ajax: function () {
		var thi = this;
		$.ajax({
			url: thi.CUR,
			type: 'POST',
			dataType: 'text',
			contentType: 'application/x-www-form-urlencoded',
			data: {asdqwe:1},
			timeout: 5000,
			success: function(htm) {
				thi.status(200);
				thi.deal(htm);
			},
			error: function(xhr, status, err) {
				thi.status(xhr.status);
				thi.eachtime();
				if (status == 'timeout') {
					// thi.status('500');
				} else if (parseInt(xhr.status) == 404) {
					// thi.status('400');
				}
			}
		});
	},
	/*
	 * 设置当前链接的获取状态
	 * 
	**/
	status: function (s) {
		var thi = this;
		var s = parseInt(s);
		var i = 0;
		thi.OVR[thi.CUR] = s;
		if (s>=400 && s<500) {
			i = 2;
		} else if (s>=500 && s<600) {
			i = 1;
		} else if (s!=200) {
			i = 3;
		}
		if (i) $('[url]').prepend('<li index='+i+'>'+thi.CUR+'['+s+']</li>');
	},
	/*
	 * 链接采集，并且处理
	 * 
	**/
	deal: function (htm) {
		var thi = this;
        var result = /<body[^>]*>([\s\S]*)<\/body>/.exec(htm);
        if (result && result.length === 2) {
        	htm = result[1];
        }
		htm = htm.replace(/ src=(["'])/g, ' sss=$1');
		if (thi.WWW.length == thi.CUR.length) {
			var host = thi.WWW;
		} else {
			var host = thi.CUR.substring(0, thi.CUR.lastIndexOf('/'));
		}
		host = host.replace(/\/$/g, '') + '/';
		now_host = location.host.replace(/^.*\.([^\.]+\.[^\.]+)$/, '$1');
		thi.URL[thi.CUR] = [];
		$('<div>'+htm+'</div>').find('a:not([rel=nofollow])').each(function() {
			var url = ($(this).attr('href')||'').split('?')[0];
			if (!url) {
				return;
			}
			var xgs = url.match(/\//g);xgs=xgs?xgs.length:0;
			if (!url || (url.search(/^([a-zA-Z0-9]+):/)>=0 && url.search(/^https?/)<0) || url.search(/^[\/]+$/)>=0 || url.search(/\.(exe|png|jpe?g|gif|pdf|ico|webp|txt|zip|rar|7z|docx?|xlsx?)/)>0 || xgs>6) {
				return ;
			}
			if (url.search(/^(https?:|\/\/)/) < 0) {
				url = thi.WWW + '/' + url.replace(/^\//, '');
			}
			else if (url.indexOf(now_host)<0) {
				return;
			}
			url = url.replace(/#.*$/g, '');
			var logurl = '^~^'+url+'^~^';
			if (thi.LOGURL.indexOf(logurl)>=0) {
				return ;
			}
			thi.LOGURL += logurl;
			thi.URL[thi.CUR].push(url);
		});
		thi.eachtime();
	},
	/*
	 * 提交到系统，并记录
	 * 同时获取需要采集的链接5
	**/
	POST: function () {
		var thi = this;
		$.post($.path + 'web/sitemap/action/url.php', {WWW:thi.WWW, OVR:thi.OVR, URL:thi.URL}, function (data) {
			if (data.ret == 1 || data.ret == 2) {
				thi.total = data.msg.total;
				thi.isok = data.msg.isok;
				thi.wait = data.msg.wait;
				thi.subtotal = data.msg.subtotal;
				$('[deal-number]').html('0 / ' + thi.subtotal);
				$('[wait-number]').html(thi.wait);
				$('[isok-number]').html(thi.isok);
				$('[total-number]').html(thi.total);
			}
			if (data.ret == 1) {
				thi.URL100 = data.msg.array;
				thi.URL = {};
				thi.OVR = {};
				thi.LEN = thi.subtotal;
				thi.LOGURL = '';
				thi.each();
			} else {
				$('[status]').html('已经采集完成，<a shengcheng>点击生成xml文件</a>');
				$.__sitemap.create();
				console.log(data);
			}
		}, 'json');
	},

	create: function () {
		var lo = WP.$.alert('loading');
		$.post($.path + 'web/sitemap/action/xml.php', {}, function (data) {
			lo.remove();
			WP.$.alert({
				str: data.msg,
				style: 'B',
				confirm: 1
			});
		}, 'json');
	}
};

$(document).on('click', '[status] [shengcheng]', function () {
	$.__sitemap.create();
});


$(document).ready(function () {
	$.__sitemap.init();
});