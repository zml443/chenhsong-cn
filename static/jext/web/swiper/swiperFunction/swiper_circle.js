$('[jextstyle]').append('.circle-page{left:0;right:0;bottom:10px;z-index:11;}.circle-page .circle{width:30px;height:30px;margin:0 4px;}');
var swiper_circle = undefined;
$.eval('canvas-circle', function(){
swiper_circle = {
    swiper: {
        init: function (el, swiper) {
            var page = $(swiper.pagination.$el),
                circle = el.attr('circle-page'),
                h = '',
                k = page.find('.swiper-pagination-bullet-active').index();
            page.children('*').each(function (i) { 
                h += '<div class="circle inline-block relative trans '+(k==i?'cur':'')+'" onclick="swiper_circle.circle.click(this)"><div class="a trans"></div><div class="b trans"></div><div class="c trans"></div><div class="d maxh maxw trans" canvas-circle="'+(k!=i?circle:(circle||'').replace(/,? ?stop: ?1/,''))+'" fn="swiper_circle.circle" s="'+el.a('swiper')+'"></div></div>';
            });
            page.css({opacity:0});
            el.append('<div class="circle-page absolute text-center">'+h+'</div>');
        },
        end: function (el, swiper) {
            var index = el.find('.swiper-pagination-bullet-active').index(),
                page = el.find('.circle-page');
            page.find('.d').trigger('reset');
            page.children().eq(index).find('.d').trigger('play');
        },
    },
    circle: {
        init: function (el) {
            // 
        },
        end: function (el) {
            var el = $(el),
                parent = el.parent(),
                next = parent.next().size() ? parent.next() : parent.parent().children().eq(0),
                index = next.index(),
                swiper_el = $('[jx-o-swiper="'+el.attr('s')+'"]'),
                swiper = swiper_el.o('swiper');
            if (swiper_el.is('[loop]')) {
                swiper.slideNext();
            } else {
                $(swiper.pagination.$el).children().eq(index).trigger('click');
            }
        },
        click: function (el) {
            var el = $(el),
                index = el.index(),
                parent = el.parent(),
                swiper = $('[jx-o-swiper="'+el.find('.d').attr('s')+'"]').o('swiper');
            parent.find('.circle').each(function(k){
                if (index!=k) {
                    $(this).find('.d').trigger('reset');
                }
            });
            $(swiper.pagination.$el).children().eq(index).trigger('click');
        }
    }
};
});