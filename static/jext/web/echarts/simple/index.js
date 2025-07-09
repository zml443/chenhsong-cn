//echarts
var _ly_echarts = {
    href: {
        // char_data: $.path+'web/address/address.json',
    },
    data: {},
    get(href,fn) {
    	if (this.href[href]) {
    		href = this.href[href]
    	}
    	if (this.data[href]) {
    		fn(this.data[href])
    	} else if (typeof this.data[href]!='undefined') {
    		setTimeout(()=>{this.get(href, fn)},500)
    	} else {
    		this.data[href] = false;
            $.async('POST', href, {}, result=>{
		console.log(result)
                this.data[href] = result
                fn(result)
            }, 'json')
    	}
    }
}


setInterval(()=>{
	$('[ly-echarts-simple]').each(function(){
		var el = $(this)
		if (el.find('script:not(.exist)').size()) {
			ly_echarts(el)
		}
	});
}, 1000)

//////////////////////////////////////////////////////
var ly_echarts = (el)=>{
	el.find('.ly_echarts_box').remove()
	el.append(`<div class="ly_echarts_box maxw maxh"></div>`)
	var script = el.find('script')
	var mychart = echarts.init(el.find('.ly_echarts_box')[0])
	if (script.is('[data-href]')) {
		script.addClass('exist')
		var href = script.attr('data-href')
		_ly_echarts.get(href, result=>{
			data = result
			console.log(data)
			mychart.setOption(data)
		})
	} else {
		data = script.json()
		mychart.setOption(data)
	}
	script.remove()
}