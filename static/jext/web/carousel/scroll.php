<!DOCTYPE html>
<html lang="zh-cn">
<?php include $c['themes'] . '/include/style_script.php'; ?>
<body>
<div body>
    <style>
        /*
            .honor-con .slide.RightSwicth>div{transform:scale(0.8) rotateY(-30deg);}
        */
        *{ font-family: '微软雅黑';}
        .scroll-outer{
            margin: 100px 0;
        }
        .scroll-btn{
            /* margin: 0 auto; */
            /* width: 300px; */
            height: 10px;
            background: #000;
        }
        .carousel-outer{ margin: 0 auto; padding: 50px 0; width: 1400px; overflow: hidden;}
        .carousel{ display: flex; justify-content: start; align-items: center; position: relative;}
        .carousel .item{ position: relative; width: 470px; height: 300px; flex-shrink: 0; perspective: 470px; transform-style: preserve-3d;}
        .carousel .item div{height: 300px; background: #f00;}
        .carousel .item:nth-child(even) div{ background: #000;}
    </style>
    <div class="carousel-outer">
        <div class='carousel'>
            <?php for($i = 0; $i < 10; $i++){?>
                <div class="item"><div style="font-size: 20px; text-align: center; line-height: 300px; color: #fff;"><?=$i; ?></div></div>
            <?php }?>
        </div>
        <div class="scroll-outer">
            <div class="scroll-btn"></div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    var scroll = {
        init: function(){
            var a = this;
            a.car_o = $('.carousel');
            a.item = $('.carousel .item');
            a.scr_o = $('.scroll-outer');
            a.bar = $('.scroll-outer .scroll-btn');
            a.item_length = a.item.length;

            a.bar.move('',{
                x: 1,
                box: $('.scroll-outer'),
                down: function(){
                    clearInterval(a.time);
                },
                move: function(s){
                    a.move(s);
                },
                up: function(s){
                    var thi = this;
                    //鼠标移开回调
                    var bar_box_w = a.scr_o.width() / a.item_length;    //获取滚动条盒子宽度
                    var j = Math.round(s.left / bar_box_w);
                    var w = j * bar_box_w;
                    
                    a.time = setInterval(function(){
                        if(s.left < w){
                            s.left+=2;
                            if(s.left > w){
                                s.left = w;
                            }
                        }else if(s.left > w){
                            s.left-=2;
                            if(s.left < w){
                                s.left = w;
                            }
                        }else{
                            clearInterval(a.time);
                        }
                        console.log(a.time);
                        thi.v.move(s); 
                        mx = 'matrix(1,0,0,1,'+s.left+',0)';
                        a.bar.css({transform : mx});
                    }, 10);
                }
            });
            //滚动条宽度
            a.bar_width();
            
            //无限循环
            a.copy();
            
            //无限循环
            a.move({left:0});
        },
        bar_width: function(){
            var a = this;
            var mw1 = a.item.width();
            var sw1 = a.item_length * mw1;
            var mw2 = a.scr_o.width() / sw1 * mw1;
            a.bar.css({'width': mw2});
        },
        copy: function(){
            var a = this;
            var cop = [];

            //复制一份
            a.item.each(function(){
                cop.push($(this).clone());
                a.car_o.append($(this).clone());
            });
            
            //复制两份
            for(var i = 0; i < cop.length; i++){
                a.car_o.append(cop[i]);
            }
            
            var width = a.car_o.width() - a.item.width();
            var mw1 = a.item.width() * a.item_length;
            a.car_o.css({'left': -mw1 + parseFloat(width / 2)});
        },
        move: function(s){ 
            var a = this;   
            //滚动距离
            var w = a.item.width();
            var w1 = a.item_length * a.item.width();
            var w2 = a.scr_o.width();
            //var w3 = a.item.width();
            var x2 = s.left;        //滚动条位置
            var x1 = x2*(w1/w2);
            var bar_w = a.bar.width();
            var bar_j = x2 / bar_w;

            mx = 'matrix(1,0,0,1,-'+x1+',0)';
            a.car_o.css({transform : mx});
            var modify2 = 0, modify = 0;
            for(var i = 0; i < (a.item_length*3); i++){
                var j = i - a.item_length;
                var slideProgress = j - bar_j;
                var negative = slideProgress>0?1:-1;
                // transform:scale(0.8) rotateY(-30deg);
                var rotate = -slideProgress * 30;
                // modify2 = slideProgress * w * (0.1 + (j - 2) * 0.05);

                modify = slideProgress * w * 0.67; //+ slideProgress * w;
                var translate = -modify + 'px';
                var zIndex = 999 - Math.abs(Math.round(10 * slideProgress));
                var scale = 1 - Math.abs(slideProgress) * 0.4;
                if(scale < 0.7){
                    scale = 0.7;
                }
                if(rotate > 30){
                    rotate = 30;
                }else if(rotate < -30){
                    rotate = -30;
                }
                $('.carousel .item').eq(i).css({transform:' translateX(' + translate + ')', zIndex:zIndex}).find('div').css({transform:'scale(' + scale + ') rotateY('+rotate+'deg)'});

                if(Math.abs(slideProgress) >= 4){
                    $('.carousel .item').eq(i).css({opacity: 0});
                }else{
                    $('.carousel .item').eq(i).css({opacity: 1});
                }
            }
        }
    };
    scroll.init();
</script>