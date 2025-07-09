<?php
    switch ($lyCssConf['type']) {
        case 'wb_products':
            $search = wb_products_search::all();
            break;
    };

    // 处理get参数，方便初始化
	$search_row = ly200_search::query_string($_GET);
?>
<link rel="stylesheet" href="/themes/__/filter/drop/1.css" />
<script src="/themes/__/filter/drop/1.js"></script>

<form class="lyfilter_drop lyfilter_form">
    <div class="lyfilter_drop_content">
        <div class="lyfilter_drop_header flex-between flex-middle2">
            <span><?=lang('front_end.filter.text')?></span>
        </div>
        <div class="lyfilter_drop_form">
            <?php foreach((array)$search as $k => $v){
                switch ($v['Type']) {
                    case 'price':
                        echo "
                            <div class=''>
                                <div class='lyfilter_drop_title'>{$v['Name']}</div>
                                <div class='lyfilter_drop_li price relative flex-between flex-middle2'>
                                    <label class='label'>
                                        <input type='text' name='price[min]' placeholder='最低价' value='".($search_row['price']?htmlspecialchars($search_row['price']['min']):'0')."' autocomplete='off' />
                                    </label>
                                    <div>-</div>
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
                                $str .= "<label class='lyfilter_drop_label'>
                                            <i class='label_i flex-btn lyicon-select'></i>
                                            <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[$k][]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_drop' />
                                            {$v1['Name']}
                                        </label>";
                            };
                            $html = "<div class=''>
                                        <div class='lyfilter_drop_title'>{$v['Name']}</div>
                                        <div class='lyfilter_drop_li relative'>
                                            <div class='lyfilter_drop_name flex-between flex-middle2'>
                                                <div class='span maxw flex-between'>请选择...</div>
                                                <i class='lyicon-arrow-down-filling'></i>
                                            </div>
                                            <div class='lyfilter_drop_box'>
                                                {$str}
                                            </div>
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
                                $str .= "<label class='lyfilter_drop_label'>
                                            <i class='label_i flex-btn lyicon-select'></i>
                                            <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_drop' />
                                            {$v1['Name']}
                                        </label>";
                            };
                            $html = "<div class=''>
                                        <div class='lyfilter_drop_title'>{$v['Name']}</div>
                                        <div class='lyfilter_drop_li relative'>
                                            <div class='lyfilter_drop_name flex-between flex-middle2'>
                                                <div class='span maxw flex-between'>请选择...</div>
                                                <i class='lyicon-arrow-down-filling'></i>
                                            </div>
                                            <div class='lyfilter_drop_box'>
                                                {$str}
                                            </div>
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
                                $str .= "<label class='lyfilter_drop_label'>
                                            <i class='label_i flex-btn lyicon-select'></i>
                                            <input class='hide' ".($flag?'checked':'')." type='checkbox' name='{$v['Type']}[]' value='{$v1['Id']}' data-label='{$v1['Name']}' fn='lyfilter_drop' />
                                            {$v1['Name']}
                                        </label>";
                            };
                            $html = "<div class=''>
                                        <div class='lyfilter_drop_title'>{$v['Name']}</div>
                                        <div class='lyfilter_drop_li relative'>
                                            <div class='lyfilter_drop_name flex-between flex-middle2'>
                                                <div class='span maxw flex-between'>请选择...</div>
                                                <i class='lyicon-arrow-down-filling'></i>
                                            </div>
                                            <div class='lyfilter_drop_box'>
                                                {$str}
                                            </div>
                                        </div>
                                    </div>";
                        }
                        echo $html;
                        break;
                }
            }?>
        </div>
        <label class="lyfilter_drop_more flex-max"><input class="hide" type="submit"><?=lang('front_end.filter.submit')?></label>
    </div>
</form>