$(window).ready(function(){
    $('#media-download .choose .box').on('hover',function(){
        $(this).find('.out').stop().slideToggle();
    });
    $('#media-download .mobile .top').on('click',function(){
        $(this).siblings('.out').stop().slideToggle();
        $(this).toggleClass('cur');
    });
    $('#download-pup .content .form .li .box .input.choose').on('click',function(){
        $(this).toggleClass('cur');
        $(this).find('.out').stop().slideToggle();
    });
    $('#download-pup .content .form .li .box .input.choose .out .list').on('click',function(){
        var val = $(this).html();
        $(this).parent().siblings('.top').find('input').val(val);
        $(this).parent().stop().slideUp();
    });
    $('#media-download .mobile .out .info .ul .tit').on('click',function(){
        $(this).siblings('.all').stop().slideToggle();
        $(this).parent('').siblings().find('.all').stop().slideUp();
        $(this).toggleClass('cur');
        $(this).parent('').siblings().find('.tit').removeClass('cur');
    });
    // $('#download-open').on('click',function(){
    //     console.log(1212);
    //     $('#download-pup').stop().slideDown();
    // });
    $('#download-pup .content .close').on('click',function(){
        $('#download-pup').find('input[name=wb_download_id]').val('');
        $('#download-pup').stop().slideUp();
    });
});

var file = {
	down:function(obj){
        $('#download-pup').stop().slideDown();
        $('#download-pup').find('input[name=wb_download_id]').val(obj);
    }
};

// 表单提交
$(document).on('submit', '[feedback_download]', function(){
	var form = $(this),
        check = form.check_form(),
        formdata = new FormData(form[0]);
    if (check) {
        $.alert({
            str: check[0].tip,
            style: 'B'
        });
        return false;
    }
    $.async('POST', '/api/feedback/download', {newFormData:formdata}, function(result){
        if (result.ret==1) {
			jQ.alert({
                str: result.msg.msg,
                style: 'B',
                confirm: 1,
            });
            form[0].reset();

            // window.open('/web/file/download/download.php?path=' + result.msg.path + '&ext=' + ext, '_blank');
        }else{
			jQ.alert({
                str: result.msg,
                style: 'B',
                confirm: 1,
            });
        }
    }, 'json');
    return false;
});
