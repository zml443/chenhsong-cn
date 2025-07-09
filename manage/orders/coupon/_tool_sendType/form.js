var _tool_send_type = {
    init(el, checked){
        if(checked) this.click(el,checked);
    },
    click(el, checked){
        var type = el.val();
        let mapObj = {
            self: 'Member',
            system: 'GetRule'
        }
        for (const key in mapObj) {
            const v = mapObj[key];
            if(type == key){
                $('[data-dbs-name='+v+']').removeClass('hide2');
            }else{
                $('[data-dbs-name='+v+']').addClass('hide2');
            }
        }
    }
}