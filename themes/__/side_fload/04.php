<?php
    include dirname(__FILE__).'/__.php';
?>

<?php if(count($row)>0){?>

<link rel="stylesheet" href="/themes/__/side_fload/css/04.css">

<section id="side_fload_04" class="lysidefloadbox relative trans pointer" data-pos="<?=g('wb_service.position')?:'6';?>">
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
                         <a class="tel flex-max2" href="'.$v['Href'].'" target="'.$v['Target'].'">
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
                         <a class="codeBox flex-max2" href="'.$v['Href'].'" target="'.$v['Target'].'">
                              <div class="code absolute m-pic"><img class="absolute" src="'.$v['Picture'].'" alt=""></div>
                              <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                         </a>
                    ';
                    break;
               default:
                    echo '
                         <a class="flex-max2" href="'.$v['Href'].'" target="'.$v['Target'].'">
                              <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                         </a>
                    ';
          }
     }
     ?>

    <div class="backTop pointer">
          <div class="m-pic"><img class="svg trans" src="/themes/__/side_fload/images/05/arrow-up.svg" onload="SVGInject(this)"></div>
          <div class="text upper">top</div>
    </div>
</section>



<script>
     $(document).on('click', '#side_fload_04 .backTop',function(){
        $('html,body').animate({scrollTop:0},500);
     });

     // $(document).on('click', '#side_fload_04 .window_open_consult',function(){
     //      let url = $(this).attr('data-url-pop');
     //      let href = $(this).attr('data-href');
     //      let wind_w = $(window).width()
     //      let wind_h = $(window).height()
     //      let w = 700
     //      let h = 600
     //      let left = (wind_w - w)/2-60
     //      let top = (wind_h - h)/2-60
     //      console.log('wind_w',wind_w,left,'wind_h',wind_h,top);
     //      if(url){
     //           window.open(url, "", `left=${left},top=${top},width=${w},height=${h}`);
     //      }else{
     //           window.open(href, "_blank");
     //      }
     // });
</script>

<?php }?>