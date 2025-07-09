
$.task.push(function() {
	$('img[file-ext]').each(function() {
		$.__file_ext.src($(this));
	});
});

$.__file_ext = {
	/*
	 * 后缀
	 * 
	**/
	src: function(obj) {
		var n = obj.attr('file-ext');
		var d = $.path + '/images/file-ico/';
		var x = '';
		if (!n) {
			x = d + 'dir.png';
		} else if (n.search(/^(data:|blob:)/i) > -1) {
			// x = n;
		} else if (n.search(/\.(png|jpe?g|svg|ico|webp)(\?|$)/i) > -1) {
			if (n.search(/^[a-z]:/i) >= 0) {
				x = d + 'jpg.ico';
			}
			// x = n;
		} else if (n.search(/\.(mp[34]|pdf|txt|psd|sql|cdr|js|ai|exe|apk|avi|csv|tsv|xlsx|gif?)$/i) > -1) {
			e = n.substring(n.lastIndexOf('.') + 1);
			x = d + e + '.ico';
		} else if (n.search(/\.(docx?)$/i) > -1) {
			x = d + 'doc.ico';
		} else if (n.search(/\.(php[0-9]?)$/i) > -1) {
			x = d + 'php.ico';
		} else if (n.search(/\.(html?)$/i) > -1) {
			x = d + 'html.ico';
		} else if (n.search(/\.(pptx?)$/i) > -1) {
			x = d + 'ppt.ico';
		} else if (n.search(/\.(zip|rar|z|arj)$/i) > -1) {
			x = d + 'zip.ico';
		} else {
			x = d + 'other.ico';
		}
		if (x) {
			n = x;
			obj.addClass('file-ext-wh');
		} else {
			obj.removeClass('file-ext-wh');
		}
		obj.removeAttr('file-ext').attr('data-src', n);
	},
};