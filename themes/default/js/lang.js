
$(window).ready(function(){
    $(document).on('click', '[lang-popup]', function () {
        // $.async('POST', '/themes/default/inc/lang','', function (html) {
        //     $('body').append(html);
        // });
        setTimeout(function(){
            var obj = $('#langouter');
            if (obj.is('.show')) {
                obj.removeClass('show');
            } else {
                obj.addClass('show');
            }
        },100);
    });
    
    
    
    $(document).on('click', '#langouter', function () {
        $(this).removeClass('show');
    });
    $(document).on('click', '#langouter .in .cont', function (e) {
        e.stopPropagation();
    });
})