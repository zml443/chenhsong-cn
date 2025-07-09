var __dbs_reply_ = {
	init: function (el, checked) {
		this.deal(el, checked);
	},
	click: function (el, checked) {
		this.deal(el, checked);
	},
	deal: function (el, checked) {
		var dbsitem = el.parents('._dbs_item').eq(0),
			text = dbsitem.find('._dbs_content');
		if (checked) {
			text.css({opacity:1});
			// text.show();
		} else {
			text.css({opacity:.3});
		}
	},
};