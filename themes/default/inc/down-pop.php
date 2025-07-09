<section id="download-pup">
    <div class="info">
        <div class="content cw1200">
            <div class="title"><?=l('我要下载','I Want To Download')?></div>
            <div class="tip"><?=l('填写您的信息，我们会将您需要的资料发送到邮箱。','Fill in your information and we will send the information you need to your email.')?></div>
            <form feedback_download class="form" autocomplete="off">
                <div class="li">
                    <div class="box">
                        <div class="text"><?=l('您的称呼','Your Name')?></div>
                        <div class="input name">
                            <input type="text" name="Name" placeholder="<?=l('请输入','Enter')?>" check-val="<?=l('请输入您的姓名','Please enter your name'); ?>">
                            <div class="radio">
                                <label class="item">
                                    <input type="radio" name="Sex" class="hide" check-number="1,<?=l('请选择性别','Please Select Gender')?>" value="man"/>
                                    <div class="round trans"></div>
                                    <?=l('先生','Mr.')?>
                                </label>
                                <label class="item">
                                    <input type="radio" name="Sex" class="hide" value="woman"/>
                                    <div class="round trans"></div>
                                    <?=l('女士','Ms.')?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="text"><?=l('电话号码','Phone Number')?></div>
                        <div class="input">
                            <input type="text" name="Phone" placeholder="<?=l('请输入','Enter')?>" <?=l('check-mobile="{{val}}不是正确的电话号码"','')?> check-val="<?=l('请输入您的电话号码','Please enter your phone number'); ?>">
                        </div>
                    </div>
                </div>

                <div class="li">
                    <div class="box">
                        <div class="text"><?=l('国家/地区','Country/Region')?></div>
                        <div class="input choose">
                            <div class="top">
                                <input type="text" class="trans" name="Country" readonly check-val="<?=l('国家/地区不能为空','Country/region cannot be empty')?>"  placeholder="<?=l('请选择','Please select')?>"/>
                                <div class="icon trans m-pic"><img src="/images/industry/pn.svg" class="cur" alt="" /></div>
                            </div>
                            <div class="out">
                                <?php foreach((array)$form_address as $k => $v){?>
                                    <div class="list trans"><?=$v[ln('Name')]; ?></div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="text"><?=l('邮箱','Email')?></div>
                        <div class="input">
                            <input type="text" name="Email" placeholder="<?=l('请输入','Enter')?>" check-val="<?=l('请输入您的邮箱','Please enter your email address'); ?>" check-email="{{val}}<?=l('不是正确的邮箱地址','Not the correct email address')?>">
                        </div>
                    </div>
                </div>

                <div class="li">
                    <div class="box">
                        <div class="text"><?=l('所在城市','City')?></div>
                        <div class="input">
                            <input type="text" name="Address" placeholder="<?=l('请输入','Enter')?>"  check-val="<?=l('请输入您所在的城市','Please enter your city')?>">
                        </div>
                    </div>
                    <div class="box">
                        <div class="text"><?=l('关注领域','Focus Areas')?></div>
                        <div class="input">
                            <input type="text" name="Areas" placeholder="<?=l('请输入','Enter')?>"  check-val="<?=l('关注领域不能为空','The focus area cannot be empty')?>">
                        </div>
                    </div>
                </div>

                <div class="li other">
                    <div class="text"><?=l('留言信息','Message information')?></div>
                    <textarea class="textarea" name="Message" placeholder="<?=l('请输入','Enter')?>"  check-val="<?=l('请输入留言信息','Please enter the message information'); ?>"></textarea>
                </div>

                <div class="li other">
                    <div class="text"><?=l('验证码','Code')?></div>    
                    <div class="codebox">
                        <input type="text" class="input" name="VCode" placeholder="<?=l('请输入','Enter')?>" check-val="<?=l('验证码不能为空','The verification code cannot be empty')?>">
                        <div class="code" code-word='download'></div>
                    </div>
                </div>
                <label class="state flex relative" _wow="fadeInUp">
                    <input type="radio" name="Statement" value="yes" class="checkbox pointer" checked />
                    <span class="fonts"><?=l('本人特此声明，同意贵司处理以上本人提供的个人数据。','I hereby declare that I agree to your company processing the personal data provided by me.'); ?></span>
                </label>

                <input type="hidden" name="wb_download_id" value="" />
                
                <label class="btn block" _wow='fadeInUp'>
                    <?=l('提交信息','Submit')?>
                    <input type="submit" class="hide" value="">
                </label>
                <div class="close m-pic"><img src="/images/download/icon.svg" alt=""></div>
            </form>
        </div>
    </div>
</section>