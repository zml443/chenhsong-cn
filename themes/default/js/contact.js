// 全球分公司  ==================================================================================

$('#contact_two .selBtn').on('click', function(){
    $(this).toggleClass('cur');
    $(this).next('.two_box').slideToggle();
});
$('#contact_two .two_box').on('mouseleave',function(){
    $(this).prev('.selBtn').toggleClass('cur');
    $(this).slideToggle();
});

$(document).on('click','#contact_two .two_box .li',function(){
    var cid = $(this).data('cid');
    var txt = $(this).text();
    $('#contact_two .selBtn span').text(txt);

    $.post('/ajax/contact', {cid:cid}, function(html){
        $('#contact_two .ajaxBox').html(html);
    },'html');
    return false;
});
// ==================================================================================




// 表单==================================================================================
// 点击展开
$(document).on('click','#sel_ind .tit1',function(){
    $(this).toggleClass('cur');
    $(this).parents('.selectBox').toggleClass('cur');
    $(this).next('.two-box').slideToggle();
});

// 鼠标移出,收起
$(document).on('mouseleave','#sel_ind .two-box',function(){
    $(this).slideToggle();
});

// 点击选项,修改input的value
$(document).ready(function() {
    $(document).on('click', '#sel_ind .two-box .cont .ist', function (e) {
        var _this = this;
        if(!$(_this).hasClass('not')){
            setTimeout(function(){
                e.stopPropagation();

                var checked =  $(_this).parent('.cont').find(".ist.cur");
                var str = '';
                var i = 0;

                for(i=0; i<checked.length; i++) {
                    str += (checked.eq(i).find('.fonts').text() + ",");
                }

                console.log(str);
                str = str.substring(0, str.lastIndexOf(','));
                $(_this).parents('.selectBox').find('.tit').val(str);
            },10)
        }
    });
});
// 表单==================================================================================