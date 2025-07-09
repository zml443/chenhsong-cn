$(document).click(function(e){
    if ($( e.target ).closest(".ly_category_app_01 .menu, .ly_category_app_01 .ul").size()) {
        if($( e.target ).closest(".ly_category_app_01 .menu.cur").size()){
            $('.ly_category_app_01 .ul').slideUp(500)
            $('.ly_category_app_01 .menu').removeClass('cur show_back')
        }else{
            $('.ly_category_app_01 .ul').slideDown(500)
            $('.ly_category_app_01 .menu').addClass('cur')
            $('.ly_category_app_01 .menu.child_cur').addClass('show_back')
        }
    } else {
        $('.ly_category_app_01 .ul').slideUp(500)
        $('.ly_category_app_01 .menu').removeClass('cur show_back')
    }
})




$(document).on('click','.ly_category_app_01 .item .name',function(){
    var menu = $(this).parents('.ly_category_app_01').find('.menu');
    var title = menu.find('.title');
    var back = menu.find('.back');
    var item = $(this).parent();

    menu.addClass('show_back child_cur');
    title.html($(this).find('span').html());
    back.attr('data-key',item.attr('data-key'));

    item.addClass('current');
    item.parents('.item.current').addClass('prev');
})


$(document).on('click','.ly_category_app_01 .menu .back',function(e){
    var el = $(this);
    var key = el.attr('data-key')
    $('.ly_category_app_01 .ul .item.current').each(function(){
        let item = $(this);
        let name = item.find('.name span').html();
        let parentkey = item.parents('[data-key]').attr('data-key');
        let prevs = item.parents('.prev');
        if(item.attr('data-key') == key){
            item.removeClass('current')
            prevs.eq(0).removeClass('prev');
            el.attr('data-key',parentkey);
            el.next('.title').html(name);
        }
    })
    if(key == 'key1'){
        el.next('.title').html(el.next('.title').attr('data-title'));
        el.parent().removeClass('child_cur show_back');
    }
    e.stopPropagation();
    // console.log('xxx',key);
})


$(document).ready(function(){
    $('.ly_category_app_01 .ul .cur').each(function(){
        let menu = $(this).parents('.ly_category_app_01').find('.menu');
        let ul = $(this).parents('.ly_category_app_01').find('.ul');
        let name = $(this).find('.name span').html();
        menu.addClass('child_cur');
        menu.find('.title').html(name);
        menu.find('.back').attr('data-key',$(this).parents('.item').attr('data-key'));
        $(this).parents('.item').addClass('current');
        // ul.slideDown();
    })
})