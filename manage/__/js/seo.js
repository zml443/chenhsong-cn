
var dbs_seolist = {
	cur: function () {
		$('.zml_seo_list tr').each(function () {
			var tr = $(this);
			var a = tr.find('[name="Id"]');
			if (a.is(':checked')) {
				tr.addClass('canmodtext').find('textarea').removeAttr('readonly').removeAttr('border');
			} else {
				tr.removeClass('canmodtext').find('textarea').attr({readonly:true, border:'transparent'});
			}
		});
	}
};


$(document).on('click change', '.zml_seo_list [name="Id"], .zml_seo_list input[all]', function () {
	if ($('[name="Id"]:checked').size()) {
		$('[dbs="seosubmit"]').show();
	}
	else {
		$('[dbs="seosubmit"]').hide();
	}
	dbs_seolist.cur();
});


$(document).on('click', '.zml_seo_list textarea', function () {
	var tr = $(this).parents('tr');
	if (!tr.find('[name="Id"]').is(':checked')) tr.find('[name="Id"]').trigger('click');
});


$(document).on('click', '[dbs="seosubmit"]', function () {
	$('.zml_seo_list tr').each(function () {
		var tr = $(this);
		var ti = tr.find('[name="Id"]');
		if (!ti.is(':checked')) {
			return;
		}
		var fd = new FormData();
		fd.append('Id', tr.find('[name="Id"]').val());
		tr.find('input[type="text"],input[type="hidden"],input:checked,textarea,select').each(function () {
			var a = $(this);
			var n = a.attr('name');
			var v = a.val()||'';
			if (!n) return;
			else fd.append(n, v);
		});
		var u=location.href,u=u.replace(/([&\?])d=([^&#]+)(&?)/, '$1')+(u.indexOf('?')>=0?'&':'?')+'d=save-seo&iframe=1';
		$.async('POST', u, {newFormData:fd}, function (dat) {
			tr.removeClass('canmodtext').find('[name="Id"]').removeAttr('checked').parents('label').removeClass('cur');
			$('[dbs="seosubmit"]').hide();
			WP.$.alert(dat.msg, 1000);
		}, 'json');
	});
});