
$(document).on('click', '[ly-sitemap]', function() {
	WP.$.alert({
		iframe: $.path + 'web/sitemap/view.html',
		wh: [700, 600],
		// style: 'C',
		init: function (a) {
			// a.bd.css({background:'none', boxShadow:'0 0 19px rgba(0,0,0,.4)'});
		}
	});
});