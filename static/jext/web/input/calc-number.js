
var _calc_number = (inp, qty=0)=>{
	var fn = $.callbackfn(inp.attr('fn'), ['change','init'])
	var max = parseFloat(inp.attr('data-max'))||0
	var is_max = inp.is('[data-max]')
	var min = parseFloat(inp.attr('data-min'))||0
	var is_min = inp.is('[data-min]')
	var val = parseFloat(inp.val())||0
	var res = val+qty
	if (is_max && max<res) res = max
	if (is_min && min>res) res = min
	if (inp.is('[int]')) res = parseInt(res)
	inp.val(res)
	$.eval(fn.change, inp)
}

$(document).on('change', '[calc-number] input', function(e){
	_calc_number($(this))
})

$(document).on('click', '[calc-number] [minus]', function(e){
	var el = $(this)
	var parent = el.parents('[calc-number]')
	var num = parseFloat(el.attr('minus'))||1
	el.addClass('notcopy')
	_calc_number(parent.find('[type="number"]'), -num)
})

$(document).on('click', '[calc-number] [plus]', function(e){
	var el = $(this)
	var parent = el.parents('[calc-number]')
	var num = parseFloat(el.attr('plus'))||1
	el.addClass('notcopy')
	_calc_number(parent.find('[type="number"]'), num)
})