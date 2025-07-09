
var lydbsSeo = {
	xx(a){
		var na = a.attr('name');
		var similar = na.replace('Name', 'SeoTitle');
		var seo_sim = $('[name="'+similar+'"]');
		// 当存在相同语言版本的话，同步相同语言版本，否则，给最靠前的语言版本
		if (!seo_sim.size()) {
			seo_sim = $('[name^="SeoTitle"]:eq(0)');
		}
		var v1 = a.val();
		var v2 = seo_sim.val();
		// 当seo的输入框独立后不可进行编辑
		if (seo_sim.is('.not_input_to_me')&&v2) {
			// 如果内容一样，那就继续同步编辑
			if (v1==v2) seo_sim.removeClass('not_input_to_me');
			return;
		}
		seo_sim.val(a.val()).trigger('propertychange'); //触发事件，是为了同步textarea的自动高度效果
	}
}

// 输入事件 - 监听当前页面认为是标题的输入框，将此输入框同步到 seo 的标题栏
$(document).on('input', '[name^="Name"]', function () {
	var a = $(this);
	lydbsSeo.xx(a);
	
});

// 失去焦点事件 - 当seo的标题事件有被编辑的时候，将不与标题栏同步
$(document).on('input', '[name^="SeoTitle"]', function () {
	var a = $(this);
	var na = a.attr('name');
	var similar = na.replace('SeoTitle', 'Name');
	var name_sim = $('[name="'+similar+'"]');
	if (!name_sim.size()) {
		name_sim = $('[name="Name"]');
	}
	if (a.val() && a.val()!=name_sim.val()) {
		a.addClass('not_input_to_me');
	}
	else {
		a.removeClass('not_input_to_me');
	}
});

// 如果一开始就有内容就什么都不用说了
/*$.task.push(function () {
	_('[name^="SeoTitle"]').trigger('input');
});*/

$(document).ready(function(){
	$('[name^="SeoTitle"]').each(function(){
		lydbsSeo.xx($(this));
	});
});