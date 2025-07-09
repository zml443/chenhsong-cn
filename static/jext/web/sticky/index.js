var ly_sticky={
    // top
    top:[],
    // bottom
    bottom:[],
    //center
    center:[],
    // 二次处理
    center_arr:[],
    scroll_top:0,

}

// 处理top
ly_sticky.top_data = ()=>{
    var window_top = window.scrollY;
    var arr = ly_sticky.top;
    var top = 0;
    for(let i=0;i<arr.length;i++){
        var el = arr[i];
        var position = false;
        var cld = el.children();
        var width = el.width();
        var height = cld.outerHeight();
        var el_top = el.offset().top;
        el.css({'height':height});
        cld.css({'top':top,'width':width});
        if(window_top>(el_top-top)){
            cld.css({'position':'fixed'});
            position = true;
        }else{
            cld.css({'position':'static'});
        }
        top += cld.outerHeight();
        ly_sticky.add_fn(el,position);
    }
}


// 处理bottom
ly_sticky.bottom_data = ()=>{
    var window_top = Math.floor(window.scrollY)+$(window).height();
    var arr = ly_sticky.bottom;
    var bottom = 0;

    for(let i=0;i<arr.length;i++){
        var el = arr[i];
        var position = false;
        var cld = el.children();
        var width = el.width();
        var height = cld.outerHeight();
        var el_top = el.offset().top;
        el.css({'height':height});
        cld.css({'bottom':bottom,'width':width});
        if(window_top>(el_top+height+bottom)){
            cld.css({'position':'static'});
        }else{
            cld.css({'position':'fixed'});
            position = true;
        }
        bottom += cld.outerHeight();
        ly_sticky.add_fn(el,position);
    }
}

// 截取center前后top与bottom
ly_sticky.center_data = ()=>{
    var arr = ly_sticky.center;
    var center = [];
    for(let i=0;i<arr.length;i++){
        var el = arr[i];
        var type = el.attr('ly-sticky');
        var clone = arr;
        if(type=='center'){
            var up = clone.slice(0,i);
            var down = clone.slice(i+1);
            center.push({
                up:up,
                down:down,
                cur:arr[i]
            });
        }
    }
    ly_sticky.center_arr = center;
}

// 设置center样式
ly_sticky.center_data_ele = ()=>{
    var arr = ly_sticky.center_arr;
    var window_h = $(window).height();
    for(let i=0;i<arr.length;i++){
        var el = arr[i].cur;
        var height = el.outerHeight();
        
        var up = 0;
        var down = 0;
        for(let j=0;j<arr[i].up.length;j++){
            var type = arr[i].up[j].attr('ly-sticky');
            if(type=='top'){
                up+=arr[i].up[j].children().outerHeight();
            }
        }
        for(let k=0;k<arr[i].down.length;k++){
            var type = arr[i].down[k].attr('ly-sticky');
            if(type=='bottom'){
                down+=arr[i].down[k].children().outerHeight();
            }
        }
        var el_view = window_h-up-down;
        var px = 0;
        //判断内容是否超过可视范围
        if(el_view<height){
            var flag =  el.attr('data-type');
            if(flag=='top'){
                px = up;
            } else if(flag=='bottom'){
                px = up-(height-el_view);
            }else{
                var min_top = up-(height-el_view);
                var max_top = up;
                // 滚动的距离
                var xctop = window.scrollY-ly_sticky.scroll_top;
                var css_top = parseFloat(el.css('top'))||0;
                // 判断滚动条方向
                if(xctop<0){
                    var css_top_calc = css_top + Math.abs(xctop);
                }else if(xctop>0){
                    var css_top_calc = css_top - Math.abs(xctop);
                }
                // 当底部或顶部碰边后，通过滚动条移动距离来修正
                if(css_top_calc>max_top){
                    px = max_top;
                }else if(css_top_calc<min_top){
                    px = min_top;
                } else {
                    px = css_top_calc;
                }
            }
        }else{
            px = up;
        }
        el.css({'top':px});
    }
}


// 添加回调
ly_sticky.add_fn = (el,position)=>{
    var fn = $.callbackfn(el.attr('fn'), 'init,up,down')
    if (!el.hasClass('yidiaoyongchushihua')){
        el.addClass('yidiaoyongchushihua');
        $.eval(fn.init, el, position);
    }
    if(window.scrollY-ly_sticky.scroll_top<0){
        $.eval(fn.up, el, position);
    }else if(window.scrollY-ly_sticky.scroll_top>0){
        $.eval(fn.down, el, position);
    }
}

function ly_sticky_init(){
    ly_sticky.top_data();
    ly_sticky.bottom_data();
    ly_sticky.center_data();
    ly_sticky.center_data_ele();
}

$(window).scroll(()=>{
    ly_sticky_init();
    ly_sticky.scroll_top=window.scrollY;
})

$(window).resize(()=>{
    ly_sticky_init();
    ly_sticky.scroll_top=window.scrollY;
})


$.task.push(()=>{
    _('[ly-sticky]').each((i,item)=>{
        var el = $(item);
        var type = el.attr('ly-sticky');
        var zindex = el.attr('data-zindex');
        ly_sticky.center.push(el)
        if(type=='top'){
            zindex&&el.css({'z-index':zindex}).children().css({'z-index':zindex});
            ly_sticky.top.push(el);
        }else if(type=='bottom'){
            zindex&&el.css({'z-index':zindex}).children().css({'z-index':zindex});
            ly_sticky.bottom.unshift(el);
        }
        ly_sticky_init();
    });
});