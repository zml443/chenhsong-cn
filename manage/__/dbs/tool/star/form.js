$(document).on('click', '[dbs="open-reply"] input', function () {
	var a = $(this);
	var next = a.parents('label').next();
	if (a.is(':checked')) {
		next.show();
	}
	else {
		next.hide();
	}
});