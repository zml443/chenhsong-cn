$.task.push(()=>{
    _('[ly-scroll-calc]').each(function(i, e){
        var el = $(this);
        var fn = $.callbackfn(el.attr('fn'),'init,scroll,start,end');
        var xxx = el.visible_scroll({
            start_el: el.attr('data-start-el')||el.attr('data-el'),
            end_el: el.attr('data-end-el')||el.attr('data-el'),
            type: el.attr('data-type')||'show',
            init(res){
                $.eval(fn.init, $(this), res);
            },
            start(res){
                $.eval(fn.start, $(this), res);
            },
            end(res){
                $.eval(fn.end, $(this), res);
            },
            scroll(res){
                $.eval(fn.scroll, $(this), res);
            },
        });
        el.o('ly-scroll-calc', xxx);
    });
});
