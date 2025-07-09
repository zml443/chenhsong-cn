<?php
    include dirname(__FILE__).'/__.php';
?>

<?php if(count($row)>0){?>

<link rel="stylesheet" href="/themes/__/side_fload/css/01.css">

<section class="lysidefloadbox" id="side_fload_01" data-pos="<?=g('wb_service.position')?:'6';?>">
    <?php
    foreach($row as $k => $v){
        if($v['isHide']){
            continue;
        }
        switch ($v['Type']) {
            case 'tel':
            case 'fax':
            case 'mobile':
            case 'email':
                echo '
                    <a class="telBox" href="'.$v['Href'].'" target="'.$v['Target'].'">
                        <div class="box trans flex-middle2">
                            <div class="telImg trans flex-max2">
                                <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                            </div>
                            <div class="text">'.$v['Number'].'</div>
                        </div>
                    </a>
                ';
                break;
            case 'wechat':
            case 'dy':
                echo '
                    <a class="codeBox flex-max2" href="'.$v['Href'].'" target="'.$v['Target'].'">
                        <div class="code absolute m-pic"><img class="absolute" src="'.$v['Picture'].'" alt=""></div>
                        <div class="">
                            <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                        </div>
                    </a>
                ';
                break;
            default:
                echo '
                    <a class="messageBox flex-max2" href="'.$v['Href'].'" target="'.$v['Target'].'" >
                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                    </a>';

        }
    }
    ?>


    <div class="backTop m-pic trans">
        <img class="svg" src="/themes/__/side_fload/images/01/backTop.svg" onload="SVGInject(this)">
    </div>
</section>

<script>
    $(document).on('click', '#side_fload_01 .backTop',function(){
        $('html,body').animate({scrollTop:0},500);
    });

    $(document).on('mouseenter', '#side_fload_01 .telBox',function(){
        var text = $(this).find('.text').innerWidth();
        var base = $(this).find('.telImg').innerWidth();
        if(parseInt(text) <= 300 ) text = 300;
        $(this).find('.box').css({'width':text+base+10});
    });

    $(document).on('mouseleave', '#side_fload_01 .telBox',function(){
        $(this).find('.box').css({'width':55});
    });


    // $(document).on('click', '#side_fload_01 .window_open_consult',function(){
    //     let url = $(this).attr('data-url-pop');
    //     let href = $(this).attr('data-href');
    //     let wind_w = $(window).width()
    //     let wind_h = $(window).height()
    //     let w = 700
    //     let h = 600
    //     let left = (wind_w - w)/2-60
    //     let top = (wind_h - h)/2-60
    //     console.log('wind_w',wind_w,left,'wind_h',wind_h,top);
    //     if(url){
    //         window.open(url, "", `left=${left},top=${top},width=${w},height=${h}`);
    //     }else{
    //         window.open(href, "_blank");
    //     }
    // });
</script>

<?php }?>