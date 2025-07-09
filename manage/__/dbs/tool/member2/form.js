var dbs_member_crowd = {
    init(el, checked){
        if(checked) this.click(el);
    },
    click(el, checked){
        var parents = el.parents('label');
        var type = el.val();
        el.attr('checked','checked');
        parents.siblings().find('input').removeAttr('checked');
        if(type=='all') {
            el.parents('._dbs_content').find('.tab_content > *[data-con]').addClass('hide2');
        }else{
            el.parents('._dbs_content').find('.tab_content > *[data-con="'+type+'"]').removeClass('hide2').siblings('[data-con]').addClass('hide2');
        }
    }
};