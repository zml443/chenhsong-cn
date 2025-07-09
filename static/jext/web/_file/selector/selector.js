/*

<div file-selector='default'></div>
<div file-selector='ly200'></div>

*/

$.task.push(function (i) {
	if ($('[file-selector][list]').size()) {
		$.include($.path + 'web/file/selector/style/list.js');
		$.include($.path + 'web/file/selector/style/list.css');

		WP.$.include(WP.$.path + 'web/file/selector/style/list.js');
		WP.$.include(WP.$.path + 'web/file/selector/style/list.css');
	}
	if ($('[file-selector][data-is-one]').size()) {
		$.include($.path + 'web/file/selector/style/one.js');
		$.include($.path + 'web/file/selector/style/one.css');
		
		WP.$.include(WP.$.path + 'web/file/selector/style/one.js');
		WP.$.include(WP.$.path + 'web/file/selector/style/one.css');
	}
});


WP.$.include($.path + 'web/file/selector/selector.css', 1);



$(document).on('click', '[file-selector]', function() {
	var el = $(this);
	var fn = $.callbackfn(el.attr('fn'),'change');
	var type = el.attr('file-selector');
	var type2 = el.attr('data-type');
	var size = el.attr('data-size')||'';
	// console.log(type2);
	if (type2=='svg') {
		var url = '/static/jext/web/file/selector/inc/svg.php';
	} else {
		var url = el.attr('data-url')||'/static/jext/web/file/selector/inc/list.php';
	}
	$.iframeBox({
		// id: 'xxxxxxxx',
		url: url,
		search:{
			UId:'0,',
			Name: '',
			Ext: '',
			ExtId:'',
			GroupId: type,
			_NotChoice_: el.is('[data-not-choice]')?1:0,
			size: size,
		},
		init(alert_el, files, obj){
		},
		change(alert_el, files, obj){
			obj.alert_el = alert_el;
			$.eval(fn.change, el, files, obj);
		},
	});
});