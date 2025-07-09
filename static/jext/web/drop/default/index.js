$.task.unshift(function(){
	_('[ly-drop-select]').each(function(){
		new drop_select_class($(this))
	});
});
