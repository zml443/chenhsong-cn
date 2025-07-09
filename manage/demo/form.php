<?php
isset($c) || exit;

?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include '__/inc/style_script.php'; ?>
</head>
<body bg="default">

	<form class="mt_20px mb_20px ml_20px mr_20px pt_20px pb_20px pl_20px pr_20px" bg="white">
		<table class="ly_table_edit maxw">
			<tbody>
				<tr>
					<td colspan="2">
						<div class="ly_hr"></div>
					</td>
				</tr>
				<tr>
					<td>标题</td>
					<td>
						<div class="ly-h2">ly-h2 标题</div>
						<div class="ly-h3">ly-h3 标题</div>
						<div class="ly-h4">ly-h4 标题</div>
						<div class="ly-h5">ly-h5 标题</div>
					</td>
				</tr>
				<tr>
					<td>提示</td>
					<td>
						<div class="p_10px mb_15px ly_main_tip">ly_main_tip</div>
						<div class="p_10px mb_15px ly_warning_tip">ly_warning_tip</div>
					</td>
				</tr>
				<tr>
					<td>标签</td>
					<td>
						<div class="mb_15px">
							<span class="ly_tag" size="mini">ly_tag</span>
							<span class="ly_main_tag" size="mini">ly_main_tag</span>
							<span class="ly_warning_tag" size="mini">ly_warning_tag</span>
						</div>
						<div class="mb_15px">
							<span class="ly_tag" size="small">ly_tag</span>
							<span class="ly_main_tag" size="small">ly_main_tag</span>
							<span class="ly_warning_tag" size="small">ly_warning_tag</span>
						</div>
						<div class="mb_15px">
							<span class="ly_tag">ly_tag</span>
							<span class="ly_main_tag">ly_main_tag</span>
							<span class="ly_warning_tag">ly_warning_tag</span>
						</div>
					</td>
				</tr>
				<tr>
					<td>开关</td>
					<td>
						<div class="flex">
							<label class="ly_switchery">
								<input type="checkbox" />
								<input type="hidden" name="checkbox" />
							</label>
							<label class="ly_switchery ml_20px" size="small">
								<input type="checkbox" />
								<input type="hidden" name="checkbox" />
							</label>
							<label class="ly_switchery ml_20px" size="mini">
								<input type="checkbox" />
								<input type="hidden" name="checkbox" />
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>单选</td>
					<td>
						<div class="flex">
							<label class="flex-middle2 mr_20px">
								<i class="ly_radio mr_5px"><input type="radio" name="radio" /></i>
								<span>选项</span>
							</label>
							<label class="flex-middle2">
								<i class="ly_radio mr_5px"><input type="radio" name="radio" /></i>
								<span>选项2</span>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>单选</td>
					<td>
						<div class="flex">
							<label class="ly_btn_radio mr_20px">
								<i class="mr_5px"><input type="radio" name="radio" /></i>
								<span>选项</span>
							</label>
							<label class="ly_btn_radio">
								<i class="mr_5px"><input type="radio" name="radio" /></i>
								<span>选项2</span>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>多选</td>
					<td>
						<div class="flex">
							<label class="flex-middle2 mr_20px">
								<i class="ly_checkbox lyicon-select-bold mr_5px"><input type="checkbox" name="checkbox" /></i>
								<span>选项</span>
							</label>
							<label class="flex-middle2">
								<i class="ly_checkbox lyicon-select-bold mr_5px"><input type="checkbox" name="checkbox" /></i>
								<span>选项2</span>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>多选</td>
					<td>
						<div class="flex">
							<label class="flex-middle2 mr_20px">
								<i class="ly_checkbox lyicon-select-bold mr_5px" size="big"><input type="checkbox" name="checkbox" /></i>
								<span>选项</span>
							</label>
							<label class="flex-middle2">
								<i class="ly_checkbox lyicon-select-bold mr_5px" size="big"><input type="checkbox" name="checkbox" /></i>
								<span>选项2</span>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>多选</td>
					<td>
						<div class="flex">
							<label class="ly_btn_checkbox mr_20px">
								<i class="lyicon-select-bold mr_5px"><input type="checkbox" name="checkbox" /></i>
								<span>选项</span>
							</label>
							<label class="ly_btn_checkbox">
								<i class="lyicon-select-bold mr_5px"><input type="checkbox" name="checkbox" /></i>
								<span>选项2</span>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>按钮</td>
					<td>
						<div class="ly_btn not-event">
							<i class="lyicon-jiazai mr_5px"></i>
							<span>按钮样式</span>
						</div>
						<div class="ly_btn not-event">
							<i class="lyicon-loading mr_5px"></i>
							<span>按钮样式</span>
						</div>
						<div class="ly_btn pointer" border="main">按钮样式</div>
						<div class="ly_btn pointer" bg="main">按钮样式</div>
					</td>
				</tr>
				<tr>
					<td>按钮(圆角)</td>
					<td>
						<div class="ly_btn_radius pointer">按钮样式</div>
						<div class="ly_btn_radius pointer" bg="main">按钮样式</div>
						<div class="ly_btn_radius pointer" bg="light">按钮样式</div>
						<div class="ly_btn_radius pointer" bg="light2">按钮样式</div>
						<div class="ly_btn_radius pointer" border="main">按钮样式</div>
						<a class="ly_btn_round lyicon-ashbin"></a>
					</td>
				</tr>
				<tr>
					<td>按钮(圆型)</td>
					<td>
						<a class="ly_btn_round lyicon-file" ly-tip-bubble="{}" data-tip-contents="详情"></a>
						<a class="ly_btn_round lyicon-bianji" ly-tip-bubble="{}" data-tip-contents="编辑"></a>
						<a class="ly_btn_round lyicon-copy" bg="light" ly-tip-bubble="{}" data-tip-contents="复制"></a>
						<a class="ly_btn_round lyicon-copy" bg="main" ly-tip-bubble="{}" data-tip-contents="复制"></a>
						<a class="ly_btn_round lyicon-fabu" ly-tip-bubble="{}" data-tip-contents="发布"></a>
						<a class="ly_btn_round lyicon-ashbin" ly-tip-bubble="{}" data-tip-contents="回收"></a>
						<a class="ly_btn_round lyicon-close" ly-tip-bubble="{}" data-tip-contents="删除"></a>
						<a class="ly_btn_round lyicon-gengduo relative">
							<div class="ly_drop_inner">
								<dl>
									<dd class="ly_drop_item">修改</dd>
									<dd class="ly_drop_item">取消发货</dd>
								</dl>
							</div>
						</a>
					</td>
				</tr>
				<tr>
					<td>按钮（小）</td>
					<td>
						<div class="ly_btn_radius">按钮样式</div>
						<div class="ly_btn_radius" size="small">按钮样式</div>
						<div class="ly_btn_radius" size="mini">按钮样式</div>
					</td>
				</tr>
				<tr>
					<td>按钮组</td>
					<td>
						<div class="ly_btn_group">
							<a class="">按钮样式</a>
							<a class="cur">按钮样式</a>
							<a class="">按钮样式</a>
							<a class="">按钮样式按钮样式</a>
						</div>
					</td>
				</tr>
				<tr>
					<td>按钮组</td>
					<td>
						<div class="ly_btn_group_radius width450">
							<a class="">按钮</a>
							<a class="cur">按钮</a>
							<a class="">按钮样式</a>
							<a class="">按钮样式按钮样式</a>
						</div>
						<div class="ly_btn_group_radius" size="small">
							<label class="">点选<input type="checkbox" /></label>
							<label class="">点选<input type="checkbox" /></label>
							<label class="">点选<input type="checkbox" /></label>
						</div>
						<div class="ly_btn_group_radius" size="mini">
							<a class="">按钮样式</a>
							<a class="">按钮样式按钮样式</a>
						</div>
					</td>
				</tr>
				<tr>
					<td>按钮组</td>
					<td>
						<div class="ly_btn_group_radius">
							<a class="">按钮</a>
							<a class="cur">按钮</a>
							<a class="">按钮样式</a>
							<a class="">按钮样式按钮样式</a>
						</div>
					</td>
				</tr>
				<tr>
					<td>单行输入框</td>
					<td>
						<input class="ly_input" type="text" name="name" autocomplete="off" />
						<div class="ly_btn">按钮样式</div>
						<div class="ly_btn_radius" size="small" border="main">按钮样式</div>
						<div class="ly_btn_radius" size="mini">按钮样式</div>
						<a class="ly_btn_round lyicon-ashbin"></a>
					</td>
				</tr>
				<tr>
					<td>带符号</td>
					<td>
						<label class="ly_input width300">
							<b class="bg_pane">搜索</b>
							<input type="text" name="name">
							<i class="lyicon-search bg_pane"></i>
						</label>
					</td>
				</tr>
				<tr>
					<td>数字累加</td>
					<td>
						<label class="ly_input inline-flex" calc-number>
							<b class="lyicon-minus" minus></b>
							<input class="text-center" type="number" name="name" placeholder="输入框">
							<i class="lyicon-add" plus></i>
						</label>
					</td>
				</tr>
				<tr>
					<td>去边框</td>
					<td>
						<label class="ly_input ly_not_border width300">
							<input type="text" name="name" placeholder="输入框">
							<i class="lyicon-search"></i>
						</label>
					</td>
				</tr>
				<tr>
					<td>下拉框</td>
					<td>
						<!-- 暂无数据样式 -->
						<label class="ly_input_suffix inline-flex" ly-drop-select>
							<input type="text" placeholder="暂无数据">
							<input type="hidden" name="name">
							<i class="lyicon-arrow-down-bold"></i>
							<script type="text">
								[

								]
						    </script>
						</label>
						
						<!-- 默认 -->
						<script>
							var ly_drop_select_fn = {
								init(el,box,data){
									console.log('el',el);
									console.log('box',box);
									console.log('data',data);
								},
								change(el,box,data){
									console.log('el',el);
									console.log('box',box);
									console.log('data',data);
								}
							}
						</script>
						<label class="ly_input_suffix inline-flex" ly-drop-select fn="ly_drop_select_fn">
							<input type="text" placeholder="输入框">
							<input type="hidden" name="name" value="1">
						    <script type="text">
								[
									{
										label: "需要看到的内容",
										value: "1"
									},
									{
										label: "需要看到的内容",
										value: "2",
										html: `<div>自定义插入標簽内容</div>`
									}
								]
						    </script>
							<i class="lyicon-arrow-down-bold"></i>
						</label>
						<!-- 单选 -->
						<label class="ly_input_suffix inline-flex" ly-drop-select data-type="radio">
							<input type="text" placeholder="输入框">
							<input type="hidden" name="name">
							<i class="lyicon-arrow-down-bold"></i>
						    <script type="text">
								[
									{
										"value": "河北省",
										"number": "130000",
										"children": [
										{
											"value": "石家庄市",
											"number": "130100",
											"children": [
											{
												"value": "长安区",
												"number": "130102"
											},
											{
												"value": "桥西区",
												"number": "130104"
											},
											{
												"value": "新华区",
												"number": "130105"
											},
											{
												"value": "井陉矿区",
												"number": "130107"
											},
											{
												"value": "裕华区",
												"number": "130108"
											},
											{
												"value": "藁城区",
												"number": "130109"
											},
											{
												"value": "鹿泉区",
												"number": "130110"
											},
											{
												"value": "栾城区",
												"number": "130111"
											},
											{
												"value": "井陉县",
												"number": "130121"
											},
											{
												"value": "正定县",
												"number": "130123"
											},
											{
												"value": "行唐县",
												"number": "130125"
											},
											{
												"value": "灵寿县",
												"number": "130126"
											},
											{
												"value": "高邑县",
												"number": "130127"
											},
											{
												"value": "深泽县",
												"number": "130128"
											},
											{
												"value": "赞皇县",
												"number": "130129"
											},
											{
												"value": "无极县",
												"number": "130130"
											},
											{
												"value": "平山县",
												"number": "130131"
											},
											{
												"value": "元氏县",
												"number": "130132"
											},
											{
												"value": "赵县",
												"number": "130133"
											},
											{
												"value": "辛集市",
												"number": "130181"
											},
											{
												"value": "晋州市",
												"number": "130183"
											},
											{
												"value": "新乐市",
												"number": "130184"
											}
											]
										},
										{
											"value": "唐山市",
											"number": "130200",
											"children": [
											{
												"value": "路南区",
												"number": "130202"
											},
											{
												"value": "路北区",
												"number": "130203"
											},
											{
												"value": "古冶区",
												"number": "130204"
											},
											{
												"value": "开平区",
												"number": "130205"
											},
											{
												"value": "丰南区",
												"number": "130207"
											},
											{
												"value": "丰润区",
												"number": "130208"
											},
											{
												"value": "曹妃甸区",
												"number": "130209"
											},
											{
												"value": "滦县",
												"number": "130223"
											},
											{
												"value": "滦南县",
												"number": "130224"
											},
											{
												"value": "乐亭县",
												"number": "130225"
											},
											{
												"value": "迁西县",
												"number": "130227"
											},
											{
												"value": "玉田县",
												"number": "130229"
											},
											{
												"value": "遵化市",
												"number": "130281"
											},
											{
												"value": "迁安市",
												"number": "130283"
											}
											]
										},
										{
											"value": "秦皇岛市",
											"number": "130300",
											"children": [
											{
												"value": "海港区",
												"number": "130302"
											},
											{
												"value": "山海关区",
												"number": "130303"
											},
											{
												"value": "北戴河区",
												"number": "130304"
											},
											{
												"value": "抚宁区",
												"number": "130306"
											},
											{
												"value": "青龙满族自治县",
												"number": "130321"
											},
											{
												"value": "昌黎县",
												"number": "130322"
											},
											{
												"value": "卢龙县",
												"number": "130324"
											}
											]
										},
										{
											"value": "邯郸市",
											"number": "130400",
											"children": [
											{
												"value": "邯山区",
												"number": "130402"
											},
											{
												"value": "丛台区",
												"number": "130403"
											},
											{
												"value": "复兴区",
												"number": "130404"
											},
											{
												"value": "峰峰矿区",
												"number": "130406"
											},
											{
												"value": "邯郸县",
												"number": "130421"
											},
											{
												"value": "临漳县",
												"number": "130423"
											},
											{
												"value": "成安县",
												"number": "130424"
											},
											{
												"value": "大名县",
												"number": "130425"
											},
											{
												"value": "涉县",
												"number": "130426"
											},
											{
												"value": "磁县",
												"number": "130427"
											},
											{
												"value": "肥乡县",
												"number": "130428"
											},
											{
												"value": "永年县",
												"number": "130429"
											},
											{
												"value": "邱县",
												"number": "130430"
											},
											{
												"value": "鸡泽县",
												"number": "130431"
											},
											{
												"value": "广平县",
												"number": "130432"
											},
											{
												"value": "馆陶县",
												"number": "130433"
											},
											{
												"value": "魏县",
												"number": "130434"
											},
											{
												"value": "曲周县",
												"number": "130435"
											},
											{
												"value": "武安市",
												"number": "130481"
											}
											]
										},
										{
											"value": "邢台市",
											"number": "130500",
											"children": [
											{
												"value": "桥东区",
												"number": "130502"
											},
											{
												"value": "桥西区",
												"number": "130503"
											},
											{
												"value": "邢台县",
												"number": "130521"
											},
											{
												"value": "临城县",
												"number": "130522"
											},
											{
												"value": "内丘县",
												"number": "130523"
											},
											{
												"value": "柏乡县",
												"number": "130524"
											},
											{
												"value": "隆尧县",
												"number": "130525"
											},
											{
												"value": "任县",
												"number": "130526"
											},
											{
												"value": "南和县",
												"number": "130527"
											},
											{
												"value": "宁晋县",
												"number": "130528"
											},
											{
												"value": "巨鹿县",
												"number": "130529"
											},
											{
												"value": "新河县",
												"number": "130530"
											},
											{
												"value": "广宗县",
												"number": "130531"
											},
											{
												"value": "平乡县",
												"number": "130532"
											},
											{
												"value": "威县",
												"number": "130533"
											},
											{
												"value": "清河县",
												"number": "130534"
											},
											{
												"value": "临西县",
												"number": "130535"
											},
											{
												"value": "南宫市",
												"number": "130581"
											},
											{
												"value": "沙河市",
												"number": "130582"
											}
											]
										},
										{
											"value": "保定市",
											"number": "130600",
											"children": [
											{
												"value": "竞秀区",
												"number": "130602"
											},
											{
												"value": "莲池区",
												"number": "130606"
											},
											{
												"value": "满城区",
												"number": "130607"
											},
											{
												"value": "清苑区",
												"number": "130608"
											},
											{
												"value": "徐水区",
												"number": "130609"
											},
											{
												"value": "涞水县",
												"number": "130623"
											},
											{
												"value": "阜平县",
												"number": "130624"
											},
											{
												"value": "定兴县",
												"number": "130626"
											},
											{
												"value": "唐县",
												"number": "130627"
											},
											{
												"value": "高阳县",
												"number": "130628"
											},
											{
												"value": "容城县",
												"number": "130629"
											},
											{
												"value": "涞源县",
												"number": "130630"
											},
											{
												"value": "望都县",
												"number": "130631"
											},
											{
												"value": "安新县",
												"number": "130632"
											},
											{
												"value": "易县",
												"number": "130633"
											},
											{
												"value": "曲阳县",
												"number": "130634"
											},
											{
												"value": "蠡县",
												"number": "130635"
											},
											{
												"value": "顺平县",
												"number": "130636"
											},
											{
												"value": "博野县",
												"number": "130637"
											},
											{
												"value": "雄县",
												"number": "130638"
											},
											{
												"value": "涿州市",
												"number": "130681"
											},
											{
												"value": "定州市",
												"number": "130682"
											},
											{
												"value": "安国市",
												"number": "130683"
											},
											{
												"value": "高碑店市",
												"number": "130684"
											}
											]
										},
										{
											"value": "张家口市",
											"number": "130700",
											"children": [
											{
												"value": "桥东区",
												"number": "130702"
											},
											{
												"value": "桥西区",
												"number": "130703"
											},
											{
												"value": "宣化区",
												"number": "130705"
											},
											{
												"value": "下花园区",
												"number": "130706"
											},
											{
												"value": "宣化县",
												"number": "130721"
											},
											{
												"value": "张北县",
												"number": "130722"
											},
											{
												"value": "康保县",
												"number": "130723"
											},
											{
												"value": "沽源县",
												"number": "130724"
											},
											{
												"value": "尚义县",
												"number": "130725"
											},
											{
												"value": "蔚县",
												"number": "130726"
											},
											{
												"value": "阳原县",
												"number": "130727"
											},
											{
												"value": "怀安县",
												"number": "130728"
											},
											{
												"value": "万全县",
												"number": "130729"
											},
											{
												"value": "怀来县",
												"number": "130730"
											},
											{
												"value": "涿鹿县",
												"number": "130731"
											},
											{
												"value": "赤城县",
												"number": "130732"
											},
											{
												"value": "崇礼县",
												"number": "130733"
											}
											]
										},
										{
											"value": "承德市",
											"number": "130800",
											"children": [
											{
												"value": "双桥区",
												"number": "130802"
											},
											{
												"value": "双滦区",
												"number": "130803"
											},
											{
												"value": "鹰手营子矿区",
												"number": "130804"
											},
											{
												"value": "承德县",
												"number": "130821"
											},
											{
												"value": "兴隆县",
												"number": "130822"
											},
											{
												"value": "平泉县",
												"number": "130823"
											},
											{
												"value": "滦平县",
												"number": "130824"
											},
											{
												"value": "隆化县",
												"number": "130825"
											},
											{
												"value": "丰宁满族自治县",
												"number": "130826"
											},
											{
												"value": "宽城满族自治县",
												"number": "130827"
											},
											{
												"value": "围场满族蒙古族自治县",
												"number": "130828"
											}
											]
										},
										{
											"value": "沧州市",
											"number": "130900",
											"children": [
											{
												"value": "新华区",
												"number": "130902"
											},
											{
												"value": "运河区",
												"number": "130903"
											},
											{
												"value": "沧县",
												"number": "130921"
											},
											{
												"value": "青县",
												"number": "130922"
											},
											{
												"value": "东光县",
												"number": "130923"
											},
											{
												"value": "海兴县",
												"number": "130924"
											},
											{
												"value": "盐山县",
												"number": "130925"
											},
											{
												"value": "肃宁县",
												"number": "130926"
											},
											{
												"value": "南皮县",
												"number": "130927"
											},
											{
												"value": "吴桥县",
												"number": "130928"
											},
											{
												"value": "献县",
												"number": "130929"
											},
											{
												"value": "孟村回族自治县",
												"number": "130930"
											},
											{
												"value": "泊头市",
												"number": "130981"
											},
											{
												"value": "任丘市",
												"number": "130982"
											},
											{
												"value": "黄骅市",
												"number": "130983"
											},
											{
												"value": "河间市",
												"number": "130984"
											}
											]
										},
										{
											"value": "廊坊市",
											"number": "131000",
											"children": [
											{
												"value": "安次区",
												"number": "131002"
											},
											{
												"value": "广阳区",
												"number": "131003"
											},
											{
												"value": "固安县",
												"number": "131022"
											},
											{
												"value": "永清县",
												"number": "131023"
											},
											{
												"value": "香河县",
												"number": "131024"
											},
											{
												"value": "大城县",
												"number": "131025"
											},
											{
												"value": "文安县",
												"number": "131026"
											},
											{
												"value": "大厂回族自治县",
												"number": "131028"
											},
											{
												"value": "霸州市",
												"number": "131081"
											},
											{
												"value": "三河市",
												"number": "131082"
											}
											]
										},
										{
											"value": "衡水市",
											"number": "131100",
											"children": [
											{
												"value": "桃城区",
												"number": "131102"
											},
											{
												"value": "枣强县",
												"number": "131121"
											},
											{
												"value": "武邑县",
												"number": "131122"
											},
											{
												"value": "武强县",
												"number": "131123"
											},
											{
												"value": "饶阳县",
												"number": "131124"
											},
											{
												"value": "安平县",
												"number": "131125"
											},
											{
												"value": "故城县",
												"number": "131126"
											},
											{
												"value": "景县",
												"number": "131127"
											},
											{
												"value": "阜城县",
												"number": "131128"
											},
											{
												"value": "冀州市",
												"number": "131181"
											},
											{
												"value": "深州市",
												"number": "131182"
											}
											]
										}
										]
									},
									{
										"value": "山西省",
										"number": "140000",
										"children": [
										{
											"value": "太原市",
											"number": "140100",
											"children": [
											{
												"value": "小店区",
												"number": "140105"
											},
											{
												"value": "迎泽区",
												"number": "140106"
											},
											{
												"value": "杏花岭区",
												"number": "140107"
											},
											{
												"value": "尖草坪区",
												"number": "140108"
											},
											{
												"value": "万柏林区",
												"number": "140109"
											},
											{
												"value": "晋源区",
												"number": "140110"
											},
											{
												"value": "清徐县",
												"number": "140121"
											},
											{
												"value": "阳曲县",
												"number": "140122"
											},
											{
												"value": "娄烦县",
												"number": "140123"
											},
											{
												"value": "古交市",
												"number": "140181"
											}
											]
										},
										{
											"value": "大同市",
											"number": "140200",
											"children": [
											{
												"value": "城区",
												"number": "140202"
											},
											{
												"value": "矿区",
												"number": "140203"
											},
											{
												"value": "南郊区",
												"number": "140211"
											},
											{
												"value": "新荣区",
												"number": "140212"
											},
											{
												"value": "阳高县",
												"number": "140221"
											},
											{
												"value": "天镇县",
												"number": "140222"
											},
											{
												"value": "广灵县",
												"number": "140223"
											},
											{
												"value": "灵丘县",
												"number": "140224"
											},
											{
												"value": "浑源县",
												"number": "140225"
											},
											{
												"value": "左云县",
												"number": "140226"
											},
											{
												"value": "大同县",
												"number": "140227"
											}
											]
										},
										{
											"value": "阳泉市",
											"number": "140300",
											"children": [
											{
												"value": "城区",
												"number": "140302"
											},
											{
												"value": "矿区",
												"number": "140303"
											},
											{
												"value": "郊区",
												"number": "140311"
											},
											{
												"value": "平定县",
												"number": "140321"
											},
											{
												"value": "盂县",
												"number": "140322"
											}
											]
										},
										{
											"value": "长治市",
											"number": "140400",
											"children": [
											{
												"value": "城区",
												"number": "140402"
											},
											{
												"value": "郊区",
												"number": "140411"
											},
											{
												"value": "长治县",
												"number": "140421"
											},
											{
												"value": "襄垣县",
												"number": "140423"
											},
											{
												"value": "屯留县",
												"number": "140424"
											},
											{
												"value": "平顺县",
												"number": "140425"
											},
											{
												"value": "黎城县",
												"number": "140426"
											},
											{
												"value": "壶关县",
												"number": "140427"
											},
											{
												"value": "长子县",
												"number": "140428"
											},
											{
												"value": "武乡县",
												"number": "140429"
											},
											{
												"value": "沁县",
												"number": "140430"
											},
											{
												"value": "沁源县",
												"number": "140431"
											},
											{
												"value": "潞城市",
												"number": "140481"
											}
											]
										},
										{
											"value": "晋城市",
											"number": "140500",
											"children": [
											{
												"value": "城区",
												"number": "140502"
											},
											{
												"value": "沁水县",
												"number": "140521"
											},
											{
												"value": "阳城县",
												"number": "140522"
											},
											{
												"value": "陵川县",
												"number": "140524"
											},
											{
												"value": "泽州县",
												"number": "140525"
											},
											{
												"value": "高平市",
												"number": "140581"
											}
											]
										},
										{
											"value": "朔州市",
											"number": "140600",
											"children": [
											{
												"value": "朔城区",
												"number": "140602"
											},
											{
												"value": "平鲁区",
												"number": "140603"
											},
											{
												"value": "山阴县",
												"number": "140621"
											},
											{
												"value": "应县",
												"number": "140622"
											},
											{
												"value": "右玉县",
												"number": "140623"
											},
											{
												"value": "怀仁县",
												"number": "140624"
											}
											]
										},
										{
											"value": "晋中市",
											"number": "140700",
											"children": [
											{
												"value": "榆次区",
												"number": "140702"
											},
											{
												"value": "榆社县",
												"number": "140721"
											},
											{
												"value": "左权县",
												"number": "140722"
											},
											{
												"value": "和顺县",
												"number": "140723"
											},
											{
												"value": "昔阳县",
												"number": "140724"
											},
											{
												"value": "寿阳县",
												"number": "140725"
											},
											{
												"value": "太谷县",
												"number": "140726"
											},
											{
												"value": "祁县",
												"number": "140727"
											},
											{
												"value": "平遥县",
												"number": "140728"
											},
											{
												"value": "灵石县",
												"number": "140729"
											},
											{
												"value": "介休市",
												"number": "140781"
											}
											]
										},
										{
											"value": "运城市",
											"number": "140800",
											"children": [
											{
												"value": "盐湖区",
												"number": "140802"
											},
											{
												"value": "临猗县",
												"number": "140821"
											},
											{
												"value": "万荣县",
												"number": "140822"
											},
											{
												"value": "闻喜县",
												"number": "140823"
											},
											{
												"value": "稷山县",
												"number": "140824"
											},
											{
												"value": "新绛县",
												"number": "140825"
											},
											{
												"value": "绛县",
												"number": "140826"
											},
											{
												"value": "垣曲县",
												"number": "140827"
											},
											{
												"value": "夏县",
												"number": "140828"
											},
											{
												"value": "平陆县",
												"number": "140829"
											},
											{
												"value": "芮城县",
												"number": "140830"
											},
											{
												"value": "永济市",
												"number": "140881"
											},
											{
												"value": "河津市",
												"number": "140882"
											}
											]
										},
										{
											"value": "忻州市",
											"number": "140900",
											"children": [
											{
												"value": "忻府区",
												"number": "140902"
											},
											{
												"value": "定襄县",
												"number": "140921"
											},
											{
												"value": "五台县",
												"number": "140922"
											},
											{
												"value": "代县",
												"number": "140923"
											},
											{
												"value": "繁峙县",
												"number": "140924"
											},
											{
												"value": "宁武县",
												"number": "140925"
											},
											{
												"value": "静乐县",
												"number": "140926"
											},
											{
												"value": "神池县",
												"number": "140927"
											},
											{
												"value": "五寨县",
												"number": "140928"
											},
											{
												"value": "岢岚县",
												"number": "140929"
											},
											{
												"value": "河曲县",
												"number": "140930"
											},
											{
												"value": "保德县",
												"number": "140931"
											},
											{
												"value": "偏关县",
												"number": "140932"
											},
											{
												"value": "原平市",
												"number": "140981"
											}
											]
										},
										{
											"value": "临汾市",
											"number": "141000",
											"children": [
											{
												"value": "尧都区",
												"number": "141002"
											},
											{
												"value": "曲沃县",
												"number": "141021"
											},
											{
												"value": "翼城县",
												"number": "141022"
											},
											{
												"value": "襄汾县",
												"number": "141023"
											},
											{
												"value": "洪洞县",
												"number": "141024"
											},
											{
												"value": "古县",
												"number": "141025"
											},
											{
												"value": "安泽县",
												"number": "141026"
											},
											{
												"value": "浮山县",
												"number": "141027"
											},
											{
												"value": "吉县",
												"number": "141028"
											},
											{
												"value": "乡宁县",
												"number": "141029"
											},
											{
												"value": "大宁县",
												"number": "141030"
											},
											{
												"value": "隰县",
												"number": "141031"
											},
											{
												"value": "永和县",
												"number": "141032"
											},
											{
												"value": "蒲县",
												"number": "141033"
											},
											{
												"value": "汾西县",
												"number": "141034"
											},
											{
												"value": "侯马市",
												"number": "141081"
											},
											{
												"value": "霍州市",
												"number": "141082"
											}
											]
										},
										{
											"value": "吕梁市",
											"number": "141100",
											"children": [
											{
												"value": "离石区",
												"number": "141102"
											},
											{
												"value": "文水县",
												"number": "141121"
											},
											{
												"value": "交城县",
												"number": "141122"
											},
											{
												"value": "兴县",
												"number": "141123"
											},
											{
												"value": "临县",
												"number": "141124"
											},
											{
												"value": "柳林县",
												"number": "141125"
											},
											{
												"value": "石楼县",
												"number": "141126"
											},
											{
												"value": "岚县",
												"number": "141127"
											},
											{
												"value": "方山县",
												"number": "141128"
											},
											{
												"value": "中阳县",
												"number": "141129"
											},
											{
												"value": "交口县",
												"number": "141130"
											},
											{
												"value": "孝义市",
												"number": "141181"
											},
											{
												"value": "汾阳市",
												"number": "141182"
											}
											]
										}
										]
									},
									{
										"value": "内蒙古自治区",
										"number": "150000",
										"children": [
										{
											"value": "呼和浩特市",
											"number": "150100",
											"children": [
											{
												"value": "新城区",
												"number": "150102"
											},
											{
												"value": "回民区",
												"number": "150103"
											},
											{
												"value": "玉泉区",
												"number": "150104"
											},
											{
												"value": "赛罕区",
												"number": "150105"
											},
											{
												"value": "土默特左旗",
												"number": "150121"
											},
											{
												"value": "托克托县",
												"number": "150122"
											},
											{
												"value": "和林格尔县",
												"number": "150123"
											},
											{
												"value": "清水河县",
												"number": "150124"
											},
											{
												"value": "武川县",
												"number": "150125"
											}
											]
										},
										{
											"value": "包头市",
											"number": "150200",
											"children": [
											{
												"value": "东河区",
												"number": "150202"
											},
											{
												"value": "昆都仑区",
												"number": "150203"
											},
											{
												"value": "青山区",
												"number": "150204"
											},
											{
												"value": "石拐区",
												"number": "150205"
											},
											{
												"value": "白云鄂博矿区",
												"number": "150206"
											},
											{
												"value": "九原区",
												"number": "150207"
											},
											{
												"value": "土默特右旗",
												"number": "150221"
											},
											{
												"value": "固阳县",
												"number": "150222"
											},
											{
												"value": "达尔罕茂明安联合旗",
												"number": "150223"
											}
											]
										},
										{
											"value": "乌海市",
											"number": "150300",
											"children": [
											{
												"value": "海勃湾区",
												"number": "150302"
											},
											{
												"value": "海南区",
												"number": "150303"
											},
											{
												"value": "乌达区",
												"number": "150304"
											}
											]
										},
										{
											"value": "赤峰市",
											"number": "150400",
											"children": [
											{
												"value": "红山区",
												"number": "150402"
											},
											{
												"value": "元宝山区",
												"number": "150403"
											},
											{
												"value": "松山区",
												"number": "150404"
											},
											{
												"value": "阿鲁科尔沁旗",
												"number": "150421"
											},
											{
												"value": "巴林左旗",
												"number": "150422"
											},
											{
												"value": "巴林右旗",
												"number": "150423"
											},
											{
												"value": "林西县",
												"number": "150424"
											},
											{
												"value": "克什克腾旗",
												"number": "150425"
											},
											{
												"value": "翁牛特旗",
												"number": "150426"
											},
											{
												"value": "喀喇沁旗",
												"number": "150428"
											},
											{
												"value": "宁城县",
												"number": "150429"
											},
											{
												"value": "敖汉旗",
												"number": "150430"
											}
											]
										},
										{
											"value": "通辽市",
											"number": "150500",
											"children": [
											{
												"value": "科尔沁区",
												"number": "150502"
											},
											{
												"value": "科尔沁左翼中旗",
												"number": "150521"
											},
											{
												"value": "科尔沁左翼后旗",
												"number": "150522"
											},
											{
												"value": "开鲁县",
												"number": "150523"
											},
											{
												"value": "库伦旗",
												"number": "150524"
											},
											{
												"value": "奈曼旗",
												"number": "150525"
											},
											{
												"value": "扎鲁特旗",
												"number": "150526"
											},
											{
												"value": "霍林郭勒市",
												"number": "150581"
											}
											]
										},
										{
											"value": "鄂尔多斯市",
											"number": "150600",
											"children": [
											{
												"value": "东胜区",
												"number": "150602"
											},
											{
												"value": "达拉特旗",
												"number": "150621"
											},
											{
												"value": "准格尔旗",
												"number": "150622"
											},
											{
												"value": "鄂托克前旗",
												"number": "150623"
											},
											{
												"value": "鄂托克旗",
												"number": "150624"
											},
											{
												"value": "杭锦旗",
												"number": "150625"
											},
											{
												"value": "乌审旗",
												"number": "150626"
											},
											{
												"value": "伊金霍洛旗",
												"number": "150627"
											}
											]
										},
										{
											"value": "呼伦贝尔市",
											"number": "150700",
											"children": [
											{
												"value": "海拉尔区",
												"number": "150702"
											},
											{
												"value": "扎赉诺尔区",
												"number": "150703"
											},
											{
												"value": "阿荣旗",
												"number": "150721"
											},
											{
												"value": "莫力达瓦达斡尔族自治旗",
												"number": "150722"
											},
											{
												"value": "鄂伦春自治旗",
												"number": "150723"
											},
											{
												"value": "鄂温克族自治旗",
												"number": "150724"
											},
											{
												"value": "陈巴尔虎旗",
												"number": "150725"
											},
											{
												"value": "新巴尔虎左旗",
												"number": "150726"
											},
											{
												"value": "新巴尔虎右旗",
												"number": "150727"
											},
											{
												"value": "满洲里市",
												"number": "150781"
											},
											{
												"value": "牙克石市",
												"number": "150782"
											},
											{
												"value": "扎兰屯市",
												"number": "150783"
											},
											{
												"value": "额尔古纳市",
												"number": "150784"
											},
											{
												"value": "根河市",
												"number": "150785"
											}
											]
										},
										{
											"value": "巴彦淖尔市",
											"number": "150800",
											"children": [
											{
												"value": "临河区",
												"number": "150802"
											},
											{
												"value": "五原县",
												"number": "150821"
											},
											{
												"value": "磴口县",
												"number": "150822"
											},
											{
												"value": "乌拉特前旗",
												"number": "150823"
											},
											{
												"value": "乌拉特中旗",
												"number": "150824"
											},
											{
												"value": "乌拉特后旗",
												"number": "150825"
											},
											{
												"value": "杭锦后旗",
												"number": "150826"
											}
											]
										},
										{
											"value": "乌兰察布市",
											"number": "150900",
											"children": [
											{
												"value": "集宁区",
												"number": "150902"
											},
											{
												"value": "卓资县",
												"number": "150921"
											},
											{
												"value": "化德县",
												"number": "150922"
											},
											{
												"value": "商都县",
												"number": "150923"
											},
											{
												"value": "兴和县",
												"number": "150924"
											},
											{
												"value": "凉城县",
												"number": "150925"
											},
											{
												"value": "察哈尔右翼前旗",
												"number": "150926"
											},
											{
												"value": "察哈尔右翼中旗",
												"number": "150927"
											},
											{
												"value": "察哈尔右翼后旗",
												"number": "150928"
											},
											{
												"value": "四子王旗",
												"number": "150929"
											},
											{
												"value": "丰镇市",
												"number": "150981"
											}
											]
										},
										{
											"value": "兴安盟",
											"number": "152200",
											"children": [
											{
												"value": "乌兰浩特市",
												"number": "152201"
											},
											{
												"value": "阿尔山市",
												"number": "152202"
											},
											{
												"value": "科尔沁右翼前旗",
												"number": "152221"
											},
											{
												"value": "科尔沁右翼中旗",
												"number": "152222"
											},
											{
												"value": "扎赉特旗",
												"number": "152223"
											},
											{
												"value": "突泉县",
												"number": "152224"
											}
											]
										},
										{
											"value": "锡林郭勒盟",
											"number": "152500",
											"children": [
											{
												"value": "二连浩特市",
												"number": "152501"
											},
											{
												"value": "锡林浩特市",
												"number": "152502"
											},
											{
												"value": "阿巴嘎旗",
												"number": "152522"
											},
											{
												"value": "苏尼特左旗",
												"number": "152523"
											},
											{
												"value": "苏尼特右旗",
												"number": "152524"
											},
											{
												"value": "东乌珠穆沁旗",
												"number": "152525"
											},
											{
												"value": "西乌珠穆沁旗",
												"number": "152526"
											},
											{
												"value": "太仆寺旗",
												"number": "152527"
											},
											{
												"value": "镶黄旗",
												"number": "152528"
											},
											{
												"value": "正镶白旗",
												"number": "152529"
											},
											{
												"value": "正蓝旗",
												"number": "152530"
											},
											{
												"value": "多伦县",
												"number": "152531"
											}
											]
										},
										{
											"value": "阿拉善盟",
											"number": "152900",
											"children": [
											{
												"value": "阿拉善左旗",
												"number": "152921"
											},
											{
												"value": "阿拉善右旗",
												"number": "152922"
											},
											{
												"value": "额济纳旗",
												"number": "152923"
											}
											]
										}
										]
									},
								]
						    </script>
						</label>
						<!-- 多选 -->
						<label class="ly_select_checkbox inline-flex" ly-drop-select data-type="checkbox">
							<div>
								<input type="text" placeholder="输入框">
							</div>
							<input type="hidden" name="name">
							<i class="lyicon-arrow-down-bold"></i>
							
						    <script type="text">
								[
									{
										"value": "河北省",
										"number": "130000",
										"children": [
										{
											"value": "石家庄市",
											"number": "130100",
											"children": [
											{
												"value": "长安区",
												"number": "130102"
											},
											{
												"value": "桥西区",
												"number": "130104"
											},
											{
												"value": "新华区",
												"number": "130105"
											},
											{
												"value": "井陉矿区",
												"number": "130107"
											},
											{
												"value": "裕华区",
												"number": "130108"
											},
											{
												"value": "藁城区",
												"number": "130109"
											},
											{
												"value": "鹿泉区",
												"number": "130110"
											},
											{
												"value": "栾城区",
												"number": "130111"
											},
											{
												"value": "井陉县",
												"number": "130121"
											},
											{
												"value": "正定县",
												"number": "130123"
											},
											{
												"value": "行唐县",
												"number": "130125"
											},
											{
												"value": "灵寿县",
												"number": "130126"
											},
											{
												"value": "高邑县",
												"number": "130127"
											},
											{
												"value": "深泽县",
												"number": "130128"
											},
											{
												"value": "赞皇县",
												"number": "130129"
											},
											{
												"value": "无极县",
												"number": "130130"
											},
											{
												"value": "平山县",
												"number": "130131"
											},
											{
												"value": "元氏县",
												"number": "130132"
											},
											{
												"value": "赵县",
												"number": "130133"
											},
											{
												"value": "辛集市",
												"number": "130181"
											},
											{
												"value": "晋州市",
												"number": "130183"
											},
											{
												"value": "新乐市",
												"number": "130184"
											}
											]
										},
										{
											"value": "唐山市",
											"number": "130200",
											"children": [
											{
												"value": "路南区",
												"number": "130202"
											},
											{
												"value": "路北区",
												"number": "130203"
											},
											{
												"value": "古冶区",
												"number": "130204"
											},
											{
												"value": "开平区",
												"number": "130205"
											},
											{
												"value": "丰南区",
												"number": "130207"
											},
											{
												"value": "丰润区",
												"number": "130208"
											},
											{
												"value": "曹妃甸区",
												"number": "130209"
											},
											{
												"value": "滦县",
												"number": "130223"
											},
											{
												"value": "滦南县",
												"number": "130224"
											},
											{
												"value": "乐亭县",
												"number": "130225"
											},
											{
												"value": "迁西县",
												"number": "130227"
											},
											{
												"value": "玉田县",
												"number": "130229"
											},
											{
												"value": "遵化市",
												"number": "130281"
											},
											{
												"value": "迁安市",
												"number": "130283"
											}
											]
										},
										{
											"value": "秦皇岛市",
											"number": "130300",
											"children": [
											{
												"value": "海港区",
												"number": "130302"
											},
											{
												"value": "山海关区",
												"number": "130303"
											},
											{
												"value": "北戴河区",
												"number": "130304"
											},
											{
												"value": "抚宁区",
												"number": "130306"
											},
											{
												"value": "青龙满族自治县",
												"number": "130321"
											},
											{
												"value": "昌黎县",
												"number": "130322"
											},
											{
												"value": "卢龙县",
												"number": "130324"
											}
											]
										},
										{
											"value": "邯郸市",
											"number": "130400",
											"children": [
											{
												"value": "邯山区",
												"number": "130402"
											},
											{
												"value": "丛台区",
												"number": "130403"
											},
											{
												"value": "复兴区",
												"number": "130404"
											},
											{
												"value": "峰峰矿区",
												"number": "130406"
											},
											{
												"value": "邯郸县",
												"number": "130421"
											},
											{
												"value": "临漳县",
												"number": "130423"
											},
											{
												"value": "成安县",
												"number": "130424"
											},
											{
												"value": "大名县",
												"number": "130425"
											},
											{
												"value": "涉县",
												"number": "130426"
											},
											{
												"value": "磁县",
												"number": "130427"
											},
											{
												"value": "肥乡县",
												"number": "130428"
											},
											{
												"value": "永年县",
												"number": "130429"
											},
											{
												"value": "邱县",
												"number": "130430"
											},
											{
												"value": "鸡泽县",
												"number": "130431"
											},
											{
												"value": "广平县",
												"number": "130432"
											},
											{
												"value": "馆陶县",
												"number": "130433"
											},
											{
												"value": "魏县",
												"number": "130434"
											},
											{
												"value": "曲周县",
												"number": "130435"
											},
											{
												"value": "武安市",
												"number": "130481"
											}
											]
										},
										{
											"value": "邢台市",
											"number": "130500",
											"children": [
											{
												"value": "桥东区",
												"number": "130502"
											},
											{
												"value": "桥西区",
												"number": "130503"
											},
											{
												"value": "邢台县",
												"number": "130521"
											},
											{
												"value": "临城县",
												"number": "130522"
											},
											{
												"value": "内丘县",
												"number": "130523"
											},
											{
												"value": "柏乡县",
												"number": "130524"
											},
											{
												"value": "隆尧县",
												"number": "130525"
											},
											{
												"value": "任县",
												"number": "130526"
											},
											{
												"value": "南和县",
												"number": "130527"
											},
											{
												"value": "宁晋县",
												"number": "130528"
											},
											{
												"value": "巨鹿县",
												"number": "130529"
											},
											{
												"value": "新河县",
												"number": "130530"
											},
											{
												"value": "广宗县",
												"number": "130531"
											},
											{
												"value": "平乡县",
												"number": "130532"
											},
											{
												"value": "威县",
												"number": "130533"
											},
											{
												"value": "清河县",
												"number": "130534"
											},
											{
												"value": "临西县",
												"number": "130535"
											},
											{
												"value": "南宫市",
												"number": "130581"
											},
											{
												"value": "沙河市",
												"number": "130582"
											}
											]
										},
										{
											"value": "保定市",
											"number": "130600",
											"children": [
											{
												"value": "竞秀区",
												"number": "130602"
											},
											{
												"value": "莲池区",
												"number": "130606"
											},
											{
												"value": "满城区",
												"number": "130607"
											},
											{
												"value": "清苑区",
												"number": "130608"
											},
											{
												"value": "徐水区",
												"number": "130609"
											},
											{
												"value": "涞水县",
												"number": "130623"
											},
											{
												"value": "阜平县",
												"number": "130624"
											},
											{
												"value": "定兴县",
												"number": "130626"
											},
											{
												"value": "唐县",
												"number": "130627"
											},
											{
												"value": "高阳县",
												"number": "130628"
											},
											{
												"value": "容城县",
												"number": "130629"
											},
											{
												"value": "涞源县",
												"number": "130630"
											},
											{
												"value": "望都县",
												"number": "130631"
											},
											{
												"value": "安新县",
												"number": "130632"
											},
											{
												"value": "易县",
												"number": "130633"
											},
											{
												"value": "曲阳县",
												"number": "130634"
											},
											{
												"value": "蠡县",
												"number": "130635"
											},
											{
												"value": "顺平县",
												"number": "130636"
											},
											{
												"value": "博野县",
												"number": "130637"
											},
											{
												"value": "雄县",
												"number": "130638"
											},
											{
												"value": "涿州市",
												"number": "130681"
											},
											{
												"value": "定州市",
												"number": "130682"
											},
											{
												"value": "安国市",
												"number": "130683"
											},
											{
												"value": "高碑店市",
												"number": "130684"
											}
											]
										},
										{
											"value": "张家口市",
											"number": "130700",
											"children": [
											{
												"value": "桥东区",
												"number": "130702"
											},
											{
												"value": "桥西区",
												"number": "130703"
											},
											{
												"value": "宣化区",
												"number": "130705"
											},
											{
												"value": "下花园区",
												"number": "130706"
											},
											{
												"value": "宣化县",
												"number": "130721"
											},
											{
												"value": "张北县",
												"number": "130722"
											},
											{
												"value": "康保县",
												"number": "130723"
											},
											{
												"value": "沽源县",
												"number": "130724"
											},
											{
												"value": "尚义县",
												"number": "130725"
											},
											{
												"value": "蔚县",
												"number": "130726"
											},
											{
												"value": "阳原县",
												"number": "130727"
											},
											{
												"value": "怀安县",
												"number": "130728"
											},
											{
												"value": "万全县",
												"number": "130729"
											},
											{
												"value": "怀来县",
												"number": "130730"
											},
											{
												"value": "涿鹿县",
												"number": "130731"
											},
											{
												"value": "赤城县",
												"number": "130732"
											},
											{
												"value": "崇礼县",
												"number": "130733"
											}
											]
										},
										{
											"value": "承德市",
											"number": "130800",
											"children": [
											{
												"value": "双桥区",
												"number": "130802"
											},
											{
												"value": "双滦区",
												"number": "130803"
											},
											{
												"value": "鹰手营子矿区",
												"number": "130804"
											},
											{
												"value": "承德县",
												"number": "130821"
											},
											{
												"value": "兴隆县",
												"number": "130822"
											},
											{
												"value": "平泉县",
												"number": "130823"
											},
											{
												"value": "滦平县",
												"number": "130824"
											},
											{
												"value": "隆化县",
												"number": "130825"
											},
											{
												"value": "丰宁满族自治县",
												"number": "130826"
											},
											{
												"value": "宽城满族自治县",
												"number": "130827"
											},
											{
												"value": "围场满族蒙古族自治县",
												"number": "130828"
											}
											]
										},
										{
											"value": "沧州市",
											"number": "130900",
											"children": [
											{
												"value": "新华区",
												"number": "130902"
											},
											{
												"value": "运河区",
												"number": "130903"
											},
											{
												"value": "沧县",
												"number": "130921"
											},
											{
												"value": "青县",
												"number": "130922"
											},
											{
												"value": "东光县",
												"number": "130923"
											},
											{
												"value": "海兴县",
												"number": "130924"
											},
											{
												"value": "盐山县",
												"number": "130925"
											},
											{
												"value": "肃宁县",
												"number": "130926"
											},
											{
												"value": "南皮县",
												"number": "130927"
											},
											{
												"value": "吴桥县",
												"number": "130928"
											},
											{
												"value": "献县",
												"number": "130929"
											},
											{
												"value": "孟村回族自治县",
												"number": "130930"
											},
											{
												"value": "泊头市",
												"number": "130981"
											},
											{
												"value": "任丘市",
												"number": "130982"
											},
											{
												"value": "黄骅市",
												"number": "130983"
											},
											{
												"value": "河间市",
												"number": "130984"
											}
											]
										},
										{
											"value": "廊坊市",
											"number": "131000",
											"children": [
											{
												"value": "安次区",
												"number": "131002"
											},
											{
												"value": "广阳区",
												"number": "131003"
											},
											{
												"value": "固安县",
												"number": "131022"
											},
											{
												"value": "永清县",
												"number": "131023"
											},
											{
												"value": "香河县",
												"number": "131024"
											},
											{
												"value": "大城县",
												"number": "131025"
											},
											{
												"value": "文安县",
												"number": "131026"
											},
											{
												"value": "大厂回族自治县",
												"number": "131028"
											},
											{
												"value": "霸州市",
												"number": "131081"
											},
											{
												"value": "三河市",
												"number": "131082"
											}
											]
										},
										{
											"value": "衡水市",
											"number": "131100",
											"children": [
											{
												"value": "桃城区",
												"number": "131102"
											},
											{
												"value": "枣强县",
												"number": "131121"
											},
											{
												"value": "武邑县",
												"number": "131122"
											},
											{
												"value": "武强县",
												"number": "131123"
											},
											{
												"value": "饶阳县",
												"number": "131124"
											},
											{
												"value": "安平县",
												"number": "131125"
											},
											{
												"value": "故城县",
												"number": "131126"
											},
											{
												"value": "景县",
												"number": "131127"
											},
											{
												"value": "阜城县",
												"number": "131128"
											},
											{
												"value": "冀州市",
												"number": "131181"
											},
											{
												"value": "深州市",
												"number": "131182"
											}
											]
										}
										]
									},
									{
										"value": "山西省",
										"number": "140000",
										"children": [
										{
											"value": "太原市",
											"number": "140100",
											"children": [
											{
												"value": "小店区",
												"number": "140105"
											},
											{
												"value": "迎泽区",
												"number": "140106"
											},
											{
												"value": "杏花岭区",
												"number": "140107"
											},
											{
												"value": "尖草坪区",
												"number": "140108"
											},
											{
												"value": "万柏林区",
												"number": "140109"
											},
											{
												"value": "晋源区",
												"number": "140110"
											},
											{
												"value": "清徐县",
												"number": "140121"
											},
											{
												"value": "阳曲县",
												"number": "140122"
											},
											{
												"value": "娄烦县",
												"number": "140123"
											},
											{
												"value": "古交市",
												"number": "140181"
											}
											]
										},
										{
											"value": "大同市",
											"number": "140200",
											"children": [
											{
												"value": "城区",
												"number": "140202"
											},
											{
												"value": "矿区",
												"number": "140203"
											},
											{
												"value": "南郊区",
												"number": "140211"
											},
											{
												"value": "新荣区",
												"number": "140212"
											},
											{
												"value": "阳高县",
												"number": "140221"
											},
											{
												"value": "天镇县",
												"number": "140222"
											},
											{
												"value": "广灵县",
												"number": "140223"
											},
											{
												"value": "灵丘县",
												"number": "140224"
											},
											{
												"value": "浑源县",
												"number": "140225"
											},
											{
												"value": "左云县",
												"number": "140226"
											},
											{
												"value": "大同县",
												"number": "140227"
											}
											]
										},
										{
											"value": "阳泉市",
											"number": "140300",
											"children": [
											{
												"value": "城区",
												"number": "140302"
											},
											{
												"value": "矿区",
												"number": "140303"
											},
											{
												"value": "郊区",
												"number": "140311"
											},
											{
												"value": "平定县",
												"number": "140321"
											},
											{
												"value": "盂县",
												"number": "140322"
											}
											]
										},
										{
											"value": "长治市",
											"number": "140400",
											"children": [
											{
												"value": "城区",
												"number": "140402"
											},
											{
												"value": "郊区",
												"number": "140411"
											},
											{
												"value": "长治县",
												"number": "140421"
											},
											{
												"value": "襄垣县",
												"number": "140423"
											},
											{
												"value": "屯留县",
												"number": "140424"
											},
											{
												"value": "平顺县",
												"number": "140425"
											},
											{
												"value": "黎城县",
												"number": "140426"
											},
											{
												"value": "壶关县",
												"number": "140427"
											},
											{
												"value": "长子县",
												"number": "140428"
											},
											{
												"value": "武乡县",
												"number": "140429"
											},
											{
												"value": "沁县",
												"number": "140430"
											},
											{
												"value": "沁源县",
												"number": "140431"
											},
											{
												"value": "潞城市",
												"number": "140481"
											}
											]
										},
										{
											"value": "晋城市",
											"number": "140500",
											"children": [
											{
												"value": "城区",
												"number": "140502"
											},
											{
												"value": "沁水县",
												"number": "140521"
											},
											{
												"value": "阳城县",
												"number": "140522"
											},
											{
												"value": "陵川县",
												"number": "140524"
											},
											{
												"value": "泽州县",
												"number": "140525"
											},
											{
												"value": "高平市",
												"number": "140581"
											}
											]
										},
										{
											"value": "朔州市",
											"number": "140600",
											"children": [
											{
												"value": "朔城区",
												"number": "140602"
											},
											{
												"value": "平鲁区",
												"number": "140603"
											},
											{
												"value": "山阴县",
												"number": "140621"
											},
											{
												"value": "应县",
												"number": "140622"
											},
											{
												"value": "右玉县",
												"number": "140623"
											},
											{
												"value": "怀仁县",
												"number": "140624"
											}
											]
										},
										{
											"value": "晋中市",
											"number": "140700",
											"children": [
											{
												"value": "榆次区",
												"number": "140702"
											},
											{
												"value": "榆社县",
												"number": "140721"
											},
											{
												"value": "左权县",
												"number": "140722"
											},
											{
												"value": "和顺县",
												"number": "140723"
											},
											{
												"value": "昔阳县",
												"number": "140724"
											},
											{
												"value": "寿阳县",
												"number": "140725"
											},
											{
												"value": "太谷县",
												"number": "140726"
											},
											{
												"value": "祁县",
												"number": "140727"
											},
											{
												"value": "平遥县",
												"number": "140728"
											},
											{
												"value": "灵石县",
												"number": "140729"
											},
											{
												"value": "介休市",
												"number": "140781"
											}
											]
										},
										{
											"value": "运城市",
											"number": "140800",
											"children": [
											{
												"value": "盐湖区",
												"number": "140802"
											},
											{
												"value": "临猗县",
												"number": "140821"
											},
											{
												"value": "万荣县",
												"number": "140822"
											},
											{
												"value": "闻喜县",
												"number": "140823"
											},
											{
												"value": "稷山县",
												"number": "140824"
											},
											{
												"value": "新绛县",
												"number": "140825"
											},
											{
												"value": "绛县",
												"number": "140826"
											},
											{
												"value": "垣曲县",
												"number": "140827"
											},
											{
												"value": "夏县",
												"number": "140828"
											},
											{
												"value": "平陆县",
												"number": "140829"
											},
											{
												"value": "芮城县",
												"number": "140830"
											},
											{
												"value": "永济市",
												"number": "140881"
											},
											{
												"value": "河津市",
												"number": "140882"
											}
											]
										},
										{
											"value": "忻州市",
											"number": "140900",
											"children": [
											{
												"value": "忻府区",
												"number": "140902"
											},
											{
												"value": "定襄县",
												"number": "140921"
											},
											{
												"value": "五台县",
												"number": "140922"
											},
											{
												"value": "代县",
												"number": "140923"
											},
											{
												"value": "繁峙县",
												"number": "140924"
											},
											{
												"value": "宁武县",
												"number": "140925"
											},
											{
												"value": "静乐县",
												"number": "140926"
											},
											{
												"value": "神池县",
												"number": "140927"
											},
											{
												"value": "五寨县",
												"number": "140928"
											},
											{
												"value": "岢岚县",
												"number": "140929"
											},
											{
												"value": "河曲县",
												"number": "140930"
											},
											{
												"value": "保德县",
												"number": "140931"
											},
											{
												"value": "偏关县",
												"number": "140932"
											},
											{
												"value": "原平市",
												"number": "140981"
											}
											]
										},
										{
											"value": "临汾市",
											"number": "141000",
											"children": [
											{
												"value": "尧都区",
												"number": "141002"
											},
											{
												"value": "曲沃县",
												"number": "141021"
											},
											{
												"value": "翼城县",
												"number": "141022"
											},
											{
												"value": "襄汾县",
												"number": "141023"
											},
											{
												"value": "洪洞县",
												"number": "141024"
											},
											{
												"value": "古县",
												"number": "141025"
											},
											{
												"value": "安泽县",
												"number": "141026"
											},
											{
												"value": "浮山县",
												"number": "141027"
											},
											{
												"value": "吉县",
												"number": "141028"
											},
											{
												"value": "乡宁县",
												"number": "141029"
											},
											{
												"value": "大宁县",
												"number": "141030"
											},
											{
												"value": "隰县",
												"number": "141031"
											},
											{
												"value": "永和县",
												"number": "141032"
											},
											{
												"value": "蒲县",
												"number": "141033"
											},
											{
												"value": "汾西县",
												"number": "141034"
											},
											{
												"value": "侯马市",
												"number": "141081"
											},
											{
												"value": "霍州市",
												"number": "141082"
											}
											]
										},
										{
											"value": "吕梁市",
											"number": "141100",
											"children": [
											{
												"value": "离石区",
												"number": "141102"
											},
											{
												"value": "文水县",
												"number": "141121"
											},
											{
												"value": "交城县",
												"number": "141122"
											},
											{
												"value": "兴县",
												"number": "141123"
											},
											{
												"value": "临县",
												"number": "141124"
											},
											{
												"value": "柳林县",
												"number": "141125"
											},
											{
												"value": "石楼县",
												"number": "141126"
											},
											{
												"value": "岚县",
												"number": "141127"
											},
											{
												"value": "方山县",
												"number": "141128"
											},
											{
												"value": "中阳县",
												"number": "141129"
											},
											{
												"value": "交口县",
												"number": "141130"
											},
											{
												"value": "孝义市",
												"number": "141181"
											},
											{
												"value": "汾阳市",
												"number": "141182"
											}
											]
										}
										]
									},
									{
										"value": "内蒙古自治区",
										"number": "150000",
										"children": [
										{
											"value": "呼和浩特市",
											"number": "150100",
											"children": [
											{
												"value": "新城区",
												"number": "150102"
											},
											{
												"value": "回民区",
												"number": "150103"
											},
											{
												"value": "玉泉区",
												"number": "150104"
											},
											{
												"value": "赛罕区",
												"number": "150105"
											},
											{
												"value": "土默特左旗",
												"number": "150121"
											},
											{
												"value": "托克托县",
												"number": "150122"
											},
											{
												"value": "和林格尔县",
												"number": "150123"
											},
											{
												"value": "清水河县",
												"number": "150124"
											},
											{
												"value": "武川县",
												"number": "150125"
											}
											]
										},
										{
											"value": "包头市",
											"number": "150200",
											"children": [
											{
												"value": "东河区",
												"number": "150202"
											},
											{
												"value": "昆都仑区",
												"number": "150203"
											},
											{
												"value": "青山区",
												"number": "150204"
											},
											{
												"value": "石拐区",
												"number": "150205"
											},
											{
												"value": "白云鄂博矿区",
												"number": "150206"
											},
											{
												"value": "九原区",
												"number": "150207"
											},
											{
												"value": "土默特右旗",
												"number": "150221"
											},
											{
												"value": "固阳县",
												"number": "150222"
											},
											{
												"value": "达尔罕茂明安联合旗",
												"number": "150223"
											}
											]
										},
										{
											"value": "乌海市",
											"number": "150300",
											"children": [
											{
												"value": "海勃湾区",
												"number": "150302"
											},
											{
												"value": "海南区",
												"number": "150303"
											},
											{
												"value": "乌达区",
												"number": "150304"
											}
											]
										},
										{
											"value": "赤峰市",
											"number": "150400",
											"children": [
											{
												"value": "红山区",
												"number": "150402"
											},
											{
												"value": "元宝山区",
												"number": "150403"
											},
											{
												"value": "松山区",
												"number": "150404"
											},
											{
												"value": "阿鲁科尔沁旗",
												"number": "150421"
											},
											{
												"value": "巴林左旗",
												"number": "150422"
											},
											{
												"value": "巴林右旗",
												"number": "150423"
											},
											{
												"value": "林西县",
												"number": "150424"
											},
											{
												"value": "克什克腾旗",
												"number": "150425"
											},
											{
												"value": "翁牛特旗",
												"number": "150426"
											},
											{
												"value": "喀喇沁旗",
												"number": "150428"
											},
											{
												"value": "宁城县",
												"number": "150429"
											},
											{
												"value": "敖汉旗",
												"number": "150430"
											}
											]
										},
										{
											"value": "通辽市",
											"number": "150500",
											"children": [
											{
												"value": "科尔沁区",
												"number": "150502"
											},
											{
												"value": "科尔沁左翼中旗",
												"number": "150521"
											},
											{
												"value": "科尔沁左翼后旗",
												"number": "150522"
											},
											{
												"value": "开鲁县",
												"number": "150523"
											},
											{
												"value": "库伦旗",
												"number": "150524"
											},
											{
												"value": "奈曼旗",
												"number": "150525"
											},
											{
												"value": "扎鲁特旗",
												"number": "150526"
											},
											{
												"value": "霍林郭勒市",
												"number": "150581"
											}
											]
										},
										{
											"value": "鄂尔多斯市",
											"number": "150600",
											"children": [
											{
												"value": "东胜区",
												"number": "150602"
											},
											{
												"value": "达拉特旗",
												"number": "150621"
											},
											{
												"value": "准格尔旗",
												"number": "150622"
											},
											{
												"value": "鄂托克前旗",
												"number": "150623"
											},
											{
												"value": "鄂托克旗",
												"number": "150624"
											},
											{
												"value": "杭锦旗",
												"number": "150625"
											},
											{
												"value": "乌审旗",
												"number": "150626"
											},
											{
												"value": "伊金霍洛旗",
												"number": "150627"
											}
											]
										},
										{
											"value": "呼伦贝尔市",
											"number": "150700",
											"children": [
											{
												"value": "海拉尔区",
												"number": "150702"
											},
											{
												"value": "扎赉诺尔区",
												"number": "150703"
											},
											{
												"value": "阿荣旗",
												"number": "150721"
											},
											{
												"value": "莫力达瓦达斡尔族自治旗",
												"number": "150722"
											},
											{
												"value": "鄂伦春自治旗",
												"number": "150723"
											},
											{
												"value": "鄂温克族自治旗",
												"number": "150724"
											},
											{
												"value": "陈巴尔虎旗",
												"number": "150725"
											},
											{
												"value": "新巴尔虎左旗",
												"number": "150726"
											},
											{
												"value": "新巴尔虎右旗",
												"number": "150727"
											},
											{
												"value": "满洲里市",
												"number": "150781"
											},
											{
												"value": "牙克石市",
												"number": "150782"
											},
											{
												"value": "扎兰屯市",
												"number": "150783"
											},
											{
												"value": "额尔古纳市",
												"number": "150784"
											},
											{
												"value": "根河市",
												"number": "150785"
											}
											]
										},
										{
											"value": "巴彦淖尔市",
											"number": "150800",
											"children": [
											{
												"value": "临河区",
												"number": "150802"
											},
											{
												"value": "五原县",
												"number": "150821"
											},
											{
												"value": "磴口县",
												"number": "150822"
											},
											{
												"value": "乌拉特前旗",
												"number": "150823"
											},
											{
												"value": "乌拉特中旗",
												"number": "150824"
											},
											{
												"value": "乌拉特后旗",
												"number": "150825"
											},
											{
												"value": "杭锦后旗",
												"number": "150826"
											}
											]
										},
										{
											"value": "乌兰察布市",
											"number": "150900",
											"children": [
											{
												"value": "集宁区",
												"number": "150902"
											},
											{
												"value": "卓资县",
												"number": "150921"
											},
											{
												"value": "化德县",
												"number": "150922"
											},
											{
												"value": "商都县",
												"number": "150923"
											},
											{
												"value": "兴和县",
												"number": "150924"
											},
											{
												"value": "凉城县",
												"number": "150925"
											},
											{
												"value": "察哈尔右翼前旗",
												"number": "150926"
											},
											{
												"value": "察哈尔右翼中旗",
												"number": "150927"
											},
											{
												"value": "察哈尔右翼后旗",
												"number": "150928"
											},
											{
												"value": "四子王旗",
												"number": "150929"
											},
											{
												"value": "丰镇市",
												"number": "150981"
											}
											]
										},
										{
											"value": "兴安盟",
											"number": "152200",
											"children": [
											{
												"value": "乌兰浩特市",
												"number": "152201"
											},
											{
												"value": "阿尔山市",
												"number": "152202"
											},
											{
												"value": "科尔沁右翼前旗",
												"number": "152221"
											},
											{
												"value": "科尔沁右翼中旗",
												"number": "152222"
											},
											{
												"value": "扎赉特旗",
												"number": "152223"
											},
											{
												"value": "突泉县",
												"number": "152224"
											}
											]
										},
										{
											"value": "锡林郭勒盟",
											"number": "152500",
											"children": [
											{
												"value": "二连浩特市",
												"number": "152501"
											},
											{
												"value": "锡林浩特市",
												"number": "152502"
											},
											{
												"value": "阿巴嘎旗",
												"number": "152522"
											},
											{
												"value": "苏尼特左旗",
												"number": "152523"
											},
											{
												"value": "苏尼特右旗",
												"number": "152524"
											},
											{
												"value": "东乌珠穆沁旗",
												"number": "152525"
											},
											{
												"value": "西乌珠穆沁旗",
												"number": "152526"
											},
											{
												"value": "太仆寺旗",
												"number": "152527"
											},
											{
												"value": "镶黄旗",
												"number": "152528"
											},
											{
												"value": "正镶白旗",
												"number": "152529"
											},
											{
												"value": "正蓝旗",
												"number": "152530"
											},
											{
												"value": "多伦县",
												"number": "152531"
											}
											]
										},
										{
											"value": "阿拉善盟",
											"number": "152900",
											"children": [
											{
												"value": "阿拉善左旗",
												"number": "152921"
											},
											{
												"value": "阿拉善右旗",
												"number": "152922"
											},
											{
												"value": "额济纳旗",
												"number": "152923"
											}
											]
										}
										]
									},
								]
						    </script>
						</label>
					</td>
				</tr>
				<tr>
					<td>下拉框+输入框</td>
					<td>
						<div class="flex-middle">
							<label class="ly_input_suffix mr_5px" ly-drop-select>
								<i>asdasdas</i>
								<input type="text" placeholder="输入框">
								<input type="hidden" name="name">
								<i class="lyicon-arrow-down-bold"></i>
							    <script type="text">
									[
										{
											value: "1"
										},
										{
											value: "2",
										}
									]
							    </script>
							</label>
							<label class="ly_input" style="flex:1">
								<textarea name="name" autoheight></textarea>
								<i class="lyicon-search"></i>
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td>范围</td>
					<td>
						<div class="flex-middle2 width300">
							<input class="ly_input" type="text" name="name" placeholder="￥">
							<i class="ml_10px mr_10px">-</i>
							<input class="ly_input" type="text" name="name" placeholder="￥">
						</div>
					</td>
				</tr>
				<tr>
					<td>输入框（小）</td>
					<td>
						<input class="ly_input width300" type="text" name="name" size="small" />
					</td>
				</tr>
				<tr>
					<td>输入框（迷你）</td>
					<td>
						<input class="ly_input width300" type="text" name="name" size="mini" />
					</td>
				</tr>
				<tr>
					<td>文本域</td>
					<td>
						<textarea class="ly_input" name="name" autoheight notenter>asdsdasdsdasdsdasdsdasdsdasdsdasdsdasdsdasdsdasdsdasdsdasdsdasdsdasds</textarea>
					</td>
				</tr>
				<tr>
					<td>文本域</td>
					<td>
						<textarea class="ly_input ly_not_border" name="name" autoheight notenter>ly_not_border 去掉了边框</textarea>
					</td>
				</tr>
				<tr>
					<td>文本域(90px)</td>
					<td>
						<label class="ly_input"><textarea size="default" name="name" autoheight></textarea></label>
					</td>
				</tr>
			</tbody>
		</table>
	</form>


</body>
</html>