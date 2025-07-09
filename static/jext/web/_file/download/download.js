
// 点击下载
$(document).on('click', '[file-download]', function(e) {
	var a = $(this);
	var path = a.attr('file-download')||'';
	var name = a.attr('name')||a.attr('data-name')||'';
	var ext = a.attr('ext')||a.attr('data-ext')||'';
	var url = a.attr('url')||a.attr('data-url')||'';
	var href = a.attr('href')||a.attr('data-href')||'';
	if (!path) {
		return ;
	}
	// 双击下载
	if (a.is('[dblclick]')) {
		var cl = parseInt(a.attr('cl-num') || 0);
		cl++;
		a.attr('cl-num', cl);
		setTimeout(function(){
			a.removeAttr('cl-num');
		}, 300);
		if (cl < 2) {
			return ;
		}
	}
	if (href) {
		window.open(href, '_blank');
	}
	else if (url) {
		// window.open(url + '?path=' + path + '&name=' + name + '&ext=' + ext, $.ie() ? '_blank' : 'DOWNLOAD-IFRAME-BOX');
		window.open(url + '?path=' + path + '&name=' + name + '&ext=' + ext, '_blank');
	}
	else {
		window.open($.path + 'web/file/download/download.php?path=' + path + '&name=' + name + '&ext=' + ext, '_blank');
	}
	if (a.parents('[file-download]').size() > 0) {
		e.stopPropagation();
	}
});

// $('body').append('<iframe src="about:blank" name="DOWNLOAD-IFRAME-BOX" id="DOWNLOAD-IFRAME-BOX" style="display:none"></iframe>');