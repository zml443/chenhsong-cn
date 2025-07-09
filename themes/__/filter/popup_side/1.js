
var lyfilter_popup_side = {
    // 点击回调
    click(el,checked){
    },
}

$(document).ready(function(){
    // 结果集-初始化
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));
    ly2.lyfilter_result.edit()
})


// 展开
$(document).on('click','.lyfilter_popup_side_name',function(){
    var parent = $(this).parent();
    parent.toggleClass('cur').siblings().removeClass('cur');
    parent.find('.lyfilter_popup_side_box').stop().slideToggle();
    parent.siblings().find('.lyfilter_popup_side_box').stop().slideUp();
})


// 提交
$(document).on('submit','.lyfilter_form',function(){
    // 整理url
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));

    location.reload();
    return false;
})