$(document).on('click', '[hr-ef]', function(event){
	var el = $(this);
	var href = el.attr('hr-ef');
	if (WP.$dbs.lydbs_has_change_form) {
		WP.$.alert({
			str: '数据未提交保存，是否跳出当前页面？',
			confirm(){
				$dbs.href(href, el);
			}
		});
	} else {
		$dbs.href(href, el);
	}
	event.stopPropagation()
});
