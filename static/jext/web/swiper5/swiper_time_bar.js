var swiper_time_bar = {
    init: function (el, swiper) {
        var mv = this.args(swiper);
            mv.addClass('relative over').html('<div class="el-bar absolute max" style="right:auto; width:0;"></div>');
        this.move(swiper);
    },
    end: function (el, swiper) {
        var mv = this.args(swiper);
            mv.addClass('relative over').html('<div class="el-bar absolute max" style="right:auto; width:0;"></div>');
        this.move(swiper);
    },
    args: function (swiper) {
        var el = $(swiper.$el);
        if (el.is('[time-bar="in-page"]')) {
            var page = $(swiper.pagination.$el),
                mv = page.find('.swiper-pagination-bullet-active');
            page.find('.swiper-pagination-bullet:not(.swiper-pagination-bullet-active)').html('');
        } else {
            var mv = $(el.attr('time-bar'));
        }
        return mv;
    },
    stop: function(el, swiper, stop) {
        var mv = this.args(swiper),
            bar = mv.find('.el-bar');
        if (mv.size()==0) return; 
        if (stop) {
            bar.stop();
        } else {
            bar.css({width:0});
            this.move(swiper);
        }
    },
    move: function(swiper) {
        var time = $(swiper.$el).attr('delay'),
            mv = this.args(swiper),
            width = mv.width();
        mv.find('.el-bar').animate({width:width}, parseFloat(time)*1000, function () {
            $(this).html('');
        });
    }
};

// console.log(swiper_time_bar);