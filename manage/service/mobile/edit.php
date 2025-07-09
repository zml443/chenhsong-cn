<?php
// 防止胡乱进入
function_exists('c')||exit;

// d(c('manage.permit'));

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
    <?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}
</style>

<body class="maxvh flex-max">

    <div class="absolute max at-close"></div>

    <form class='zml_alert_box flex-column _do_not_go_to_back' lydbs-detail="" is-not-list="" action='<?=$this->query_string['post'];?>'>

        <script class="zml_alert_box_init_data" type="text"><?=str::json($current)?></script>
        <!-- 顶部标题 -->
        <div class="zml_alert_title">
            <div class=""><?php $lyCssConf=[]; include c('dbs.inc').'title-one.php'; ?></div>
            <div class="at-close lyicon-guanbi pointer"></div>
        </div>
        <!-- 中间区域 -->
        <section class="relative flex-1 scrollbar p_30px" style="height:0px">
            <table class="maxw ly_table_edit2">
                <tr>
                    <td>首页</td>
                    <td>
                        <label class='ly_switchery'>
                            <input type="checkbox" value='1' <?=g('wb_service_mobile.list.home.open')?'checked':''?> fn="" />
                            <input type="hidden" name="list[home][open]" value="<?=g('wb_service_mobile.list.home.open')?>" />
                        </label>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>电话</td>
                    <td>
                        <label class='ly_switchery'>
                            <input type="checkbox" value='1' <?=g('wb_service_mobile.list.tel.open')?'checked':''?> fn="" />
                            <input type="hidden" name="list[tel][open]" value="<?=g('wb_service_mobile.list.tel.open')?>" />
                        </label>
                    </td>
                    <td><input type="text" class="ly_input width300" name="list[tel][phone]" value="<?=g('wb_service_mobile.list.tel.phone')?>" /></td>
                </tr>
            </table>
        </section>

        <!-- 底部按钮 -->
        <div class="zml_alert_btn2 flex-middle2 flex-between">
            <div></div>
            <label class="wcb_alert_btn_submit at-confirm flex-btn" bg="main" color="white"><input class="hide" type='submit'><?=language('{/global.save/}')?></label>
        </div>

    </form>
</body>
</html>


<script>

</script>