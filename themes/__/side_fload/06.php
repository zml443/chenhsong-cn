<?php
    include dirname(__FILE__).'/__.php';
?>

<?php if(count($row)>0){?>

<link rel="stylesheet" href="/themes/__/side_fload/css/06.css">

<section id="side_fload_06" class="lysidefloadbox relative trans pointer" data-pos="<?=g('wb_service.position')?:'6';?>">
   <div class="relative">
     <div class="btn flex-max2">
          <i class="lyicon-arrow-left-bold"></i>
     </div>
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
                                   <div class="flex-max2">
                                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                                   </div>
                                   <div class="subText absolute">
                                        <div class="flex-middle2 maxh maxw">
                                             <span>'.$v["Number"].'</span>
                                        </div>
                                   </div>
                                   <div class="text"> '.$v['Name'].'</div>
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
                                   <div class="flex-max2">
                                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                                   </div>
                                   <div class="text"> '.$v['Name'].'</div>
                              </a>
                         ';
                         break;
                    default:
                         echo '
                              <a class="li" href="'.$v['Href'].'" target="'.$v['Target'].'" >
                                   <div class="flex-max2">
                                        <img class="svg" src="'.$v['Icon'].'" onload="SVGInject(this)">
                                   </div>
                                   <div class="text"> '.$v['Name'].'</div>
                              </a>
                         ';
               }
          }
          ?>

          <div class="li backTop">
               <div class="icon m-pic">
                    <img class="svg" src="/themes/__/side_fload/images/06/rocket.svg" onload="SVGInject(this)">
               </div>
               <div class="text">返回顶部</div>
          </div>
     </div>

</section>

<script>
     $(document).on('click', '#side_fload_06 .btn',function(){
         $("#side_fload_06").toggleClass("show");
     });

     $(document).on('click', '#side_fload_06 .backTop',function(){
        $('html,body').animate({scrollTop:0},500);
     });

//      $(document).on('click', '#side_fload_06 .window_open_consult',function(){
//         let url = $(this).attr('data-url-pop');
//         let href = $(this).attr('data-href');
//         let wind_w = $(window).width()
//         let wind_h = $(window).height()
//         let w = 700
//         let h = 600
//         let left = (wind_w - w)/2-60
//         let top = (wind_h - h)/2-60
//         console.log('wind_w',wind_w,left,'wind_h',wind_h,top);
//         if(url){
//             window.open(url, "", `left=${left},top=${top},width=${w},height=${h}`);
//         }else{
//             window.open(href, "_blank");
//         }
//     });
</script>

<?php }?>