// 关于我们-荣誉资质
// 点击展开
$(document).on('click','#about_honor .top .selectBox .inp',function(){
    $(this).toggleClass('cur');
    $(this).parents('.selectBox').toggleClass('cur');
    $(this).next('.two_box').slideToggle();
});

// 鼠标移出,收起
$(document).on('mouseleave','#about_honor .top .selectBox .two_box',function(){
    $(this).slideUp();
});

// 投资者关系
$(window).ready(function(){
    // 右侧菜单
    if ($(window).width()<=1024) {
        $('#menu-invest .title').on('click',function(){
            $(this).toggleClass('cur');
            $(this).parents('#menu-invest').toggleClass('cur');
            $(this).next('.two').slideToggle();
        });
    };

    // 投资者联系
    $('#invest_contact .box .item .ul .sel_box .p1').on('click',function(){
        $(this).toggleClass('cur');
        $(this).parents('#sel_box').toggleClass('cur');
        $(this).next('.p2').slideToggle();
    });
});
