<?php
function_exists('c')||exit();

$page_row = db::result("select * from wb_site_page_copy where Id='{$_GET['Id']}'");
// $page_row = db::result("select * from wb_site_page_copy where Id='1'");
if (!$page_row) {
	exit('[]');
}


$module_type = array(
	array(
		'value' => 'all',
		'label' => '全部',
		'ico' => '',
	),
	array(
		'value' => 'pictures',
		'label' => '图文橱窗',
		'ico' => 'lyicon-picture',
	),
	array(
		'value' => 'server',
		'label' => '行业服务',
		'ico' => '',
	),
	array(
		'value' => 'about',
		'label' => '关于我们',
		'ico' => '',
	),
	array(
		'value' => 'history',
		'label' => '发展历程',
		'ico' => 'lyicon-task',
	),
	array(
		'value' => 'contact-us',
		'label' => '联系我们',
		'ico' => '',
	),
	array(
		'value' => 'join,join-detail',
		'label' => '人才招聘',
		'ico' => 'lyicon-yonghu',
	),
	array(
		'value' => 'feedback',
		'label' => '留言',
		'ico' => 'lyicon-customer-service',
	),
	array(
		'value' => 'faq',
		'label' => '常见问题',
		'ico' => '',
	),
	array(
		'value' => 'download,download-detail',
		'label' => '下载',
		'ico' => 'lyicon-download',
	),
	array(
		'value' => 'comment',
		'label' => '点评',
		'ico' => 'lyicon-comment',
	),
	array(
		'value' => 'partner',
		'label' => '合作伙伴',
		'ico' => '',
	),
	array(
		'value' => 'product,product-detail,product-else',
		'label' => '产品',
		'ico' => 'lyicon-layers',
	),
	array(
		'value' => 'product-comment',
		'label' => '产品评论',
		'ico' => '',
	),
	array(
		'value' => 'product-countdown',
		'label' => '倒计时产品',
		'ico' => '',
	),
	array(
		'value' => 'branches,branches-detail',
		'label' => '公司&门店',
		'ico' => '',
	),
	array(
		'value' => 'blog,blog-detail,blog-else',
		'label' => '博客新闻',
		'ico' => '',
	),
	array(
		'value' => 'case,case-detail,case-else',
		'label' => '案例',
		'ico' => '',
	),
	array(
		'value' => 'team,team-detail,team-else',
		'label' => '团队',
		'ico' => 'lyicon-xiaozu',
	),
	array(
		'value' => 'solution,solution-detail,solution-else',
		'label' => '解决方案',
		'ico' => '',
	),
	array(
		'value' => 'video,video-detail,video-else',
		'label' => '视频',
		'ico' => '',
	),
	array(
		'value' => 'code',
		'label' => '自定义代码',
		'ico' => 'lyicon-code',
	),
	array(
		'value' => 'carousel',
		'label' => '普通轮播',
		'ico' => '',
	),
	array(
		'value' => 'banner',
		'label' => '广告图',
		'ico' => '',
	),
	array(
		'value' => 'crumb,category',
		'label' => '面包屑',
		'ico' => '',
	),
	array(
		'value' => 'editor',
		'label' => '页面详情',
		'ico' => '',
	),
	array(
		'value' => 'other',
		'label' => '其他',
		'ico' => '',
	),
);



$global_str = "'other', 'crumb', 'pictures', 'banner', 'video', 'newsletter', 'code', 'editor', 'faq', 'feedback'";
$where = "IsUsed=1 and PersonalExclusive=''";
if ($_GET['parts_name']) {
	$where .= " and Parts='{$_GET['parts_name']}'";
} else {
	$where .= " and Parts='content'";
}

if ($_GET['parts_name']=='header') { //首页查询方式
	// $where .= " and Type='header'";

} else if ($_GET['parts_name']=='footer') { //首页查询方式
	// $where .= " and Type='footer'";

} else if ($page_row['Type']=='index') { //首页查询方式
	$where .= " and (PageType='index' or Type in($global_str, 'partner','history'))";

} else { //内页查询方式
	$global_str .= ", 'category'";
	$where .= " and PageType='inner'";
	switch ($page_row['Type']) {
		// 案例
		case 'case':
			$where .= " and Type in($global_str, 'case', 'category')";
			break;
		case 'case-detail':
			$where .= " and Type in($global_str, 'case-detail', 'blog-else')";
			break;
		// 博客
		case 'branches':
			$where .= " and Type in($global_str, 'branches', 'category')";
			break;
		case 'branches-detail':
			$where .= " and Type in($global_str, 'branches-detail')";
			break;
		// 博客
		case 'solution':
			$where .= " and Type in($global_str, 'solution')";
			break;
		case 'solution-detail':
			$where .= " and Type in($global_str, 'solution-detail', 'case-else', 'solution-else', 'product-else', 'download-else', 'server-else')";
			break;
		// 博客
		case 'server':
			$where .= " and Type in($global_str, 'server')";
			break;
		case 'server-detail':
			$where .= " and Type in($global_str, 'server-detail', 'case-else', 'server-else', 'product-else', 'download-else', 'server-else')";
			break;
		// 博客
		case 'blog':
			$where .= " and Type in($global_str, 'blog', 'category')";
			break;
		case 'blog-detail':
			$where .= " and Type in($global_str, 'blog-detail', 'case-else', 'solution-else', 'product-else', 'download-else', 'server-else')";
			break;
		// 下载
		case 'download':
			$where .= " and Type in($global_str, 'download', 'category')";
			break;
		case 'download-detail':
			$where .= " and Type in($global_str, 'download-detail', 'case-else', 'solution-else', 'product-else', 'server-else')";
			break;
		// 产品
		case 'products':
			$where .= " and Type in($global_str, 'product', 'category')";
			break;
		case 'products-detail':
			$where .= " and Type in($global_str, 'product-detail', 'product-comment', 'product-else', 'case-else', 'solution-else')";
			break;
		// 团队
		case 'team':
			$where .= " and Type in($global_str, 'team', 'category')";
			break;
		case 'team-detail':
			$where .= " and Type in($global_str, 'team-detail')";
			break;
		// 联系我们
		case 'contact-us':
			$where .= " and Type in($global_str, 'contact-us')";
			break;
		// 联系我们
		case 'about':
			$where .= " and Type in($global_str, 'about', 'partner', 'history')";
			break;
		// 常见问题
		case 'faq':
			$where .= " and Type in($global_str, 'faq')";
			break;
		// 常见问题
		case 'join':
			$where .= " and Type in($global_str, 'join')";
			break;
		
		default:
			$where .= " and Type in($global_str, 'about', 'history', 'partner')";
			break;
	}
}
if ($_GET['type']) {
	$where .= " and Type='{$_GET['type']}'";
}

$res = lydb::query("select * from ss_module where $where");
$row = array();
while ($v = lydb::result($res)) {
	$v['Picture'] = '/module/'.$v['Number'].'/pc.jpg';
	if (!is_file(c('root').$v['Picture'])) {
		$v['Picture'] = '';
	}
	$row[] = $v;
}
// exit(str::json($row));



?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<?php include '__/inc/style_script.php'; ?>
</head>

<style>
html,body{background: none;}
.zmlmodule_body{height: 100vh;width: 100vw;padding: 25px 50px;}
.zmlmodule_box{width: calc(100vw - 100px);height: calc(100vh - 50px);border-radius: 10px;background: rgba(255,255,255,.9);}
.zmlmodule_title{position: sticky;top: 0;left: 0;right: 0;padding: 50px 0;background: rgba(255,255,255,.9);z-index: 5;}
.zmlmodule_title_name{font-size: 36px;}
.zmlmodule_title_btn{height: 36px;width: 300px;background: var(--mainColor);color: #fff;padding: 0 20px;border-radius: 4px;position: relative;margin-right: 20px;}
.zmlmodule_title_drop{width: 500px;}
.zmlmodule_con{height: 100%;padding: 0 0 30px;overflow: scroll;}
.zmlmodule_close{position: absolute;z-index: 9;font-size: 40px;right: 30px;top: 52px;cursor: pointer;}

.module_preview2{margin:20px 20px 10px 0; width:calc(50% - 20px); position:relative;}
.module_preview2 .ifr{min-height:100px; overflow-y:auto; border-radius:5px; border:1px solid #ccc; background-color:#fff; cursor:pointer; font-size:0;}
.module_preview2 .btn{position:absolute; left:0; top:0; right:0; bottom:0; opacity:0; transition:.3s; background-color:rgba(0,0,0,.3);}
.module_preview2:hover .btn{opacity:1;}

.module_type_li{width: calc((100% - (4 * 5px)) / 5);margin-left: 5px;margin-top: 5px;background: #f5f7f9;transition: .3s;}
.module_type_li:nth-child(-n+5){margin-top: 0;}
.module_type_li:nth-child(5n+1){margin-left: 0;}
.module_type_li .ico{height: 70px;font-size: 34px;}
.module_type_li .nam{font-size: 12px;color: #999; height: 60px}
.module_type_li:not(.disabled):hover{color: #fff;background: var(--mainColor)}
.module_type_li:not(.disabled):hover .nam{color: #fff;}
.module_type_li.disabled,
.module_type_li.not-event{background: #ddd;}

@media screen and (max-width:1500px){
	.zmlmodule_title_btn{margin-right: 90px;}
}
</style>

<body>
<div class="zmlmodule_body">
	
	<div class="fixed max at-close"></div>

	<div class="zmlmodule_box relative over">

		<div class="zmlmodule_close at-close lyicon-guanbi"></div>
		<div class="at-confirm"></div>
		
		<div class="zmlmodule_con relative scrollbar">
			<div class="zmlmodule_title">
				<div class="flex-max2" cw="1200">
					<div class="zmlmodule_title_name flex-1"><?=language('{/panel.change_like_mdl/}')?></div>
					<!-- end -->
					<div class="zmlmodule_title_btn flex-btn relative zIndex9 pointer fr" placement="bottom-start">
						<div class="ly_drop_right">
							<div class="flex-wrap zmlmodule_title_drop">
								<?php foreach ($module_type as $k => $v) { ?>
									<div class="module_type_li" onclick="modules.search(this)" data-type="<?=$v['value']?>">
										<div class="ico hide flex-max2"></div>
										<div class="nam flex-max2"><?=$v['label']?></div>
									</div>
								<?php } ?>
							</div>
						</div>
						<!--  -->
						<div class="flex-1"><?=language('{/global.all/}')?></div>
						<i class="down lyicon-arrow-down-bold"></i>
					</div>
					<!-- end -->
				</div>
			</div>
			<!-- end -->
			<section class="zmlmodule_masonry flex-wrap flex-max2" cw="1200" ly-masonry=".module_preview2" data-width="50%">
				<script id="zmlmoJson" type="text"><?=str::json($row)?></script>
			</section>
		</div>

	</div>

</div>
</body>
</html>

<script>
	var returnResult = 0;
	var modules = {
		init(){
			this.data = $('#zmlmoJson').json();
			this.lis();
			this.check();
		},
		check(){
			var type = {all:1};
			this.data.map(v=>{
				type[v.Type] = 1;
			});
			$('.zmlmodule_title_drop .module_type_li').each(function(){
				var el = $(this);
				var x = 1;
				var t = el.attr('data-type').split(',');
				for (var v of t) {
					if (v && type[v]) {
						x = 0;
						break;
					}
				}
				if (x) el.addClass('disabled');
			});
		},
		// 搜索
		_search:{
			type: '',
		},
		search(el){
			el = $(el);
			this._search.type = el.attr('data-type'); 
			this.lis();
		},
		limit: 0,
		lis(){
			var el = $('.zmlmodule_masonry');
			var html = this.data.map(v=>{
				if (this._search.type && this._search.type!='all') {
					var t = this._search.type.split(',');
					// var back = v.Type!=;
					if (!this._search.type.includes(v.Type)) return '';
				}
				return `
					<div class="module_preview2">
						<div class="name mb_10px">${v.Number} * ${v.Type}</div>
						<div class="relative">
							<div class="ifr"><img class="maxw" data-src="${v.Picture}" /></div>
							<div class="btn flex-max2">
								<div class="ly_btn_radius qiehuanmoban pointer2" bg="main" onclick="modules.confirm(this)" data-id="${v.Id}">${$.lang.panel.select_mdl}</div>
							</div>
						</div>
					</div>
				`
			}).join('');
			if (el.is('.isok')) el.masonry_html(html);
			else el.html(html);
		},
		// 搜索end
		// 确认选择
		confirm(el){
			returnResult = $(el).attr('data-id');
			$('.at-confirm').trigger('click');
		}
	}
	modules.init();
</script>