var lyfilter_side = {
    // 点击回调
    click(el,checked){ },
}

$(document).ready(function(){
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));
    ly2.lyfilter_result.edit()
})

// 展开
$(document).on('click','.lyfilter_side_name',function(){
    var parent = $(this).parent();
    parent.toggleClass('cur');
    parent.find('.lyfilter_side_box').stop().slideToggle();
})



$(document).on('click','.lyfilter_side_more',function(){
    // 整理url
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));

    location.reload();
    return false;
})