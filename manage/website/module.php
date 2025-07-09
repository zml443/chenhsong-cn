<?php
// 防止胡乱进入
function_exists('c') || exit;

 //扫描模板
new saas_scan(array(
    'web_number' => c('HostName'),
));

?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include '__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}
.zmlmodule_body{height: 100vh;width: 100vw;padding: 25px 50px;background:rgba(0,0,0,.1);}
.zmlmodule_body2{height: 100vh;}
.zmlmodule_box{width: calc(100vw - 100px);height: calc(100vh - 50px);border-radius: 10px;background: rgba(255,255,255,.9);}
.zmlmodule_box2{height: 100vh;}
.zmlmodule_title{position: sticky;top: 0;left: 0;right: 0;padding: 50px 0;font-size: 36px;background: rgba(255,255,255,.9);z-index: 5;}
.zmlmodule_con{height: 100%;padding: 0 0 30px}
.zmlmodule_close{position: absolute;z-index: 9;font-size: 40px;right: 30px;top: 50px;cursor: pointer;}
</style>

<body>
<div class="<?=$_GET['_w_']?'zmlmodule_body':'zmlmodule_body2'?>">
	
    <div class="fixed max at-close"></div>

    <div class="zmlmodule_div <?=$_GET['_w_']?'zmlmodule_box':'zmlmodule_box2'?> relative over">

        <div class="zmlmodule_close at-close lyicon-guanbi <?=$_GET['_w_']?'':'hide2'?>"></div>
        
        <div class="zmlmodule_con relative scrollbar">
            <div class="zmlmodule_title text-center"><?=language('{/panel.change_like_mdl/}')?></div>
            <form class="flex-wrap flex-max2" cw="<?=$_GET['_w_']?'1400':''?>">
                <?php 
                    $where = "IsUsed=1";
                    if (in_array(c('HostTag'), array('shop', 'shopen'))) {
                        $where .= " and Tag='shop'";
                    } else {
                        $where .= " and Tag='web'";
                    }
                    $res = lydb::query("select * from ss_web where $where");
                    while ($v = lydb::result($res)) {
                ?>
                    <div class="module_preview">
                        <div class="name mb_10px"><?=$v['Number']?></div>
                        <div class="relative">
                            <div class="ifr"><img class="maxw" data-src="<?=$v['Picture']?>" /></div>
                            <div class="btn flex-max2">
                                <a class="ly_btn_radius pointer2" bg="success" href="http://<?=$v['Number']?>.web.lianyayun.com" target="_blank"><?=language('{/panel.view_mdl/}')?></a>
                                <div class="ly_btn_radius qiehuanmoban pointer2 ml_15px" bg="main" data-number="<?=$v['Number']?>"><?=language('{/panel.select_mdl/}')?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="module_preview_pre"></div>
                <div class="module_preview_pre"></div>
                <div class="module_preview_pre"></div>
            </form>
        </div>

    </div>

    <script>
        $(document).on('click', '.qiehuanmoban', function(){
            var num = $(this).attr('data-number');
            $.alert('loading...');
            $.async('POST', '?ma=website/data/web_change', {Number:num}, result=>{
                <?php if ($_GET['_w_']) { ?>
                    window.parent.location.reload();
                <?php } else { ?>
                    location.href = '/manage/?u=web,page_type&m=site&a=page_data&L=type';
                <?php } ?>
            }, 'json');
        });
    </script>

</div>
</body>
</html>