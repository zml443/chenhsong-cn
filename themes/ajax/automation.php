<?php 
$CateId = (int)$_POST['id'];

$where = "Language='{$c['lang']}'";
$CateId && $where .= " and wb_automation_category_id = '{$CateId}'";
$pg = (int)$_GET['pg'];
$page_list = db::get_limit_page('wb_factory_automation', $where,'*',db::get_order_by('new','wb_factory_automation'),$pg, 6,
	array(
		'prev' => '<div class="pn box m-pic trans l"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
		'next' => '<div class="pn box m-pic trans r"><img src="/images/pn.svg" alt="" class="svg trans"></div>',
		)
	);
if($pg>$page_list['total_page']){return false;}
?>
<div class="content" wow='fadeInUp'>
    <?php foreach((array)$page_list['row'] as $k => $v) {
        $pic = str::json($v['Picture'], 'decode');
    ?>
        <div class="list" wow='fadeInUp'>
            <div class="word">
                <div class="name"><?=$v['Name']; ?></div>
                <div class="ul">
                    <div class="li">
                        <div class="tit"><?=l('核心价值','Core Values'); ?>：</div>
                        <div class="brief"><?=nl2br($v['BriefDescription']); ?></div>
                    </div>
                    <div class="li">
                        <div class="tit"><?=l('技术特点','Technical Characteristics'); ?>：</div>
                        <div class="brief"><?=nl2br($v['Point']); ?></div>
                    </div>
                </div>
            </div>
            <div class="img m-pic b-pic"><img src="<?=img::get($pic[0]['path']);?>" alt="<?=$pic[0]['alt']; ?>"  title="<?=$pic[0]['title']; ?>" class="max absolute" /></div>
        </div>
    <?php }?>
</div>

<?php if($page_list['total_page']>1){?>
<div id="page" wow='fadeInUp'>
    <a href="?pg=1" class="pn end box m-pic block trans l"><img src="/images/pn-end.svg" alt="" class="svg trans"></a>	

    <?=$page_list['html'];?>

    <a href="?pg=<?=$page_list['total_page']?>" class="pn end box m-pic block trans r"><img src="/images/pn-end.svg" alt="" class="svg trans"></a>
</div>
<?php }?>