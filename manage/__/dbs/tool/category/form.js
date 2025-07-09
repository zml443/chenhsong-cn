// 多分类
$(document).on('click', "[dbs='category-clone']", function () {
	var a = $(this),
		p = a.parent(),
		c = a.prev(),
		n = $('<div>'+c.html()+'</div>');
	n.css({marginTop:5}).find('option').attr('selected', false).end().find('a').show();
	p.append(n);
});