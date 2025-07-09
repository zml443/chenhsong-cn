
$('body').append(`
	<div id="searchouter" class="flex-max hidden">
	    <div class="in">
	        <form action="/search/" target="_blank" class="form relative trans">
	            <input class="keyword" type="text" name="keyword" placeholder="${$.lang.global.search}" class="block trans" autocomplete="off" />
	            <label class="submit m-pic pointer absolute">
	                <input type="submit" class="hide" />
	                <svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" width="38"><path d="M981.333333 936.106667l-192-193.28a430.506667 430.506667 0 1 0-45.226666 45.226666L933.546667 981.333333A32 32 0 0 0 981.333333 936.106667zM99.413333 462.933333a365.226667 365.226667 0 1 1 365.226667 365.226667 365.653333 365.653333 0 0 1-365.226667-365.226667z" fill="#fff"></path></svg>
	            </label>
	        </form>
	    </div>
	</div>
`);

$(document).on('click', '[ly-search-popup]', function () {
	var obj = $('#searchouter'),
		el = $(this),
		dat = $.json(el.attr('ly-search-popup'),'simple'),
		url = el.attr('url')||dat.url||'/search/';
	obj.find('form').attr('action', url);
	if (obj.is('.show')) {
		obj.removeClass('show');
	} else {
		obj.addClass('show');
	}
});


$(document).on('click', '#searchouter', function () {
	$(this).removeClass('show');
});
$(document).on('click', '#searchouter .in', function (e) {
	e.stopPropagation();
});