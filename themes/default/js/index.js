$(window).ready(function(){
    // 首页定位地址信息展示
    $(document).on('click','#ind_branch .map .add',function(){
        if($(this).hasClass('cur')){
            $(this).removeClass('cur');
        }else{
            $('#ind_branch .map .add').removeClass('cur');
            $(this).addClass('cur');
        }
        if($(this).hasClass('cur')){
            var imgPath = $(this).find('.img img').attr('src');
            var txt1 = $(this).find('.txt1').text();
            var txt2 = $(this).find('.txt2').text();
            var txt3 = $(this).find('.txt3').text();
            var txt4 = $(this).find('.txt4').text();
            $('#ind_branch .map .box').addClass('in').removeClass('in2');
            $('#ind_branch .map .box .box_cont .box_left .img img').attr('src',imgPath?imgPath:'');
            $('#ind_branch .map .box .box_cont .box_right .txt1').text(txt1?txt1:'');
            $('#ind_branch .map .box .box_cont .box_right .txt2').text(txt2?txt2:'');
            $('#ind_branch .map .box .box_cont .box_right .txt3').text(txt3?txt3:'');
            $('#ind_branch .map .box .box_cont .box_right .txt4').text(txt4?txt4:'');
            if($('#ind_branch .map .box').hasClass('in')){
                $('#ind_branch .map .box').removeClass('in');
                // setTimeout(function(){
                    $('#ind_branch .map .box').addClass('in');
                // },500);
            }
        }
    });
   
    // 关闭盒子  
    $(document).on('click','#ind_branch .map .box .box_cont .close',function(){
        $(this).parents('.box').removeClass('in').addClass('in2');
        $('#ind_branch .map .add').removeClass('cur');
    });

    
    // 设置元素的滚动条水平位置  
    var branch_w = $(window).width();
    if(branch_w<=750){
        $("#ind_branch .bot").scrollLeft(580);
    }

    // 右侧-返回顶部
    // $(window).scroll(function() {  
    //     if ($(window).scrollTop() >= $(document).height() - $(window).height() - $("#footer").height()) {
    //         $("#sidebar .backTop").show();
    //     }else{
    //         $("#sidebar .backTop").hide();
    //     }
    // });
});