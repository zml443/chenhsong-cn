<link rel="stylesheet" href="/themes/__/category/01/1.css" />
<script src="/themes/__/category/01/1.js"></script>

<style class="css-root-var">
	.ly_category_app_01_wrap{
		--appPaddingTop:<?=(int)$cfg['app_padding_top']?>px;
        --appPaddingBottom:<?=(int)$cfg['app_padding_bottom']?>px;
		--cur_color:<?=$cfg['font_color']?>;
		--bg_color:<?=$cfg['bg_type']?'var(--bgColor)':'#fff'?>;
	}
</style>

<?php if($cfg['category']){ ?>
    <div class="ly_category_app_01_wrap">
        <section class="ly_category_app_01" ly-sticky="top" data-zindex="10">
            <div class="clean">
                <div class="menu flex-middle2">
                    <span class="title">全部</span>
                    <i class="menu_i lyicon-arrow-right-bold"></i>
                </div>
                <div class="ul hide">
                    <div class="maxw maxvh1 scrollbar">
                        <?php foreach($cfg['category'] as $k => $v){ ?>
                            <a class="li flex-middle2 <?=$v['_children_cur_']||$v['_cur_']?'cur':''?>" href="<?=$v['Href']?>" data-name="<?=$v['Name']?>">
                                <?=$v['Name']?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php } ?>


<script>
// 移动端 分类选中标题更换
(function(){
	let cur = $('.ly_category_app_01 .ul .li.cur').attr('data-name')
	if(cur){
		$('.ly_category_app_01 .menu .title').html(cur)
	}
})()
</script>