

if (!WP.dbsPermit) WP.dbsPermit = {
	obj:''
};

// var a=$(this); if (a.val()==2) a.next().show(); else a.next().hide()

$(document).on('change', '[data-dbs-type=permit] [dbsPermit]', function () {
	var a = $(this);
	var b = $('[dbsPermitBtn]');
	if (a.val()==2) {
		b.removeClass('hide2');
	}
	else {
		b.addClass('hide2');
	}
});

$(document).on('click', '[data-dbs-type=permit] [dbsPermitBtn]', function () {
	WP.dbsPermit.obj = $(this);

	WP.$.alert_side({
		id: 'managepermit',
		data: {
			url: "?ma=manage/permit"
		},
		css: {width:600, right:0},
	});
});

$.task.push(function () {
	_('[data-dbs-type=permit] [dbsPermit]').change();
});