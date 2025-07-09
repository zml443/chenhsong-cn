
$(window).ready(function(){
    // 头部二级菜单展示
    $('#header .hnav .one-nav').hover(function(){
        var big = $(this);
        var h = big.find('.h').outerHeight();
        big.find('.two-nav').height(h+1);
    }, function(){
        var big = $(this).parent();
        big.find('.two-nav').height(0);
    });

    /* 底部 */
    if ($(window).width()<=750) {	
        $(document).on('click',"#footer .fnav .fnav-one",function(){
            var fnav = $(this).parent();
            var o_h = fnav.find('.h').outerHeight();
            if (fnav.hasClass('in')) {
                fnav.removeClass('in');
                fnav.find('.fnav-two').height(0);
            }else{
                $('#footer .fcenter .fleft .fnav').removeClass('in');
                $('#footer .fcenter .fleft .fnav').find('.fnav-two').height(0);
                fnav.addClass('in');
                fnav.siblings().removeClass('in');
                fnav.find('.fnav-two').height(o_h);
                fnav.siblings().find('.fnav-two').height(0);
            }
        });

        $(document).on('click', '#footer .ftop .fright .fnav .fnav-two .list .list-pro .pro-one', function() {
            var par = $(this).parents('.list-pro');
            par.toggleClass('cur');
            par.find('.pro-box').slideToggle();
            par.siblings().removeClass('cur').find('.pro-box').slideUp();
        });
    };
    
    $('#footer .ftop .fleft .share .icon').hover(function(){
        if($(this).hasClass('cur')){
            $(this).removeClass('cur');
            $(this).children('.code').hide();
        }else{
            $(this).addClass('cur');
            $(this).children('.code').show();
        }
    });

    $('#footer .ftop .fleft .left_icon').hover(function(){
        var big = $(this);
        var h = big.find('.ul').outerHeight();
        $('#footer .ftop .fleft .left_icon').addClass('cur');
        big.find('.two_cont').height(h+1);
    }, function(){
        var big = $(this).parent();
        $('#footer .ftop .fleft .left_icon').removeClass('cur');
        big.find('.two_cont').height(0);
    });
});

var header = {
    //导航滚动效果
    nav: function(){
        var p=0,t=0;
        $(window).scroll(function(e){
            if($(window).width() <= 750){
                $("#header").removeClass('none');
                return false;
            }
            p = $(this).scrollTop();
            if(p > 0){
                $('#header').addClass('cur');
            }else{
                $('#header').removeClass('cur');
            }
            setTimeout(function(){t = p;},0);
        });
    },
    //手机版头部
    m_nav: function(){
        var wi = $(window).width();
        if(wi <= 1024){
            $(document).on('click', '#header .menu', function() {
                $(this).toggleClass('cur');
                $('#m-nav').toggleClass('cur');
                $('#m-nav .one-nav').removeClass('cur');
                $('#m-nav .one-nav .two-nav').slideUp();
            });

            $(document).on('click', '#m-nav .nav .one-nav', function() {
                $(this).toggleClass('cur');
                $(this).find('.two-nav').slideToggle();
                $(this).siblings().removeClass('cur').find('.two-nav').slideUp();
                $(this).siblings().find('.two-a').removeClass('cur');
            });

            $(document).on('click', '#m-nav .nav .one-nav .two-nav .two-other', function() {
                $('#m-header .menu').removeClass('cur');
                $('#m-nav').removeClass('cur');
                $('#m-nav .one-nav .two-nav').slideUp();
            });

            $(document).on('click', '#m-nav .nav .one-nav .two-nav>div', function(e) {
                e.stopPropagation();
            });

            $(document).on('click', '#m-nav .nav .one-nav .two-pro', function() {
                $(this).toggleClass('cur');
                $(this).find('.pro-box').slideToggle();
                $(this).siblings().removeClass('cur').find('.pro-box').slideUp();
            });
        }
    },

    //头部搜索
    search: function(){
        var wi = $(window).width();
        if(wi <= 750){
            $(document).on('click','#header .search',function(){
                $('#search-box').slideToggle();
                $(this).toggleClass('cur');
            });
        }
    },
    
    // 二级导航
    second_nav: function(){
        // 二级导航点击切换
        $(document).on('click','#megacloud-choose .container .slide',function(){
            $(this).addClass('cur').siblings().removeClass('cur');
        });

        $(window).scroll(function(e){
			// 要加 关于MegaCloud震雄智云平台 + Banner 的高度
            var banner_h = $('#megacloud-choose').height();
            var scrollTop = $(this).scrollTop();
            
            // 二级导航固定
            if(scrollTop>banner_h){
                $('#megacloud-choose').addClass('cur');
            }else{
                $('#megacloud-choose').removeClass('cur');
            }

            // 二级导航滚动切换
            $('[position-follow-cur]').each(function(){
                var obj = $($(this).attr('position-follow-cur'));
                if (obj.size()==0) {
                    return;
                }
                var top = obj.offset().top;
                if(scrollTop>=top-160){
                    var cur = $(this);
                    cur.addClass('cur').siblings().removeClass('cur');
                }
            });
        });
    }
};

/* 首页banner轮播切换*/
var banner = {  
    interleaveOffset:'0.5',
    bannerProgress:function(s){// 偏移值
        for (var i = 0; i < s.slides.length; i++) {
            var slideProgress = s.slides[i].progress;
            var innerOffset = s.width * this.interleaveOffset;
            var innerTranslate = slideProgress * innerOffset;
            s.slides[i].querySelector(".slide-inner").style.transform =
            "translate3d(" + innerTranslate + "px, 0, 0)";
        }
    },

    bannerStart:function(s){// 开始
        for (var i = 0; i < s.slides.length; i++) {
            s.slides[i].style.transition = "";
        }
    },

    bannerTransition:function(s){// 过渡
        var speed = $('#index-swiper .container').attr('speed')*1000;
        for (var i = 0; i < s.slides.length; i++) {
            s.slides[i].style.transition = speed + "ms";
            s.slides[i].querySelector(".slide-inner").style.transition =
            speed + "ms";
        }
    },
};

var banner_swiper = {
    // 初始化时调用
    init: function (el, swiper) {
        banner.bannerProgress(swiper);
    },
    // 切换开始前调用
    start: function (el, swiper) {
        banner.bannerStart(swiper);
    },
    // 拖拽前后都会调用一次
    transition: function (el, swiper, transition) {
        banner.bannerTransition(swiper);
    },
    // 拖拽过程中重复调用
    progress: function (el, swiper, progress) {
        banner.bannerProgress(swiper);
    }
};

// 侧边栏
$.include('/themes/default/js/side_fload.js');

// 首页
$.include('/themes/default/js/index.js');

// 在线留言
$.include('/themes/default/js/feedback.js');

// 语言弹窗
$.include('/themes/default/js/lang.js');

// 产品详情
$.include('/themes/default/js/products.js');

// 关于我们
$.include('/themes/default/js/about.js');

// 联系我们
$.include('/themes/default/js/contact.js');

// 文件下载
$.include('/themes/default/js/download.js');