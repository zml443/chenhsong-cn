var tool_bind = (el) => {
	var el = $(el);
	var inp = el.find('input');
	var name = el.attr('data-name')||'';
	var picture = el.attr('data-picture')||'';
	new lydbsAssociationList({
		ma: el.attr('data-ma')||'',
		value: el.find('input').val(),
		field: {
			name: name,
			picture: picture,
		},
		confirm() {
			el.find('.a').html(this.value.length);
			inp.val(this.value.join(','));
		},
	});
};