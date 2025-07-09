/*
 * 文件编辑
 * <div ace='jext' file='/asdsa.html'></div>
 * 
**/

$(document).on('click', '[ace][file],[ace][data]', function() {
	var aa = $(this);
	var lo = WP.$.alert('loading');
	if (typeof(ACEWRITERTOOL) == 'object') {
		ACEWRITERTOOL.INIT(aa, lo);
	} else {
		$.include($.path + 'web/ace/src/ace.js', function(){
			$.include($.path + 'web/ace/src/ext-language_tools.js', function(){
				$.include($.path + 'web/ace/tool.css', 1);
				$.include($.path + 'web/ace/tool.js', function(){
					ACEWRITERTOOL.INIT(aa, lo);
				});
			});
		});
	}
	/*ACEWRITERTOOL.OBJ = $(this);
	ACEWRITERTOOL.POP = WP.$.max({
		iframe: $.path + 'php/ace/inc/iframe.php',
		init: function(a) {
			a.bd.css({background:'rgba(0,0,0,.3)'});
		}
	});*/
});

/*ACEWRITERTOOL = {
	CHANGE: function() {
		// 
	},
	SAVE: function() {
		// 
	},
	END: function() {
		// 
	}
}*/