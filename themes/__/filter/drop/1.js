// label: lyfilter_drop_li
// 选框: lyfilter_drop_box

var lyfilter_drop = {
    // 点击回调
    click(el,checked){
        lyfilter_drop.setInit(el);
    },

    // 传入el处理固定的el，不传入处理所有，用于初始化label
    setInit(el=''){
        var label,parent,html;
        if(el){
            var label = $(el).parents('.lyfilter_drop_li').find('.lyfilter_drop_name .span');
            var parent = $(el).parents('.lyfilter_drop_box');
            var html = lyfilter_drop.setLabel(parent);
            label.html(html)
        }else{
            $('.lyfilter_drop_li').each(function(){
                label = $(this).find('.lyfilter_drop_name .span');
                parent = $(this).find('.lyfilter_drop_box');
                html = lyfilter_drop.setLabel(parent);
                label.html(html)
            })
        }
    },
    // 处理选中的input通过 '/' 拼接, el为jq对象
    setLabel(el){
        var html = '';
        var arr = [];
        el.find('input:checked').each(function(){
            var name = $(this).attr('data-label');
            arr.push(name);
        })
        var length = arr.length;

        if(length>1){
            html = `<div class="txt">${arr.join('/')}</div><div class="num">(${length})</div>`;
        }else if(length == 1){
            html = `<div class="txt">${arr.join('/')}</div>`;
        }else{
            html = `<div>请选择...</div>`;
        }
        return html;
    },
};


$(document).ready(function(){
    // 初始化label
    lyfilter_drop.setInit();

    // 结果集-初始化
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));
    ly2.lyfilter_result.edit()
})


// 展开选框
$(document).on('click', '.lyfilter_drop_li', function(e) {
    var target = $(e.target);
    // 在共同祖先元素内查找目标元素
    if (target.is('.lyfilter_drop_li')) {
        target.toggleClass('cur');
    } else {
        target.closest('.lyfilter_drop_li').toggleClass('cur');
    }
});

// 阻止选框冒泡
$(document).on('click', '.lyfilter_drop_box', function(e) {
    e.stopPropagation(); // 阻止事件冒泡至共同祖先元素
});

// 点击选框或者label框之外的区域时移除cur状态
$(document).on('click', function(e) {
    var target = $(e.target);
    if (!target.is('.lyfilter_drop_li') && !target.closest('.lyfilter_drop_li').length) {
        $('.lyfilter_drop_li').removeClass('cur');
    }
});



// 提交选框
$(document).on('submit','.lyfilter_form',function(event){
    // 整理url
    ly2.lyfilter_result.searchFormat($('.lyfilter_form'));

    location.reload();
    return false;
})