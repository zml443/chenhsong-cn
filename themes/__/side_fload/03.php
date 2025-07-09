<?php
    include dirname(__FILE__).'/__.php';
?>

<?php if(count($row)>0){?>

<link rel="stylesheet" href="/themes/__/side_fload/css/03.css">

<section class="lysidefloadbox" id="side_fload_03" data-pos="<?=g('wb_service.position')?:'6';?>">
    <div class="ul">
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
                    <a class="li" href="'.$v['Href'].'" target="'.$v['Target'].'">
                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                        <div class="text">'.$v["Name"].'</div>
                        <div class="subText absolute trans">
                            <div>'.$v["Number"].'</div>
                        </div>
                    </a>
                ';
                break;
            case 'wechat':
            case 'dy':
                echo '
                    <a class="li codeBox" href="'.$v['Href'].'" target="'.$v['Target'].'">
                        <div class="code absolute m-pic">
                            <img class="absolute" src="'.$v['Picture'].'" alt="">
                        </div>
                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                        <div class="text">'.$v['Name'].'</div>
                    </a>
                ';
                break;
            default:
                echo '
                    <a class="li" href="'.$v['Href'].'" target="'.$v['Target'].'" >
                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                        <div class="text">'.$v['Name'].'</div>
                    </a>
                ';
        }
    }
    ?>
    <div class="moveblock"></div>
    </div>

    <div class="backTop m-pic trans">
        <img class="svg trans" src="/themes/__/side_fload/images/03/rocket.svg" onload="SVGInject(this)">
    </div>
</section>


<script>
    $(document).on('click', '#side_fload_03 .backTop',function(){
        $('html,body').animate({scrollTop:0},500);
    });

    $(document).on('mouseenter', '#side_fload_03 .li',function(){
        $(this).addClass('cur').siblings().removeClass('cur');
        var width = $(this).innerWidth();
        var height = $(this).innerHeight();
        var left = this.offsetLeft;
        var top = this.offsetTop;
        $('#side_fload_03 .moveblock').css({'width':width,'height':height,'top':top,'left':left})
    });



    // $(document).on('click', '#side_fload_03 .window_open_consult',function(){
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