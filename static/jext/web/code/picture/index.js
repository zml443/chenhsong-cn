$.task.unshift(function(){
    _('[ly-code-picture]').each(function(){
        var el = $(this)
        var rand = Math.random()
        el.attr('data-key', rand)
        // 将实例存储到window，通过data-key来区别
        window['piccode'+rand] = new code_picture_class(el)
    });
});

class code_picture_class {
    constructor(el){
		this.el = el;
        this.text = '';
		this.type = '';
		this.name = '';
        this.question = 0;
        this.fn = $.callbackfn(el.attr('fn'), 'init,refresh');
		this.get_data();
	}

    // 九宫格提示
    get_data(){
        this.type = this.el.attr('data-type')
        this.name = this.el.attr('name')
        let para = {name:this.type}
        $.async('GET', $.path+'/web/code/inc/picture_text.php', para, result=>{
            this.question++
            if(result.ret){
                this.text = result.msg
                this.create()
                if (this.question==1) {
                    $.eval(this.fn.init, this.el, result);
                } else {
                    $.eval(this.fn.refresh, this.el, result);
                }
            }
        }, 'json')
    }

    // 生成结构
    create(){
        // 九宫格
        let content = ''
        for(let i=0;i<9;i++){
            content += `
                <div class="code_picture_dd flex-max" data-number="${i+1}">
                    <i class="code_picture_dd_cur lyicon-success"></i>
                </div>`
        }
        content = `<div class="code_picture_opts">${content}</div>`
        let ohtml = `
            <div class="code_picture_content relative">
                ${content}
                <div class="code_picture_bg">
                    <img src="/static/jext/web/code/inc/picture.php?name=${this.type}" alt="">
                </div>
                <input type="hidden" name="${this.name}" value>
            </div>
            `
        this.el.html(ohtml)
    }

}
// 九宫格点击事件
$(document).on('click','[ly-code-picture] .code_picture_dd',function(){
    var el = $(this)
    if(!el.hasClass('cur')){
        el.addClass('cur')
    }else{
        el.removeClass('cur')
    }
    var check_res = []
    $('[ly-code-picture] .code_picture_dd.cur').each((i,item)=>{
        check_res.push($(item).attr('data-number'))
    })
    $('[ly-code-picture] .code_picture_content > input').val(check_res.join(","))
})


$.fn.extend({
    // 刷新
    ly_code_picture_refresh(fn){
        // 通过data-key调用对应的实例
        var rand = this.attr('data-key')
        window['piccode'+rand].get_data()
    }
})