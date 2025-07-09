var tool_bind_b = (el) => {
	var el = $(el);
	var inp = el.find('input');
	var name = el.attr('data-name')||'';
	var picture = el.attr('data-picture')||'';
	new lydbsAssociationList({
		ma: el.attr('data-ma')||'',
		value: el.find('input').val(),
		type: 'radio',
		field: {
			name: name,
			picture: picture,
		},
		confirm() {
			var id = this.value[0];
			inp.val(id);
			el.parents('._dbs_content').find('.name').html(this.log[id][name]);
		},
	});
};