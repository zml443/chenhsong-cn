<form class="address_form">
    <div class="_dbs_box">
        <div class="_dbs_item">
            <div class="ly-h4 mb_40px" color="text">顾客</div>

            <div class="mb_20px" style="width:calc(50% - 10px);">
                <div class="lh_1_8">会员</div>
                <label class="ly_select_checkbox flex-middle2" data-type="radio" lydbs-association-list-drop="" data-ma="member/index" fn="select_members">
					<input type="hidden" name="wb_member_id" value="">
					<i class="lyicon-arrow-down-bold"></i>
				</label>
            </div>

            <div class="flex-between flex-middle2 mb_40px">
                <div>配送地址</div>
                <div class="ly_btn pointer" hr-ef="?ma=member/address&wb_member_id=&l=selector-side&_popup_right_=1&_radio_=1" fn="shipping_address" bg="main">选择配送地址</div>
            </div>

            <div class="flex-wrap">
                <div class="flex-1 mr_20px mb_20px">
                    <div class="lh_1_8">名</div>
                    <input class="ly_input maxw" type="text" name="LastName" />
                </div>
                <div class="flex-1">
                    <div class="lh_1_8">姓</div>
                    <input class="ly_input maxw" type="text" name="FirstName" />
                </div>

                <div class="maxw"></div>
                <div class="flex-1 mr_20px mb_20px">
                    <div class="lh_1_8">国家/地区</div>
                    <label class="ly_input_suffix maxw inline-flex" ly-drop-select="" data-search="1">
                        <input type="text" placeholder="选择国家" />
                        <input type="hidden" name="Country" value="" check-val="国家不能为空"/>
                        <input type="hidden" name="Province" value="" />
                        <input type="hidden" name="City" value="" />
                        <i class="arrow lyicon-arrow-down-bold"></i>
                        <script data-href="address_country"></script>
                    </label>
                </div>
                <div class="flex-1">
                    <div class="lh_1_8">详细地址</div>
                    <input class="ly_input maxw" type="text" name="Address" />
                </div>
                
                <div class="maxw"></div>
                <div class="flex-1 mr_20px mb_20px">
                    <div class="lh_1_8">邮政编码</div>
                    <input class="ly_input maxw" type="text" name="Postcode" />
                </div>

                <div class="flex-1" style="">
                    <div class="lh_1_8">电话</div>
                    <label class="ly_input maxw">
                        <b class="bg_pane" bg="pane">+93</b>
                        <input type="text" name="Phone">
                    </label>
                </div>

                <div class="maxw"></div>
                <label class="flex-btn pointer">
                    <i class="ly_checkbox lyicon-select-bold mr_10px"></i>
                    <input type="checkbox" class="hide" value="1" fn=""/>
                    <input type="hidden" name="Save" value="" />
                    <span>保存到地址薄</span>
                </label>
            </div>
        </div>
    </div>
</form>