var dbs_tool_style = {
	// 初始化回调
	init(el, obj, value){
		this.set(el, obj, value);
	},
	// 选择回调
	change(el, obj, value){
		this.set(el, obj, value);
	},

	set(el, obj, value){
		let item = el.parents('._dbs_item:eq(0)');
		var dat = obj.value_dat[0]
		// let a = item.find('.lianjie');
		item.find('.lianjie').attr('hr-ef', dat.url);
		if (dat.image) {
			item.find('.pic img').attr('src', dat.url);
		}
	}
}