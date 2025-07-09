$.task.push(function() {
    _('[ly-carousel-autoloop]').each(function(){
        new ly_carousel_autoloop($(this));
    })
});

class ly_carousel_autoloop {
    constructor(el){
        this.el = el;
        // 滚动的方位
        this.direct = el.attr("data-direction")||'left';
        // 滚动的速度
        this.speed = parseInt(el.attr("data-speed"))||200;
        // 克隆的个数
        this.num = parseInt(el.attr("data-clone"))||1;
        if (this.num%2==0) this.num +=1;
        // 是否可以暂停动画，以及暂停方式
        this.stop = el.attr("data-stop")||'';
        // 回调函数
        this.fn = $.callbackfn(el.attr('fn'),'init,play,pause');
        this.setting();
    }
    setting(){
        var thi = this;
        // 原本图标个数
        var slide = [];
        // 动画的时间
        var loop_time = 0;
        // 进行动画的元素
        var loop_el = this.el.find('.wrapper');

        // 获取原本图标,并克隆
        for(let j=0; j<this.num; j++){
            this.el.find('.wrapper .slide').each((i,e)=>{
                slide.push($(e).clone())
            });
        }

        // 插入节点
        slide.forEach((item,index)=>{
            loop_el.append(item);
        })

        // 设定动画参数
        switch(this.direct){
            case 'top':
            case 'bottom':
                loop_el.css({'flex-direction':'column'});
                loop_time = parseInt((loop_el.height()) / this.speed) + 's';
                break;
            default :
                loop_el.css({'flex-direction':'row'});
                loop_time = parseInt((loop_el.width()) / this.speed) + 's';
                break;
        }
        // 添加样式
        loop_el.css({'animation-duration':loop_time});

        // 绑定事件
        if(this.stop == 'click'){
            loop_el.click(function(){
                if(loop_el.hasClass('pause')){
                    loop_el.removeClass('pause');
                    $.eval(thi.fn.play,thi.el,thi)
                }else{
                    loop_el.addClass('pause');
                    $.eval(thi.fn.pause,thi.el,thi)
                }

            })
        }else if(this.stop == 'hover'){
            loop_el.hover(function(){
                loop_el.addClass('pause');
                $.eval(thi.fn.play,thi.el,thi)
            },
            function(){
                loop_el.removeClass('pause');
                $.eval(thi.fn.pause,thi.el,thi)
            })
        }
        $.eval(this.fn.init,this.el,this);
    }
}