$.task.push(function () {
	_('[ly-markdown]').each(function () {
		var r = $.rand('markdown');
		$(this).hide().addClass(r).after('<iframe src="'+$.path+'/web/markdown/examples/_.demo.html?markdown_name='+r+'" width="100%" frameborder="0" style="height:0;" scrolling="no"></iframe>');
	});
});