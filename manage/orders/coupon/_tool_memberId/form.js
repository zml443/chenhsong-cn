var _tool_memberId = {
    createCode(el){
        var parent = $(el).parents('._dbs_item');
        $.async('GET', '?ma=orders/coupon/_check_code', {}, result=>{
            if(result.ret == 1){
                parent.find('[data-code]').val(result.msg);
            }
            console.log(result);
        },'json')
    }
}