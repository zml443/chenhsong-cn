var timer;
var _tool_useQty_cb = {
    writeNumber(el){
        clearTimeout(timer);
        timer = setTimeout(()=>{
            var val = $(el).val();
            if(val&&val!=''){
                $(el).parents('._dbs_content').find('[type="checkbox"]').removeAttr('checked').parents('label').removeClass('cur');
            }
        },300)
    },
    init(el,checked){
        if(checked) this.click(el);
    },
    click(el,checked){
        if(checked){
            el.parents('._dbs_content').find('[type="text"]').val('');
        }
    },
}