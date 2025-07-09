<?php
    switch ($lyCssConf['type']) {
        case 'wb_products':
            $search = wb_products_search::all();
            break;
    }

    // 处理get参数，方便初始化
	$search_row = ly200_search::query_string($_GET);
?>
<link rel="stylesheet" href="/themes/__/filter/table/1.css" />
<script src="/themes/__/filter/table/1.js"></script>

<form class="lyfilter_table lyfilter_form">
    <div class="lyfilter_table_content cw1600">
        <div class="lyfilter_table_header flex-between flex-middle2">
            产品筛选
        </div>
        <div class="lyfilter_table_form relative" ly-scroll-custom=''>
            <div class="res maxw maxh scrollbar">
                <table class="">
                    <?php 
                        $th = '';
                        $tb = '';
                        $index = 0;
                        foreach((array)$search as $k => $v){
                            $index++;
                            // if($index >4) continue;
                            $th .= "<td class='lyfilter_table_th_td'>{$v['Name']}</td>";
                            $html = '';
                            switch ($v['Type']) {
                                case 'price':
                                    $html = 
                                        "<div class='lyfilter_table_price flex-middle2'>
                                            <label class='label'>
                                                <input type='text' name='price[min]' placeholder='最低价' value='".($search_row['price']?htmlspecialchars($search_row['price']['min']):'0')."' autocomplete='off' />
                                            </label>
                                            -
                                            <label class='label'>
                                                <input type='text' name='price[max]' placeholder='最高价' value='".($search_row['price']?htmlspecialchars($search_row['price']['max']):'0')."' autocomplete='off' />
                                            </label>
                                        </div>";
                                    break;
                                case 'param_id':
                                    if($v['children']){
                                        $str = '';
                                        foreach((array)$v['children'] as $k1 => $v1){
                                            if($search_row['param_id']) $flag = in_array($v1['Id'],$search_row['param_id']);
                                            $str .= "<label class='lyfilter_table_label'>
                                                        <i class='label_i flex-btn lyicon-select'></i>
                                                        <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[$k][]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_table' />
                                                        {$v1['Name']}
                                                    </label>";
                                        };
                                        $html = "<div class='lyfilter_table_box'>
                                                    {$str}
                                                </div>";
                                    }
                                    break;
                                case 'cid':
                                    if($v['children']){
                                        $str = '';
                                        foreach((array)$v['children'] as $k1 => $v1){
                                            if($search_row['cid']) $flag = in_array($v1['Id'],$search_row['cid']);
                                            $str .= "<label class='lyfilter_table_label'>
                                                        <i class='label_i flex-btn lyicon-select'></i>
                                                        <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_table' />
                                                        {$v1['Name']}
                                                    </label>";
                                        };
                                        $html = "<div class='lyfilter_table_box'>
                                                    {$str}
                                                </div>";
                                    }
                                    break;
                                case 'tag':
                                    if($v['children']){
                                        $str = '';
                                        foreach((array)$v['children'] as $k1 => $v1){
                                            if($search_row['tag']) $flag = in_array($v1['Id'],$search_row['tag']);
                                            $str .= "<label class='lyfilter_table_label'>
                                                        <i class='label_i flex-btn lyicon-select'></i>
                                                        <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_table' />
                                                        {$v1['Name']}
                                                    </label>";
                                        };
                                        $html = "<div class='lyfilter_table_box'>
                                                    {$str}
                                                </div>";
                                    }
                                    break;
                            }
                            $tb .= "<td class='lyfilter_table_tb_td'>{$html}</td>";
                        };
                        $thead = "<thead class='lyfilter_table_th'><tr class='lyfilter_table_th_tr'>{$th}</tr></thead>";
                        $tbody = "<tbody class='lyfilter_table_tb'><tr class='lyfilter_table_tb_tr'>{$tb}</tr></tbody>";
                        echo $thead.$tbody;
                    ?>
                </table>
            </div>
        </div>
        <label class="lyfilter_table_more flex-max"><input class="hide" type="submit"><?=lang('front_end.filter.submit')?></label>
    </div>
</form>