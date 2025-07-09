// 切换事件 - 选择不同的优惠类型便切换不同的输入框
var dbs_free_type_fn = {
    init(el, checked){
        if(checked) this.click(el);
    },
    click(el, checked){
        var type = el.val();
        if(type=='all') {
            el.parents('._dbs_content').find('.tab_content > *[data-con]').addClass('hide2');
        }else{
            el.parents('._dbs_content').find('.tab_content > *[data-con="'+type+'"]').removeClass('hide2').siblings('[data-con]').addClass('hide2');
        }
    }
};