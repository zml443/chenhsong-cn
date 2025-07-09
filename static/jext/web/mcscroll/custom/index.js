class ly_scroll_custom{
	constructor(el){
        this.el_move = el.children().eq(0);
        this.el_move.addClass('scrollbar-hide');
        el.append('<div class="ly_scroll_custom_x"><div class="ly_scroll_custom_slide_x"></div></div>');
        el.append('<div class="ly_scroll_custom_y"><div class="ly_scroll_custom_slide_y"></div></div>');
        this.el = el;
        this.cus_x = el.find('.ly_scroll_custom_x');//滑轨
        this.cus_li_x = el.find('.ly_scroll_custom_slide_x');//滑块
        this.cus_y = el.find('.ly_scroll_custom_y');
        this.cus_li_y = el.find('.ly_scroll_custom_slide_y');

        this.has_watch_x = 0;
        this.has_watch_y = 0;

        this.min_top = 50;//滚动条停止计算的最小相对父级的上边距

        this.fn = $.callbackfn(this.el.attr('fn'),'init,up,scroll,down');
        this.set_visibility();
        this.drag();
        this.events();
        this.auto_calc();
        $.eval(this.fn.init, this.el, this);
	}
    set_translate_zindex(){//设置滚动条偏移与层级
        let zIndex = this.el.attr('data-zIndex')||'15';
        let scroll_translateX = Math.abs(this.el.attr('data-scroll-translateX')||0);
        // let scroll_translateY = Math.abs(this.el.attr('data-scroll-translateY')||0);
        // this.cus_x.css({transform: 'translateY(-'+scroll_translateY+'px)',zIndex:zIndex});
        this.cus_x.css({zIndex:zIndex});
        this.cus_y.css({transform: 'translateX(-'+scroll_translateX+'px)',zIndex:zIndex});
    }
    set_visibility(){
        // el参数，el_w自身宽度，el_li_w内容区宽度
        this.el_w = this.el_move.width();
        this.el_li_w = this.el_move.prop('scrollWidth');
        this.el_h = this.el_move.height();
        this.el_li_h = this.el_move.prop('scrollHeight');

        // 设置滑轨宽度
        // this.cus_x.css({width: parseInt(this.el_move.width())-1 + 'px'});
        // this.cus_y.css({height: parseInt(this.el_move.height())-1 + 'px'});

        // 控制滑块宽度，以及滑轨的显示隐藏
        // y:
        if(this.el_li_h>this.el_h){
            this.cus_li_y.css({height: parseFloat((this.el_h / this.el_li_h)*100) + '%'});
            this.cus_y.removeClass('hide');
        }else{
            this.cus_y.addClass('hide');
        }
        // x:
        if(this.el_li_w>this.el_w){
            this.cus_li_x.css({width: parseFloat((this.el_w / this.el_li_w)*100) + '%'})
            this.cus_x.removeClass('hide');
        }else{
            this.cus_x.addClass('hide');
        }
    }
    set_el_y(){
        var col_xy = this.cus_li_y.matrix();
        var height = parseFloat(this.cus_y.height()) - parseFloat(this.cus_li_y.height());
        var cus_li_top = col_xy[5];
        var col_cc = cus_li_top / height;
        var col_target = this.el_li_h - this.el_h;
        this.el_move.scrollTop(col_target*col_cc);
    }
    set_el_x(){
        var row_xy = this.cus_li_x.matrix();
        // 计算自定义滚动比例
        var width = parseFloat(this.cus_x.width()) - parseFloat(this.cus_li_x.width());
        var cus_li_left = row_xy[4];
        var row_cc = cus_li_left / width;
        // 操作目标滚动条
        var row_target = this.el_li_w - this.el_w;
        this.el_move.scrollLeft(row_target*row_cc);
    }
    set_cus_y(){
        var col_xy = this.cus_li_y.matrix();
        var top = parseFloat(this.el_move.scrollTop());
        var col_target = this.el_li_h - this.el_h;
        var col_cc = top / col_target;
        // 操作自定义滚动条
        var height = parseFloat(this.cus_y.height()) - parseFloat(this.cus_li_y.height());
        col_xy[5] = height*col_cc;
        this.cus_li_y.matrix(col_xy);
    }
    set_cus_x(){
        var row_xy = this.cus_li_x.matrix();
        var left = parseFloat(this.el_move.scrollLeft());
        var row_target = this.el_li_w - this.el_w;
        var row_cc = left / row_target;
        // 操作自定义滚动条
        var width = parseFloat(this.cus_x.width()) - parseFloat(this.cus_li_x.width());
        row_xy[4] = width*row_cc;
        this.cus_li_x.matrix(row_xy);
    }
    drag(){
        var thi = this;
        this.cus_y.move(this.cus_li_y, {
			x: 0,
			y: 1,
			box: thi.cus_li_y,
			down: function () {
                thi.has_watch_y = 1;
                $.eval(thi.fn.down, thi.el, thi);
            },
			move: function (d) {
                thi.set_el_y();
                $.eval(thi.fn.scroll, thi.el, thi);
            },
			up: function (d) {
                thi.has_watch_y = 0;
                $.eval(thi.fn.up, thi.el, thi);
            }
		});

        this.cus_x.move(this.cus_li_x, {
			x: 1,
			y: 0,
			box: thi.cus_li_x,
			down: function () {
                thi.has_watch_x = 1;
                $.eval(thi.fn.down, thi.el, thi);
            },
			move: function (d) {
                thi.set_el_x();
                $.eval(thi.fn.scroll, thi.el, thi);
            },
			up: function (d) {
                thi.has_watch_x = 0;
                $.eval(thi.fn.up, thi.el, thi);
            }
		});
    }
    events(){
        var thi = this;
        this.el_move.scroll(function() {
            if(!thi.has_watch_y){
                thi.set_cus_y();
            }
            if(!thi.has_watch_x){
                thi.set_cus_x();
            }
        });

        $(window).resize(function(){
            thi.set_visibility()
        })
    }
    auto_calc(){
        this.set_translate_zindex();
        let xy = this.el_move[0].getBoundingClientRect();
        let win_h = $(window).height();
        let topY = win_h-xy.top;//窗口高与元素的top差，<=0时，代表目标的头部 滚离底部窗口
        let bottomY = win_h-xy.bottom;//窗口高与元素的bottom差，<=0时，代表目标的底部 接触底部窗口
        // 偏移量
        let scroll_translateY = Math.abs(this.el.attr('data-scroll-translateY')||0);
        if(win_h<xy.bottom){
            if(this.min_top<topY){
                let pos = xy.height - (topY);
                this.cus_x.css({bottom:pos + 'px'})
            }
            // 触顶修正
            if(topY<2*scroll_translateY){
                let translateY = (topY-scroll_translateY)>0?(topY-scroll_translateY):0;
                this.cus_x.css({transform: 'translateY(-'+translateY+'px)'})
            }
        }else if(win_h>xy.bottom){
            this.cus_x.css({bottom:0,transform: 'translateX(0)'})
            // 触底修正
            if(bottomY<scroll_translateY){
                let translateY = scroll_translateY-(bottomY);
                this.cus_x.css({transform: 'translateY(-'+translateY+'px)'})
            }
        }
        // console.log('height',win_h,'\ntop',xy.top,'\nbottom',xy.bottom,'\ntop差',topY,'\nbottom差',bottomY);
        requestAnimationFrame(()=>{
            this.auto_calc();
        });
    }
}


$.task.push(function () {
	_('[ly-scroll-custom]').each(function() {
		var xxx = new ly_scroll_custom($(this));
		$(this).o('ly-scroll-custom',xxx);
	});
});