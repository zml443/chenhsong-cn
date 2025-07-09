<?php 
$invest_contact = db::get_one('wb_invest_contact',"1",'*');
$invest_contact_data = str::json($invest_contact['Data'], 'decode');
?>
<section id="invest_contact" class="contact over">
    <div class="box flex-wrap flex-between">
        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('主要股份过户登记处','Main share transfer registration office')?></div>
            <div class="ul">
                <div class="li"><?=nl2br($invest_contact['Info']); ?></div>
            </div>
        </div>

        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('企业传讯及投资者关系','Corporate Communications and Investor Relations')?></div>
            <div class="ul">
                <?php 
                $str = nl2br($invest_contact[ln('Info5')]);
                $lines = explode('<br />', $str);
                foreach($lines as $line){
                    echo "<div class='li'>$line</div>";
                }
                ?>
            </div>
        </div>

        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('股份过户登记分处','Share Transfer Registration Branch')?></div>
            <div class="ul">
                <div class="li"><?=nl2br($invest_contact[ln('Info2')]);?></div>
            </div>
        </div>

        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('股票代号','Stock Code'); ?></div>
            <div class="ul">
                <div class="li"><?=$invest_contact['Name']; ?></div>
            </div>
        </div>
        
        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('注册办事处','Registered Office')?></div>
            <div class="ul">
                <div class="li"><?=nl2br($invest_contact['Info3']);?></div>
            </div>
        </div>

        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('相关职权范围','Relevant scope of authority')?></div>
            <div class="ul">
                <div class="sel_box relative">
                    <div class="p1 trans"><?=l('选择','Select')?></div>
                    <div class="p2 absolute hide">
                        <?php foreach((array)$invest_contact_data as $item) {?>
                            <a href="<?=$item['url']?$item['url']:'javascript:;';?>" class="li block trans">
                                <?=nl2br($item[ln('name')]); ?>
                            </a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="item" wow="fadeInUp">
            <div class="tit"><?=l('总办事处及主要营业地点','General Office and Main Place of Business')?></div>
            <div class="ul">
                <div class="li"><?=nl2br($invest_contact[ln('Info4')]);?></div>
            </div>
        </div>
    </div>
</section>
<?/*?>
<style>
#invest_contact{padding: 43px 6.5% 62px; background: #fff;}
#invest_contact .title{}
#invest_contact .code{margin-top: 30px; padding: 30px 0; font-size: 18px; color: #333; line-height: 26px; border-top: 1px solid #e8e8e8; }
#invest_contact .code span{color: var(--color2);}
#invest_contact .list{}
#invest_contact .list .l1{border-top: 1px solid #e8e8e8;}
#invest_contact .list .l1 .item{padding: 36px 0; width: 24.16%;}
#invest_contact .list .l1 .item .tit{font-size: 18px; color: #333; font-weight: 500; line-height: 36px; }
#invest_contact .list .l1 .item .ul{margin-top: 8px;}
#invest_contact .list .l1 .item .ul .li{font-size: 16px; color: #999; line-height: 30px;}
#invest_contact .list .l1 .item .ul a:hover{color: var(--color2);}
</style>
<div id="invest_contact" class="contact over">
    <div id="inv_title" class="title" wow="fadeInUp"><?=l('投资者联系','Investor Contact'); ?></div>

    <div class="code" wow="fadeInUp">
        <?=l('股票代码','Stock Code'); ?>：<span><?=$invest_contact['Name']; ?></span>
    </div>

    <div class="list">
        <div class="l1 flex-between">
            <div class="item" wow="fadeInUp">
                <div class="tit"><?=l('主要股份过户登记处','Main share transfer registration office')?></div>
                <div class="ul">
                    <div class="li"><?=$invest_contact['Info']; ?></div>
                </div>
            </div>

            <div class="item" wow="fadeInUp">
                <div class="tit"><?=l('股份过户登记分处','Share Transfer Registration Branch')?></div>
                <div class="ul">
                    <div class="li"><?=nl2br($invest_contact[ln('Info2')]);?></div>
                </div>
            </div>

            <div class="item" wow="fadeInUp">
                <div class="tit"><?=l('注册办事处','Registered Office')?></div>
                <div class="ul">
                    <div class="li"><?=nl2br($invest_contact['Info3']);?></div>
                </div>
            </div>
        </div>

        <div class="l1 flex-between">
            <div class="item" wow="fadeInUp">
                <div class="tit"><?=l('总办事处及主要营业地点','General Office and Main Place of Business')?></div>
                <div class="ul">
                    <div class="li"><?=nl2br($invest_contact[ln('Info4')]);?></div>
                </div>
            </div>

            <div class="item" wow="fadeInUp">
                <div class="tit"><?=l('企业传讯及投资者关系','Corporate Communications and Investor Relations')?></div>
                <div class="ul">
                    <?php 
                    $str = nl2br($invest_contact[ln('Info5')]);
                    $lines = explode('<br />', $str);
                    foreach($lines as $line){
                        echo "<div class='li'>$line</div>";
                    }
                    ?>
                </div>
            </div>

            <div class="item" wow="fadeInUp">
                <div class="tit"><?=l('相关职权范围','Relevant scope of authority')?></div>
                <div class="ul">
                    <?php foreach((array)$invest_contact_data as $item) {?>
                    <a href="<?=$item['url']?$item['url']:'javascript:;';?>" class="li block trans"><?=nl2br($item[ln('name')]); ?></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<?*/?>