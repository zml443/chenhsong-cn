var _textarea_auto_height = function(el){
	if (el.is(':hidden')) {
		return;
	}
	el[0].style.minHeight = '0px';
	el[0].style.minHeight = el[0].scrollHeight + 'px';
	el.addClass('over')
};
$(document).on('propertychange input', 'textarea[autoHeight]', function (event) {
	_textarea_auto_height($(this));
});
$(document).on('keydown keyup', 'textarea[notEnter]', function (e) {
	if (e.key=='Enter' || e.code=='Enter' || e.keyCode==13) {
		e.returnValue = false;
		return false;
	}
});
$(window).on('resize', function(){
	$('textarea[autoHeight]:visible').each(function(){
		_textarea_auto_height($(this));
	});
});
$.task.push(function(){
	_('textarea[autoHeight]:visible').each(function(){
		_textarea_auto_height($(this));
	});
});