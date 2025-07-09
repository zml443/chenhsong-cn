<?php

// 防止恶意进入
function_exists('c')||exit;

$Id = (int)$_GET['Id'];
$this->row = db::get_one('wb_orders',"Id='{$Id}'");
$this->row = str::code($this->row);


$orders_products = db::all("select * from wb_orders_products where wb_orders_id='{$this->row['Id']}'");


?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
	<script type='text/javascript' src='/manage/orders/index/_js.js' ></script>
	<script type='text/javascript' src='/manage/orders/index/add.js' ></script>
</head>

<body bg="default">
<form class='maxvh2 flex-column' lydbs-detail="" action='<?=$this->query_string['post'];?>'>
		<!-- 开始 -->
		<div class='p_30_0px ly-h3 flex-middle2' cw="<?=$_GET['_w_']?:'1300'?>">
			<i class="ly-h3 mr_5px lyicon-arrow-left-bold" hr-ef="back()"></i>
			<span hr-ef="back()">NO.#<?=$this->row['OrderNumber']?></span>
		</div>
		<!-- 结束 -->

		<!-- 开始 -->
		<div class="flex-between flex-wrap flex-1 mb_20px" cw="<?=$_GET['_w_']?:'1300'?>">
			<div class='content_left flex-column'>
                <div class="_dbs_box">
                    <div class="_dbs_item">
                        <div class="flex-between mb_20px">
                            <div class="ly-h4" color="text">产品</div>
                            <div class="ly_btn_radius pointer" bg="main" onclick="orders_index_add.addProduct.getData(this)">
                                添加产品
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
                            <input type="hidden" name="Id" value="<?=$this->row['Id']?>">
                            <tbody class="orders_products_tbody" data-id="<?=$this->row['Id']?>"></tbody>
                        </table>
                    </div>
                </div>
                <div class="_dbs_box">
                    <div class="_dbs_item">
                        <div class="ly-h4 mb_50px" color="text">其他费用</div>
                        <div class="mb_10px">折扣</div>
                        <div class="tab_links mb_20px">
                            <label class="ly_btn_radio pointer mr_10px">
                                <i class="ly_radio mr_10px"><input type="radio" <?=$this->row['FreeType']=='Money'?'checked':''?> name="FreeType" value="Money" fn="WP.apply_type_sale_cb"></i>
                                <span><?=lang('{/panel.free.free_money/}')?></span>
                            </label>
                            <label class="ly_btn_radio pointer mr_10px">
                                <i class="ly_radio mr_10px"><input type="radio" <?=$this->row['FreeType']=='Discount'?'checked':''?> name="FreeType" value="Discount" fn="WP.apply_type_sale_cb"></i>
                                <span><?=lang('{/panel.free.free_discount/}')?></span>
                            </label>
                        </div>
                        <div class="tab_content mb_40px">
                            <label class="ly_input <?=$this->row['FreeType']=='Money'?'':'hide2'?>" data-con="Money">
                                <div class="bg_pane" bg="default"><?=price::rate(0,1)?></div>
                                <input type="text" name="FreeMoney" value="<?=$this->row['FreeMoney']?>">
                            </label>
                            <div class="<?=$this->row['FreeType']=='Discount'?'':'hide2'?>" data-con="Discount">
                                <label class="ly_input">
                                    <input type="number" name="FreeDiscount" value="<?=$this->row['FreeDiscount']?>" int="">
                                    <div class="bg_pane" bg="default">% off</div>
                                </label>
                                <div class="mt_10px"><?=lang('{/panel.free.free_discount_tip/}')?></div>
                            </div>
                        </div>
                        <div class="mb_10px">税费</div>
                        <label class="ly_input">
                            <input type="number" name="TaxationPrice" value="0" int="">
                            <div class="bg_pane" bg="default">%</div>
                        </label>
                    </div>
                </div>
			</div>
			<div class='content_right' ly-sticky="center">
				<div class="_dbs_box">
					<div class="_dbs_item">
                        <div class="ly-h4 mb_20px" color="text">小计</div>
                        <div class="flex-between mb_10px" color="text2"> <div>产品总价</div> <div><?=$this->row['TotalPrice']?></div></div>
                        <div class="flex-between mb_15px fz12" color="text3"> <div><?=$this->row['Qty']?>个商品</div></div>
                        <div class="flex-between mb_15px" color="text2"> <div>运费</div> <div><?=$this->row['ShippingPrice']?></div></div>
                        <div class="flex-between mb_15px" color="text2"> <div>税费</div> <div>0.00</div></div>
                        <div class="flex-between mb_15px" color="text2"> <div>折扣</div> <div><?=$this->row['Price']?></div></div>
                        <div class="flex-between mb_15px" color="text2"> <div>手续费</div> <div>0.00</div></div>
                        <div class="flex-between pt_15px fz20 b_top"> <div>订单总价</div> <div><?=$this->row['Price']?></div></div>
					</div>
				</div>
			</div>
		</div>
		<!-- 结束 -->

        <div class='_dbs_submit' ly-sticky="bottom">
			<div class="flex-max2 p_10px" bg="white">
				<label class='ly_btn mr_30px pointer' hr-ef='back()'><?=language('{/global.back/}')?></label>
				<label class='ly_btn pointer' bg="main"><input type='submit' hide><?=language('{/global.submit/}')?></label>
			</div>
		</div>
	</form>
</body>
</html>