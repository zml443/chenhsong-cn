<?php
$navTwoId="media_Detail";
$query_string = url::query_string('m, a, CateId, Ext, page');

$detail = 'news';
$Keyword = (string)$_GET['keyword'];

if(!$Keyword){return false;}

$type_ary = array(
    'products'      =>  array(
                        'cn'   =>  '产品中心',
                        'en'   =>  'Products',
                        'table' =>  'wb_products',
                        'where' =>  "(Name like '%$Keyword%') and IsSaleOut != 1 and Language='{$c['lang']}'",
                        'select'=>  "*,Id as Id, 'products' as Type",
                        'field'	=>	'Name',
                    ),
    'blog'      =>  array(
                        'cn'   =>  '媒体中心',
                        'en'   =>  'News',
                        'table' =>  'wb_blog',
                        'where' =>  "(Name like '%$Keyword%') and IsSaleOut != 1 and Language='{$c['lang']}'",
                        'select'=>  "*,Id as Id, 'blog' as Type",
                        'field'	=>	'Name',
                    ),
    'industry'      =>  array(
                        'cn'   =>  '行业方案',
                        'en'   =>  'Industry Solutions',
                        'table' =>  'wb_industry',
                        'where' =>  "(Name like '%$Keyword%') and Language='{$c['lang']}'",
                        'select'=>  "*,Id as Id, 'industry' as Type",
                        'field'	=>	'Name',
                    ),
    'download'      =>  array(
                        'cn'   =>  '下载专区',
                        'en'   =>  'Download',
                        'table' =>  'wb_blog_download',
                        'where' =>  "(Name like '%$Keyword%') and Language='{$c['lang']}'",
                        'select'=>  "*,Id as Id, 'download' as Type",
                        'field'	=>	'Name',
                    ),
    'announcements'      =>  array(
                        'cn'   =>  '最新公告',
                        'en'   =>  'Announcements',
                        'table' =>  'wb_invest_announcements',
                        'where' =>  "(Name like '%$Keyword%') and Language='{$c['lang']}'",
                        'select'=>  "*,Id as Id, 'announcements' as Type",
                        'field'	=>	'Name',
                    ),
);

// $page_count = 9;
// $row_count = 0;
foreach ($type_ary as $k=>$v) {
	$type_ary[$k]['id'] = $v['id'] ? $v['id'] : 'Id';
	$type_ary[$k]['table'] = $v['table'] ? $v['table'] : 'wb_news';
	$type_ary[$k]['count'] = db::get_row_count($type_ary[$k]['table'], $where . $v['where']);
	$row_count += $type_ary[$k]['count'];
}
// $total_pages = ceil($row_count / $page_count);
// $page = $_GET['pg']?(int)$_GET['pg']:1;
// ($page<1 || $page>$total_pages) && $page=1;
// $start_row = ($page-1) * $page_count;

/*
 * 开始查询
 * 
**/
$search_ary = array();
foreach ($type_ary as $k => $v) {
	// if ($page_count == 0){
	// 	break;
	// }
	// if ($v['count'] == 0) {
	// 	continue;
	// }
	// if ($start_row >= $v['count']) {
	// 	$start_row -= $v['count'];
	// 	continue;
	// }
	$search_ary = array_merge(
		$search_ary,
		db::get_all($v['table'], $where . $v['where'], $v['select'], $v['order']?$v['order']:"AddTime desc")
	);
}
?><!DOCTYPE html>
<html lang="zh-cn" class="scrollbar">
<?php include 'inc/style_script.php'; ?>
<body>
<div body f56a>
	<?php include 'inc/header.php'; ?>

	<section id="search">
		<div class="cw1600">
			<div class="blank15"></div>
			<div class="form">
				<form action="/search/" method="get" name="all_search" class="search_form">
					<div class="text-center fz0">
						<input type="text" class="text inline-block" id="key" name="keyword" value="<?=htmlspecialchars($Keyword);?>" placeholder="<?=l('请输入关键词','Enter keyword'); ?>..."/>		
						<label class="submit pointer inline-block m-pic trans">
							<img src="/images/icon/search.svg" class="svg" alt="">
							<input type="submit" value="" class="hide">
						</label>
					</div>
					<div class="clear"></div>
				</form>
			</div>
			<div class="list">
				<?php if($search_ary) {?>
					<ul class="info news">
					<?php 
					foreach((array)$search_ary as $k=>$v){
						if($v['Type']=='products'){
							$url=url::set($v,'wb_products.detail');
						}elseif($v['Type']=='blog'){
							$url= $v['Url'] ? $v['Url'] : url::set($v, 'wb_blog.detail');
						}elseif($v['Type']=='industry'){
							$url=url::set($v, 'wb_industry.detail');
						}
					?>
                        <?php if($v['Type']=='download') { ?>
                            <li class="trans5">
                                <div onclick="file.down(<?=$v['Id']; ?>)" class="title inline-block trans pointer"><?=$v[$type_ary[$v['Type']]['field']]?></div>
                                <div class="cate inline-block">(<?=$type_ary[$v['Type']][$c['lang']]?>)</div>
                                <div class="inline-block day"><?=date('Y.m.d', $v['AddTime'])?></div>
                            </li>
                        <?php } else if($v['Type'] == 'announcements'){ ?>
                            <li class="trans5">
                                <a href="<?=img::get($v['File']); ?>" target="_blank" class="title inline-block trans"><?=$v[$type_ary[$v['Type']]['field']]?></a>
                                <div class="cate inline-block">(<?=$type_ary[$v['Type']][$c['lang']]?>)</div>
                                <div class="inline-block day"><?=date('Y.m.d', $v['AddTime'])?></div>
                            </li>
                        <?php } else {?>
                            <li class="trans5">
                                <a href="<?=$url?>"  <?=$v['Url'] ?"target='_blank'":''; ?> target="_blank" class="title inline-block trans"><?=$v[$type_ary[$v['Type']]['field']]?></a>
                                <div class="cate inline-block">(<?=$type_ary[$v['Type']][$c['lang']]?>)</div>
                                <div class="inline-block day"><?=date('Y.m.d', $v['AddTime'])?></div>
                            </li>
                        <?php }?>
					<?php }?>
					</ul>
					<div class="blank25"></div>
				<?php } else { ?>
                    <div class="not_tip blog blank25 cw1600" wow="fadeInUp"><?=l('暂时没有相关内容，敬请期待！','There is currently no relevant content, please stay tuned!');?></div>
				<?php }?>
			</div>
		</div>
	</section>

	<!-- 导入底部文件 -->
	<?php include 'inc/footer.php'; ?>
    <?php include 'inc/down-pop.php';?>
</div>
</body>
</html>