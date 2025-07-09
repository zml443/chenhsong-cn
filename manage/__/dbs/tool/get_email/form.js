function __dbs_to_email (item, alert_side_el) {
	alert_side_el.find('iframe').iframe('task', function () {
		var body = $(this).contents().find('body');
		body.on('click', '[data-email]', function () {
			var li = $(this);
			write_email(li, li.is('.cur')?'remove':'checked');
		});
		body.on('click', '[data-email-all]', function () {
			var bt = $(this), hs = bt.is('.add');
			body.find('[data-email]').each(function () {
				var li = $(this);
				write_email(li, hs?'remove':'checked');
			});
		});
		body.find('[data-email]').each(function () {
			var li = $(this),
				email = li.data('email').split('/'),
				textarea = item.find('textarea'),
				val = item.find('textarea').val();
			if (val.indexOf(email[0]+'/')>=0) {
				li.addClass('cur');
			}
		});
		var write_email = function (li, type) {
			var email = li.data('email').split('/'),
				textarea = item.find('textarea'),
				val = item.find('textarea').val(),
				has = val.indexOf(email[0]+'/')>=0;
			if (type=='checked') {
				li.addClass('cur');
				if (!has) val += (val?"\r\n":'')+email[0]+'/'+email[1];
			}
			else if (type=='remove') {
				li.removeClass('cur');
				email = email[0]+'/'+email[1];
				val = "`"+val.replace(/[\r\n]/g, '`')+"`";
				val = val.replace("`"+email+"`",'`').replace(/`+/g, "\r\n").replace(/^\s+|\s+$/g, '');
			}
			textarea.val(val);
			if (body.find('[data-email]').size()==body.find('[data-email].cur').size()) {
				body.find('[data-email-all]').addClass('add');
			}
			else {
				body.find('[data-email-all]').removeClass('add');
			}
		};
	});
};

$(document).on('click', '[data-dbs-type="get_email"] .get_email', function(e){
	var el = $(this),
		dbsitem = el.parents('._dbs_item'),
		option = $.json(dbsitem.find('.json').html()),
		url = {};
	for (var i in option) {
		url[option[i].Name] = (option[i].Url.indexOf('?')>0?'':'?')+option[i].Url+'&iframe=1&alert=1&notback=1';
	}
	WP.$.alert_side({
		obj: el,
		reload: 1,
		url: url,
		css: {width:900, right:0},
		end: function (side_el) {
			var issubmit = 0;
			side_el.find('iframe').each(function () {
				var ht = $(this).contents().find('html');
				if (ht.is('.is-submit')) issubmit = 1;
			});
			if (issubmit) {
				// 
			}
		},
		start: function (side_el) {
			__dbs_to_email(dbsitem, side_el);
		}
	});
});