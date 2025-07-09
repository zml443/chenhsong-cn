<form>
    <!-- <div class="_dbs_box">
        <div class="_dbs_item">
            <div class="ly-h4" color="text">结账货币</div>
        </div>
    </div> -->
    <div class="_dbs_box">
        <div class="_dbs_item">
           <div class="flex-between mb_20px">
                <div class="ly-h4" color="text">产品</div>
                <div class="ly_btn_radius pointer" bg="main" onclick="orders_index_add.add.getData(this)">
                    添加产品
                    <input type="hidden" name="OrdersProducts">
                </div>
           </div>
           <table class="ly_table_list maxw">
                <thead>
                    <tr>
                        <td class="w_1" colspan="2">产品</td>
                        <!-- <td></td> -->
                        <td>价格</td>
                        <td>库存</td>
                        <td>总计</td>
                        <td class="w_1">操作</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</form>