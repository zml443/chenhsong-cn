$(document).on('click', '[data-dbs-type=position] .jgg li', function () {
	var el = $(this),
		i = el.attr('i');
	el.addClass('cur').siblings().removeClass('cur');
	el.siblings('input').val(i);
});