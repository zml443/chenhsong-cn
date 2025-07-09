var dbs_tool_page = {
	change(el, drop_el, data){
		if (data.length) {
			el.next().val(data[0].type||'');
		}
	}
};