var __special_offer_time_ = {
	change(el, value) {
		var item = el.parents('._dbs_item')
		var time = value.split(' ~ ')
		item.find('.start_time').val(time[0])
		item.find('.end_time').val(time[1])
	}
};

var __special_offer_open_ = {
	init(el, checked) {
		this.deal(el, checked);
	},
	click(el, checked) {
		this.deal(el, checked);
	},
	deal(el, checked) {
		var item = el.parents('._dbs_item')
		var box = item.find('._dbs_content')
		if (checked) {
			box.css({opacity:'1'});
		} else {
			box.css({opacity:'.3'});
		}
	}
};