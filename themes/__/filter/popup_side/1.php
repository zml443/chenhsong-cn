<?php
    switch ($lyCssConf['type']) {
        case 'wb_products':
            $search = wb_products_search::all();
            break;
    }

    // 处理get参数，方便初始化
	$search_row = ly200_search::query_string($_GET);
?>
<link rel="stylesheet" href="/themes/__/filter/popup_side/1.css" />
<script src="/themes/__/filter/popup_side/1.js"></script>

<section class="lyfilter_popup_side popup el-side hidden">
    <form class="lyfilter_popup_side_content lyfilter_form">
        <div class="lyfilter_popup_side_header flex-between flex-middle2">
            <span><?=lang('front_end.filter.text')?></span>
            <div class="close pointer flex-middle2" onclick="$('.lyfilter_popup_side').popup_hide();"><i class="lyicon-guanbi"></i><?=lang('front_end.filter.close')?></div>
        </div>
        <div class="lyfilter_popup_side_form">
            <?php foreach((array)$search as $k => $v){
                switch ($v['Type']) {
                    case 'price':
                        echo 
                            "<div class='lyfilter_popup_side_li'>
                                <div class='lyfilter_popup_side_name flex-between flex-middle2'>
                                    <span>{$v['Name']}</span>
                                </div>
                                <div class='lyfilter_popup_side_price flex-middle2'>
                                    <label class='label'>
                                        <input type='text' name='price[min]' placeholder='最低价' value='".($search_row['price']?htmlspecialchars($search_row['price']['min']):'0')."' autocomplete='off'  />
                                    </label>
                                    -
                                    <label class='label'>
                                        <input type='text' name='price[max]' placeholder='最高价' value='".($search_row['price']?htmlspecialchars($search_row['price']['max']):'0')."' autocomplete='off' />
                                    </label>
                                </div>
                            </div>";
                        break;
                    case 'param_id':
                        if($v['children']){
                            $str = '';
                            foreach((array)$v['children'] as $k1 => $v1){
                                if($search_row['param_id']) $flag = in_array($v1['Id'],$search_row['param_id']);
                                $str .= "<label class='lyfilter_popup_side_label'>
                                            <i class='label_i lyicon-select'></i>
                                            <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[$k][]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_popup_side' />
                                            {$v1['Name']}
                                        </label>";
                            };
                            $html = "<div class='lyfilter_popup_side_li'>
                                        <div class='lyfilter_popup_side_name flex-between flex-middle2'>
                                            <span>{$v['Name']}</span>
                                            <i class='lyicon-arrow-down'></i>
                                        </div>
                                        <div class='lyfilter_popup_side_box hide'>
                                            {$str}
                                        </div>
                                    </div>";
                        }
                        echo $html;
                        break;
                    case 'cid':
                        if($v['children']){
                            $str = '';
                            foreach((array)$v['children'] as $k1 => $v1){
                                if($search_row['cid']) $flag = in_array($v1['Id'],$search_row['cid']);
                                $str .= "<label class='lyfilter_popup_side_label'>
                                            <i class='label_i lyicon-select'></i>
                                            <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_popup_side' />
                                            {$v1['Name']}
                                        </label>";
                            };
                            $html = "<div class='lyfilter_popup_side_li'>
                                        <div class='lyfilter_popup_side_name flex-between flex-middle2'>
                                            <span>{$v['Name']}</span>
                                            <i class='lyicon-arrow-down'></i>
                                        </div>
                                        <div class='lyfilter_popup_side_box hide'>
                                            {$str}
                                        </div>
                                    </div>";
                        }
                        echo $html;
                        break;
                    case 'tag':
                        if($v['children']){
                            $str = '';
                            foreach((array)$v['children'] as $k1 => $v1){
                                if($search_row['tag']) $flag = in_array($v1['Id'],$search_row['tag']);
                                $str .= "<label class='lyfilter_popup_side_label'>
                                            <i class='label_i lyicon-select'></i>
                                            <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_popup_side' />
                                            {$v1['Name']}
                                        </label>";
                            };
                            $html = "<div class='lyfilter_popup_side_li'>
                                        <div class='lyfilter_popup_side_name flex-between flex-middle2'>
                                            <span>{$v['Name']}</span>
                                            <i class='lyicon-arrow-down'></i>
                                        </div>
                                        <div class='lyfilter_popup_side_box hide'>
                                            {$str}
                                        </div>
                                    </div>";
                        }
                        echo $html;
                        break;
                }
            }?>
        </div>
        <label class="lyfilter_popup_side_more flex-max"><input class="hide" type="submit"><?=lang('front_end.filter.submit')?></label>
    </form>
</section>