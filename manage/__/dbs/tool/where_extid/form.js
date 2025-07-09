var tool_where_extid = (el)=>{
	el = $(el);
	var inp = el.find('[name="_where_extid_add"]');
	var inpDel = el.find('[name="_where_extid_del"]');
	var ma = el.attr('data-ma');
	// var exName = el.attr('data-exName');
	var exId = el.attr('data-exId');
	var x = new lydbsWhereExtId({
		ma: ma,
		// exName: exName, //关联字段名
		exId: exId, //关联id
		value: inp.val(), // 当前选中的id
		delete_value: inpDel.val(), // 当前选中的id
		// 确认
		confirm(){
			inp.val(this.value.join(','));
			inpDel.val(this.delete_value.join(','));
		}
	});
};