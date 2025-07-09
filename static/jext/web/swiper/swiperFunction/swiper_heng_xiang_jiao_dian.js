var swiper_heng_xiang_jiao_dian = {
    progress: function (el, swiper, progress) {
        var translateWidth = 460/2;
        for (i = 0; i < swiper.slides.length; i++) {
            var slide = swiper.slides.eq(i);
            var slideProgress = swiper.slides[i].progress;
            modify = 1;
            if (Math.abs(slideProgress) > 1) {
                modify = (Math.abs(slideProgress) - 1) * 0.15 + 1;
            }
            translate = slideProgress * modify * translateWidth + 'px';
            scale = 1 - Math.abs(slideProgress) / 6;
            zIndex = 999 - Math.abs(Math.round(10 * slideProgress));
            slide.transform('translateX(' + translate + ') scale(' + scale + ')');
            slide.css('zIndex', zIndex);
            slide.css('opacity', 1);
            if (Math.abs(Math.round(slideProgress)) > 2) {
                slide.css('opacity', 0);
            }
        }
    },
    transition: function(el, swiper, transition) {
        for (var i = 0; i < swiper.slides.length; i++) {
            var slide = swiper.slides.eq(i);
            slide.transition(transition);
        }
    }
};