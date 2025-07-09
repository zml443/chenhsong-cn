/*
 * 编辑模板
 * By zinn
 * 
 */
if (!WP.$.__ueditor_module) WP.$.__ueditor_module = {
	// 窗口展示
	show: function (obj) {
		var thi = this;
		thi.obj = obj;
		thi.pop = WP.$.alert({
			title: 'Ueditor Module',
			style: 'C',
			type: 'border',
			wh: [900, 900],
			iframe: WP.$.path + 'web/ueditor/dialogs/module?alert=1',
			init: function (a) {
				// 
			}
		});
	},
	// 调用模板
	use: function (id) {
		var thi = this;
		var lo = WP.$.alert('loading...');
		var u = thi.obj.attr('ue');
		WP[u].focus(true);
		$.async('GET', $.path + 'web/ueditor/dialogs/module/get.php', {Id:id}, function (data) {
			lo.remove();
			thi.pop.remove();
			$.eval(thi.obj.attr('fn'), thi.obj, data);
		}, 'html');
	}
};


/*
 * 绑定事件
 * 
 */
$(document).on('click', '[ueditor-module]', function () {
	WP.$.__ueditor_module.show($(this));
});