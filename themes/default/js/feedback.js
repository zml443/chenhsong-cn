// 联系我们表单提交
$(document).on('submit', '[feedback]', function(){
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
    $.async('POST', '/api/feedback/feedback', {newFormData:formdata}, function(result){
        if (result.ret==1) {
			jQ.alert({
                str: result.msg,
                style: 'B',
                confirm: 1,
            });
            form[0].reset();
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
