var __free2_open_ = {
	init(el, checked) {
		this.deal(el, checked);
	},
	click(el, checked) {
		this.deal(el, checked);
	},
	deal(el, checked) {
		var item = el.parents('._dbs_item'),
			con = item.find('._dbs_content');
		if (checked) {
			con.css({opacity:'1'});
		} else {
			con.css({opacity:'.3'});
		}
	}
};