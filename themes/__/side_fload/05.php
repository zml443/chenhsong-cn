<?php
    include dirname(__FILE__).'/__.php';
?>

<?php if(count($row)>0){?>

<link rel="stylesheet" href="/themes/__/side_fload/css/05.css">


<section class="lysidefloadbox" id="side_fload_05" data-pos="<?=g('wb_service.position')?:'6';?>">
    <div class="expand flex-max pointer">
        <span>展开</span>
    </div>
    <div class="menu hide">
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
                            <a class="li tel flex-max2 relative" href="'.$v['Href'].'"  target="'.$v['Target'].'">
                                <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                                <div class="subText absolute">
                                    <div>'.$v["Number"].'</div>
                                </div>
                            </a>
                        ';
                        break;
                    case 'wechat':
                    case 'dy':
                        echo '
                            <a class="li codeBox relative trans flex-max2" href="'.$v['Href'].'"  target="'.$v['Target'].'">
                                <div class="code absolute m-pic">
                                    <img class="absolute" src="'.$v['Picture'].'" alt="">
                                </div>
                                <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                            </a>
                        ';
                        break;
                    default:
                        echo '
                            <a class="li flex-max2 relative" href="'.$v['Href'].'" target="'.$v['Target'].'">
                                <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                            </a>
                        ';
                }
            }
            ?>
        
        <div class="backTop trans pointer">
            <div class="m-pic">
                <img class="svg" src="/themes/__/side_fload/images/05/arrow-up.svg" onload="SVGInject(this)">
            </div>
            <div class="text upper">top</div>
        </div>
    </div>
</section>



<script>
    $(document).on('click', '#side_fload_05 .expand',function(){
        if($(this).hasClass('cur')){
            $(this).removeClass('cur')
            $(this).children().html('展开')
        }else{
            $(this).addClass('cur')
            $(this).children().html('收起')
        }
        $(this).nextAll(".menu").slideToggle(function(){
            $(this).css("overflow","visible");
        });
    });

    $(document).on('click', '#side_fload_05 .backTop',function(){
        $('html,body').animate({scrollTop:0},500);
    });
</script>

<?php }?>