var products_color = (el)=>{
	el = $(el);
	WP.$.alert({
		str: '缺少数据ID。只有在添加当前数据并形成ID后，才能编辑关联。是否先提交表单？',
		// str: $.lang.global.un_id_to_relation,
		style: 'B',
		wh: [400,0],
		// xy: $.xy(event, function(x, y){return [x-200, y-160]}),
		// cancel: 1,
		confirm: function(){
			el.parents('form').submit();
		}
	});
	return false;
};