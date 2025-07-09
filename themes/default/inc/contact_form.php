<?php 
if(c('lang') == 'en') {
    $form_address = db::get_all('wb_address_country','Dept = 1','Name_en', 'MyOrder asc, Id asc');
}else{
    $form_address = db::get_all('wb_address','Dept = 1','Name_cn', 'MyOrder asc, Id asc');
}
$form_area = db::get_all('wb_feedback_area','1','*', 'MyOrder asc, Id asc');
?>

<section id="contact_form" class="<?=$navId=='products'?'back':'';?>">
    <div class="content cw1600">
        <div class="top" wow="fadeInUp">
            <div class="title"><?=l('联系我们','Contact Us'); ?></div>
            <div class="brief"><?=l('把您的需求告诉我们，我们会尽快与您联系。','Tell us your needs and we will contact you as soon as possible.'); ?></div>
        </div>

        <form feedback class="form over" autocomplete="off">
            <div class="ul flex-wrap flex-between">
                <div class="li" wow="fadeInUp">
                    <div class="p1"><?=l('您的称呼','Your Name'); ?><span></span></div>
                    <div class="box relative">
                        <label>
                            <input type="text" class="inp block trans" name="Name" placeholder="<?=l('请输入','Enter'); ?>" check-val="<?=l('请输入您的姓名','Please enter your name'); ?>" />
                        </label>
                        <div class="sex flex">
                            <label class="radio">
                                <input type="radio" name="Sex" value="man" check-number="1,<?=l('请选择性别','Please Select Gender')?>"/><?=l('先生','Mr.')?>
                            </label>
                            <label class="radio">
                                <input type="radio" name="Sex" value="woman" /><?=l('女士','Ms.')?>
                            </label>
                        </div>
                    </div>
                </div>

                <label class="li" wow="fadeInUp">
                    <div class="p1"><?=l('电话号码','Phone Number'); ?><span></span></div>
                    <input type="text" class="inp block trans" name="Phone" placeholder="<?=l('请输入','Enter'); ?>" check-val="<?=l('请输入您的电话号码','Please enter your phone number'); ?>" <?=l('check-mobile="{{val}}不是正确的电话号码"','')?>  />
                </label>
                
                <div id="sel_ind" class="li selectBox" wow="fadeInUp">
                    <div class="p1"><?=l('国家/地区','Country/Region')?></div>
                    <div class="select relative">
                        <div class="inp tit1 pointer trans">
                            <input readonly type="text" class="ind tit maxw maxh block trans" placeholder="<?=l('请选择','Please select'); ?>" name="Country" value="" check-val="<?=l('请选择你的国家/地区','Please select your country/region'); ?>"/> 
                        </div>

                        <div class="two-box hide">
                            <div class="cont trans">
                                <?php foreach((array)$form_address as $k => $v){?>
                                    <label class="ist flex relative pointer">
                                        <input type="radio" class="opt checkbox block" name="Country" value="<?=$v[ln('Name')]; ?>"/>
                                        <span class="fonts"><?=$v[ln('Name')]; ?></span>
                                    </label>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>

                <label class="li" wow="fadeInUp">
                    <div class="p1"><?=l('邮箱','Email'); ?><span></span></div>
                    <input type="text" class="inp block trans" name="Email" placeholder="<?=l('请输入','Enter'); ?>" check-val="<?=l('请输入您的邮箱','Please enter your email address'); ?>" check-email="{{val}}<?=l('不是正确的邮箱地址','Not the correct email address')?>" />
                </label>

                <label class="li" wow="fadeInUp">
                    <div class="p1"><?=l('所在城市','City'); ?><span></span></div>
                    <input type="text" class="inp block trans" name="Address" placeholder="<?=l('请输入','Enter'); ?>" check-val="<?=l('请输入您所在的城市','Please enter your city'); ?>" />
                </label>

                <div id="sel_ind" class="li selectBox" wow="fadeInUp">
                    <div class="p1"><?=l('关注领域','Focus Areas')?></div>
                    <div class="select relative">
                        <div class="inp tit1 pointer trans">
                            <input readonly type="text" class="tit ind maxw maxh block trans" placeholder="<?=l('请选择','Please select'); ?>" name="Areas" value=""/> 
                        </div>

                        <div class="two-box hide">
                            <div class="cont trans">
                                <?php foreach((array)$form_area as $k => $v){?>
                                    <label class="ist flex relative pointer">
                                        <input type="checkbox" class="opt checkbox block" name="Areas[]" value="<?=$v[ln('Name')]; ?>"/>
                                        <span class="fonts"><?=$v[ln('Name')];?></span>
                                    </label>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <label class="mes block" wow="fadeInUp">
                <div class="p1"><?=l('留言信息','Message information'); ?><span></span></div>
                <textarea class="text block trans" type="text" name="Message" placeholder="<?=l('请输入','Enter'); ?>" check-val="<?=l('请输入留言信息','Please enter the message information'); ?>"></textarea>
            </label>

            <label class="li block codeLi relative" wow="fadeInUp">
                <div class="p1"><?=l('验证码','Code'); ?><span></span></div>
                <div class="flex-middle2">
                    <input type="text" class="inp block trans" name="VCode" placeholder="<?=l('请输入','Enter'); ?>" check-val="<?=l('验证码不能为空','The verification code cannot be empty')?>" />
                    <div class="code i-pic over" code-word='contact'></div>
                </div>
            </label>

            <label class="state flex relative" wow="fadeInUp">
                <input type="radio" name="Statement" value="yes" class="checkbox pointer" checked />
                <span class="fonts"><?=l('本人特此声明，同意贵司处理以上本人提供的个人数据。','I hereby declare that I agree to your company processing the personal data provided by me.'); ?></span>
            </label>

            <input type="hidden" name="From" value="<?=$navId; ?>" />
            <label class="sub block trans pointer" wow="fadeInUp">
                <input type="submit" value="<?=l('提交信息','Submit'); ?>" class="submit block pointer" />
            </label>
        </form>
    </div>
</section>