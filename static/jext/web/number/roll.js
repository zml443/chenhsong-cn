// 数字滚动
$.task.push(function() {
    var time = 0.2;
    _('[ly-number-roll]').visible({
        init(el){
            ly_roll.setting(el,time)
        },
        show(el){
            ly_roll.visible.visible(el);
        }
    });
});


var ly_roll={
    // 固定内容
    ele:``,
}
// 数字滚动固定结构
for(let k = 0;k<10;k++){
    ly_roll.ele += `<span class="ly_roll_number_span block">${k}</span>`
}
for(let k = 0;k<10;k++){
    ly_roll.ele += `<span class="ly_roll_number_span absolute" style="top:100%;left:0;transform: translateY(${k}00%)">${k}</span>`
}

//获取属性标签
ly_roll.visible = {
    visible(element){
        var ele = element.children("span")
        ele.each((i,item)=>{
            // end
            var el = $(item).find('.ly_roll_number')

            // start
            var child = el.children()

            // center
            var children = child.children()

            var name = el.attr('data-name')
            var delay = parseFloat(el.attr('data-delay'))

            el.css({'animation':`${name} 1s ${delay+1}s ease-out forwards`})
            child.css({'animation':`ly_roll_number_center 0.6s ${delay+0.8}s linear 1`,})
            children.css({'animation':`ly_roll_number_start 0.8s ${delay}s ease-in `})
			$(item).css({'animation':`ly_roll_number_opacity ${delay+1+0.8+0.8}s linear`})
        })
    }
}

ly_roll.setting = (el,time)=>{
    var delay = 0
    var ohtml = el.html()||''
    var ary = ohtml.match(/(\S)/g);
    var res = ''
    var long = ary.length-1


    for(let i=long;i>=0;i--){
        // 判断字符串是否为数字类型
        var num = parseInt(ary[i])
        if(isNaN(num)){
            res = `<span>${ary[i]}</span>` + res
        }else{
            res = `<span class="relative inline-block over">
                <span class="hidden">${num}</span>
                <span class="absolute ly_roll_number" data-name="ly_roll_number${num}" data-delay="${delay}s" style="top:0;left:0;">
                    <span class="relative inline-block" style="top:0;left:0;">
                        <span class="relative inline-block" style="top:0;left:0;">
                            ${ly_roll.ele}
                        </span>
                    </span>
                </span>
            </span>` + res

            delay += time
        }

    }
    el.html(res)
}