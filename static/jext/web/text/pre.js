
$.task.push(function () {
	_('.editor pre,.detail pre').each(function () {
		var a = $(this)
		var t = a.text();
		a.append('<div class="pre-copy absolute pointer trans">copy</div>');
		a.addClass('relative').find('.pre-copy').attr('text-copy', t);
	});
});