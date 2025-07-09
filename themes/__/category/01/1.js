$(document).click(function(e){
    if ($( e.target ).closest(".ly_category_app_01 .menu, .ly_category_app_01 .ul").size()) {
        $('.ly_category_app_01 .ul').slideToggle(500)
        $('.ly_category_app_01 .menu').toggleClass('cur')
    } else {
        $('.ly_category_app_01 .ul').slideUp(500)
        $('.ly_category_app_01 .menu').removeClass('cur')
    }
})