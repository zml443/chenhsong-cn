// banner轮播
var products_swi = {
    init: function (el, swiper) {
        $(document).on('click','#pro_banner .small_swi .slide',function(){
            var index = $(this).index();
            swiper.slideTo(index);
        });
    },
};