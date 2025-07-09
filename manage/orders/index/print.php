<?php

$Id = (int)$_GET['Id'];
$this->row = db::get_one('wb_orders',"Id='{$Id}'");
$this->row = str::code($this->row);

$orders_products = db::all("select * from wb_orders_products where wb_orders_id='{$this->row['Id']}'");
$orders_shipping_address = db::result("select * from wb_orders_address where wb_orders_id='{$this->row['Id']}' and Type='shipping'");
?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>
<style>
    .print_btn{ position: fixed;right:8vw;bottom:4vw }
    @media print { .print_btn{display:none;} }
</style>
<body>
    <div class="print_btn ly_btn_radius pointer" bg="main" onclick="window.print()">打印</div>
    <div class="cw750 maxvh2 p_30_0px">
        <table class="ly_table_line maxw mb_20px" style="table-layout: fixed;">
            <thead>
                <tr>
                    <td colspan="3"><img src="<?=g('wb_site_config.logo')?>"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3"><b>订单号</b>：<?=$this->row['OrderNumber']?></td>
                </tr>
                <tr>
                    <td><b>会员：</b><?=$this->row['wb_member_id']?></td>
                    <td><b>电话：</b><?=$this->row['Tel']?></td>
                    <td><b>支付日期：</b><?=date('y/m/d',$this->row['PayTime'])?></td>
                </tr>
            </tbody>
        </table>

        <table class="ly_table_line maxw mb_20px" style="table-layout: fixed;">
            <thead>
                <tr>
                    <td><b>发送地址</b></td>
                    <td><b>账单地址</b></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?=$orders_shipping_address['Country']?$orders_shipping_address['Country'].'<br>':''?>
                        <?=$orders_shipping_address['Province']?$orders_shipping_address['Province'].'<br>':''?>
                        <?=$orders_shipping_address['City']?$orders_shipping_address['City'].'<br>':''?>
                        <?=$orders_shipping_address['Town']?$orders_shipping_address['Town'].'<br>':''?>
                        <?=$orders_shipping_address['Address']?$orders_shipping_address['Address'].'<br>':''?>
                        (邮政编码<b><?=$orders_shipping_address['Postcode']?></b>)<br>
                    </td>
                    <td>
                        <?=$orders_shipping_address['Country']?$orders_shipping_address['Country'].'<br>':''?>
                        <?=$orders_shipping_address['Province']?$orders_shipping_address['Province'].'<br>':''?>
                        <?=$orders_shipping_address['City']?$orders_shipping_address['City'].'<br>':''?>
                        <?=$orders_shipping_address['Town']?$orders_shipping_address['Town'].'<br>':''?>
                        (邮政编码<b><?=$orders_shipping_address['Postcode']?></b>)<br>
                    </td>
                </tr>
            </tbody>
        </table>


        <table class="ly_table_line maxw mb_20px" style="table-layout: fixed;">
            <thead>
                <tr>
                    <td><b>运输方式</b><br><?=$this->row['ShippingType']?></td>
                    <td><b>发货日期</b><br><?=date('y/m/d h:i:s',$this->row['ShippingTime'])?></td>
                    <td><b>联络人</b><br><?=str::real_name($orders_shipping_address['FirstName'],$orders_shipping_address['LastName'])?></td>
                </tr>
            </thead>
        </table>

        <table class="ly_table_line maxw mb_20px" >
            <thead>
                <tr>
                    <td class="w_1"><b>项目编号</b></td>
                    <td class=""><b>产品</b></td>
                    <td class="w_1"><b>价格</b></td>
                    <td class="w_1"><b>数量</b></td>
                    <td class="w_1"><b>总计</b></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders_products as $k => $v) {?>
                    <tr>
                        <td class="w_1"><?=$v['SKU']?></td>
                        <td><?=$v['Name']?></td>
                        <td class="w_1"><?=price::rate($v['Price'])?></td>
                        <td class="w_1"><?=$v['Qty']?></td>
                        <td class="w_1"><?=price::rate((float)$v['Price']*(int)$v['Qty'])?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <table class="ly_table_line maxw mb_20px" style="table-layout: fixed;">
            <thead>
                <tr>
                    <td><b>项目费用：</b><span style="color:red;"><?=price::rate($this->row['TotalPrice'])?></span></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>运费：</b><span style="color:red;"><?=price::rate($this->row['ShippingPrice'])?></span></td>
                </tr>
                <tr>
                    <td><b>额外费用：</b><span style="color:red;">0.00</span></td>
                </tr>
                <tr>
                    <td><b>总计：</b><span style="color:red;"><?=price::rate($this->row['Price'])?></span></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
window.print();
</script>