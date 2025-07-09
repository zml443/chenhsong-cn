var _tool_deadline_ = {
	// 固定时间
	change(el, value) {
		var item = el.parents('._dbs_item'),
			time = value.split(' ~ ');
		item.find('.eftime0').val(time[0]);
		item.find('.eftime1').val(time[1]);
	},
	// 时间类型切换
	init(el, checked){
        if(checked) this.click(el);
    },
    click(el, checked){
        var type = el.val();
        el.parents('._dbs_content').find('.tab_content > *[data-con="'+type+'"]').removeClass('hide2').siblings('[data-con]').addClass('hide2');
    },
	// 领取时间
	tab(event){
		let parent = $(event).parents('.ly_input');
		let type = $(event).attr('data-type');
		let name = $(event).attr('data-name');
		parent.find('.tab_top').html(name);
		parent.find('[name="EfTimeUnit"]').val(type);
		$(event).addClass('cur').siblings().removeClass('cur');
	}
}