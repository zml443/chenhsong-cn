<link rel="stylesheet" href="/themes/__/category/02/1.css" />
<script src="/themes/__/category/02/1.js"></script>

<style class="css-root-var">
	.ly_category_app_01_wrap{
		--appPaddingTop:<?=(int)$cfg['app_padding_top']?>px;
        --appPaddingBottom:<?=(int)$cfg['app_padding_bottom']?>px;
		--cur_color:<?=$cfg['font_color']?>;
		--bg_color:<?=$cfg['bg_type']?'var(--bgColor)':'#fff'?>;
	}
</style>
<?php
    if (!function_exists('products_01_subNav')) {
        function products_01_subNav($array,$index=0,$is_category=1) {
            if (!$array) {
                return '';
            }
            $html = '';
            $index++;
            foreach ($array as $k => $v) {
                $child = products_01_subNav($v['children'],$index).products_01_subNav($v['products_children'],$index, 0);
                $tongguo = ($child && $is_category) || !$is_category;
                if($tongguo) $html .= '
                        <div class="item '.($v['_cur_']?'cur':'').' '.($child?'':'not_child').' '.($v['_children_cur_']?'child_cur cur':'').'" data-key="key'.$index.'">
                            <a class="name" href="'.($is_category?'javascript:':$v['Href']).'">
                                <span>'.$v['Name'].'</span>
                                '.($child?'<i class="lyicon-arrow-right"></i>':'').'
                            </a>
                            <div class="children">'.$child.'</div>
                        </div>
                    ';
            }
            return $html;
        }
    }
?>



<?php if($cfg['category']){ ?>
    <div class="ly_category_app_01_wrap">
        <section class="ly_category_app_01" ly-sticky="top" data-zindex="10">
            <div class="clean">
                <div class="menu flex-middle2 pointer">
                    <div class="back pointer lyicon-zuojiantou"></div>
                    <span class="title" data-title="全部">全部</span>
                    <i class="menu_i lyicon-arrow-right-bold"></i>
                </div>
                <div class="ul hide pointer">
                    <div class="maxw maxvh1 scrollbar">
                        <?php echo products_01_subNav($cfg['category']); ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php } ?>