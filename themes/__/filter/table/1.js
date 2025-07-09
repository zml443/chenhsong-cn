var lyfilter_table = {
    // 点击回调
    click(el,checked){},
};


$(document).ready(function(){
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));
    ly2.lyfilter_result.edit()
})


$(document).on('click','.lyfilter_table_more',function(){
    // 整理url
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));

    location.reload();
    return false;
})