


FONTSSTYLE = {
	'DINCondBold':0
};


$.task.push(function () {
	for (var i in FONTSSTYLE) {
		var im = $.path + 'web/fonts/' + i;
		if (FONTSSTYLE[i]==0 && $('[font-' + i + '],.font-' + i).size()) {
			FONTSSTYLE[i] = 1;
			$('[jextstyle]').append("@font-face{font-family:" + i + ";src:url('" + im + ".woff'),url('" + im + ".woff2'),url('" + im + ".ttf'),url('" + im + ".eot'),url('" + im + ".otf');}[font-" + i + "],.font-" + i + "{font-family:" + i + "}");
		}
	}
});