var tool_page_url_ = (el)=>{
	var el = $(el);
	var conEl = el.parents('._dbs_content:eq(0)');
	var resEl = conEl.find('.result');
	var val = el.val();
	var prefix = resEl.attr('data-prefix');
	if (prefix!='/') prefix = prefix.replace(/\/+/g,'/').replace(/^\/|\/$/,'');
	var suffix = resEl.attr('data-suffix');
	if (suffix!='/') suffix = suffix.replace(/\/+/g,'/').replace(/^\/|\/$/,'');
	var url = location.protocol + '//' + location.hostname;
	if (val) {
		resEl.html('<span color="text2">'+url+'</span>'+('/'+prefix+'/'+val+(suffix&&suffix!='/'?'.':'')+suffix).replace(/\/+/g,'/'));
	} else {
		resEl.html('系统链接');
	}
};

$(document).ready(()=>{
	tool_page_url_('.tool_page_url_this');
});