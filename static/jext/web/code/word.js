// char = mix en num
// <div code-word='code'></div>
$.task.push(function() {
	_('[code-word]').each(function() {
		var a = $(this);
		var name = a.attr('code-word') || 'code-word';
		var char = a.attr('char') || 'en';
		var width = a.width();
		var height = a.height();
		var src = $.path + 'web/code/inc/word.php?name=' + name + '&length=4&charset=' + char;
		var html = '<img src="' + src + '" onclick="this.src=\'' + src + '&r=\'+Math.random();" width="100%" height="100%">';
		a.html(html);
	});
});