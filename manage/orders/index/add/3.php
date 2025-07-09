<div class="_dbs_box">
    <div class="_dbs_item">
        <div class="ly-h4 mb_20px" color="text">价格</div>
        <table class="apply_table ly_table_list maxw">
            <thead>
                <tr>
                    <td>费用</td>
                    <td class="w_1"><div class="text-right">价格</div></td>
                    <td class="w_1"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>产品总价</td>
                    <td class="w_1"><div class="text-right" data-up="Price">0.00</div></td>
                    <td class="w_1"></td>
                </tr>
                <tr>
                    <td>运费</td>
                    <td class="w_1"><div class="text-right" data-up="Freight">0.00</div></td>
                    <td class="w_1">
                        <div class="flex">
                            <label class="ly_input width100 mr_10px">
                                <b class="bg_pane">运费</b>
                                <input type="text" name="name">
                            </label>
                            <label class="ly_input_suffix inline-flex" data-type="radio" ly-drop-select>
                                <input type="text" placeholder="运送方式">
                                <input type="hidden" name="name">
                                <i class="lyicon-arrow-down-bold"></i>
                                <script type="text"> [ { label: "顺丰", value: "1" }, { label: "圆通", value: "2", } ] </script>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>折扣</td>
                    <td class="w_1"><div class="text-right" data-up="Sale">0.00</div></td>
                    <td class="w_1">
                        <div class="tab_links">
                            <label class="ly_btn_radio pointer mr_10px">
                                <i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="Money" <?=$row[$name.'Money']?'checked':($row[$name.'Discount']?'':'checked')?> fn="apply_type_sale_cb"></i>
                                <span><?=language('{/panel.free.free_money/}')?></span>
                            </label>
                            <label class="ly_btn_radio pointer mr_10px">
                                <i class="ly_radio mr_10px"><input type="radio" name="<?=$name?>Type" value="Discount" <?=$row[$name.'Discount']?'checked':''?> fn="apply_type_sale_cb"></i>
                                <span><?=language('{/panel.free.free_discount/}')?></span>
                            </label>
                        </div>
                        <div class="tab_content">
                            <label class="ly_input width300" data-con="Money">
                                <div class="bg_pane"><?=price::rate(0,1)?></div>
                                <input type="text" name="<?=$name?>Money" value="<?=ceil($row[$name.'Money'])?$row[$name.'Money']:''?>">
                            </label>
                            <div class="flex-middle2" data-con="Discount">
                                <label class="ly_input">
                                    <input type="number" name="<?=$name?>Discount" value="<?=$row[$name.'Discount']?:''?>" int="">
                                    <div class="bg_pane"><b>%</b></div>
                                </label>
                                <div class="ml_10px"><?=language('{/panel.free.free_discount_tip/}')?></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>税费</td>
                    <td class="w_1"><div class="text-right" data-up="Taxation">0.00</div></td>
                    <td class="w_1"></td>
                </tr>
                <tr>
                    <td>手续费</td>
                    <td class="w_1"><div class="text-right" data-up="Commission">0.00</div></td>
                    <td class="w_1"></td>
                </tr>
                <tr>
                    <td class="fz20">订单总价</td>
                    <td class="w_1 fz20"><div class="text-right" data-up="OrderPrice">100000.00</div></td>
                    <td class="w_1"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="_dbs_box">
    <div class="_dbs_item">
        <div class="ly-h4 mb_20px" color="text">付款</div>

        <div class="mb_20px">付款状态</div>
        <div class="mb_40px">
            <label class="ly_btn_radio mr_20px">
                <i class="mr_5px"><input type="radio" name="radio" /></i>
                <span>未付款</span>
            </label>
            <label class="ly_btn_radio">
                <i class="mr_5px"><input type="radio" name="radio" /></i>
                <span>已付款</span>
            </label>
        </div>
        <div class="mb_20px">付款方式</div>
        <label class="ly_input_suffix inline-flex width300" ly-drop-select>
            <input type="text" placeholder="请选择">
            <input type="hidden" name="name">
            <i class="lyicon-arrow-down-bold"></i>
            <script type="text"> [ { label: "支付宝", value: "1" }, { label: "微信", value: "2", } ] </script>
        </label>
    </div>
</div>