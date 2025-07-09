$(document).on('click', 'a[href*="#"], area[href*="#"]', function() {
	var el = $(this),
        url = location.href.replace(/\/+/,'/').replace(/^(.*)#.*$/,'$1'),
        href = el.attr('href'),
		hash = href.replace(/^.*(#.*)$/,'$1'),
        target = $(hash),
        default_top = parseInt(el.attr('data-top') || el.attr('top') || 0),
        bijiao_href1 = location.href.replace(/^(https?:\/\/)([^#]*)(#.*)?$/,'$2').replace(/\/+/,'/'),
        bijiao_href2 = (location.host+'/'+href).replace(/^(.*)#.*$/,'$1').replace(/\/+/,'/');
    if (target.size() && bijiao_href1==bijiao_href2) {
        var top = target.offset().top;
        $('html, body').animate({
            scrollTop: top - default_top
        }, 500);
        return false;
    }
});