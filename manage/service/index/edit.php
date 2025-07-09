<?php
// 防止胡乱进入
function_exists('c')||exit;

$this->where .= " and Language='".c('lang')."'";

$this->row = db::all("select * from ".$this->table." where ".$this->where." order by ".$this->orderby);

$side_float_svg_type = '01';

?><!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
    <script type='text/javascript' src='/manage/service/index/_js.js' ></script>
</head>

<style>
@media (max-width:1500px){
    .OnTheRight{padding-right: 120px}
    .OnTheLeft{padding-left: 120px}
}
</style>

<body class="flex-column maxvh2 <?=in_array(g('wb_service.position'), array('1','4','7'))?'OnTheLeft':'OnTheRight'?>" bg="default">

	<?php $lyCssConf=['class'=>'pb_30px pt_30px', 'cw'=>'1400']; include c('dbs.inc').'/app-title.php';?>

	<div class="flex-between flex-1 mb_30px" cw="1400">
        <!-- 内容 -->
        <div class="zhj_zxkf_content">
            <div class="flex mb_30px">
                <div class="ly_h4 flex-1">组件管理</div>
                <?php $lyCssConf=[]; include c('dbs.inc').'lang2.php'; ?>
            </div>
            <script id="xxxJson" type="text"><?=str::json($this->row);?></script>
            <ul id="xxxList" ly-drag-sort="" fn="dbs_category_myorder_list" data-href="<?=$this->query_string['myorder']?>"></ul>
            <!-- 小组件添加按钮 -->
            <a id="xxxAdd" class="zhj_zxkf_more_btn flex-max2" onclick="serviceBox.edit()" data-lang="<?=c('lang')?>">
                <div class="flex-middle2">
                    <div class="zhj_zxkf_more_icon lyicon-add-bold"></div>
                    <div class="zhj_zxkf_more_text">增加</div>
                </div>
            </a>
            <!--  -->
        </div>
        <!-- 侧边栏 -->
        <div class="zhj_zxkf_side flex-column">
            <!-- 风格选择按钮 -->
            <a id="xxxStyle" class="zhj_zxkf_style_btn flex-max2" onclick="serviceBox.changeType()" data-type="<?=g('wb_service.type')?>">风格选择</a>
            <!-- 风格展示 -->
            <div class="zhj_zxkf_position mt_30px">
                <div class="tit text-center">显示位置</div>
                <ul class="ly_lattice">
                    <li class="ly_lattice_ul">
                        <?php
                        $PRow = [
                            [1,0,1],
                            [1,0,1],
                            [1,0,1]
                        ];
                        $i = 0;
                        foreach ($PRow as $v) {
                            foreach ($v as $v1) {
                                $i++;
                                echo '
                                    <label class="ly_lattice_li relative">
                                        <input class="hide" type="radio" name="position" value="'.$i.'" '.($i==g('wb_service.position')?'checked':'').' '.($v1?'':'disabled').' onclick="serviceBox.setPosition(this)">
                                        <div class="absolute max flex-max '.($v1?'':'hide2').'">
                                            <div class="ly_lattice_radio flex-max"><i class="lyicon-select"></i></div>
                                        </div>
                                    </label>
                                ';
                            }
                            echo "</li><li class='ly_lattice_ul'>";
                        }
                        ?>
                    </li>
                </ul>
                <!-- <div class="position" data-index="1"></div> -->
            </div>
        </div>
    </div>

    <div id="preview"></div>


</body>
</html>