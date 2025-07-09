<?php
$db_config = array(
    'dbg' => array(
        // 微信支付
        'wxpay' => array(
            'Name' => '微信登录',
            'Cfg'  => array(
                'mchid' => array(
                    'Name' => '商家号',
                    'Type' => 'text',
                ),
                'appkey' => array(
                    'Name' => 'AppKey',
                    'Type' => 'text',
                ),
                'appid' => array(
                    'Name' => '公众号应用Id(AppId)',
                    'Type' => 'text',
                ),
                'secretid' => array(
                    'Name' => '公众号密钥Id(SecretId)',
                    'Type' => 'text',
                ),
                'cert' => array(
                    'Name' => '证书',
                    'Type' => 'show',
                    'Html' => '
                        请让技术员安装
                    ',
                ),
                'api' => array(
                    'Name' => '开发文档',
                    'Type' => 'show',
                    'Html' => '
                        <a class="ly_color_a" href="https://pay.weixin.qq.com/wiki/doc/api/index.html" target="_blank">相关文档 https://pay.weixin.qq.com/wiki/doc/api/index.html</a>
                        <br/><br/>
                        <a class="ly_color_a" href="https://jingyan.baidu.com/article/2f9b480dd6374741cb6cc220.html" target="_blank">https://jingyan.baidu.com/article/2f9b480dd6374741cb6cc220.html</a>
                        <br/>
                        <a class="ly_color_a" href="https://jingyan.baidu.com/article/154b463136e61728ca8f41a5.html" target="_blank">https://jingyan.baidu.com/article/154b463136e61728ca8f41a5.html</a>
                    ',
                ),
                'test' => array(
                    'Name' => '测试',
                    'Type' => 'show',
                    'Html' => '
                        <a class="ly_color_a" href="/api/pay/wxpay/example/" target="_blank"><btn>测试一下</btn></a>
                    ',
                ),
            ),
        ),
        // 支付宝
        'alipay' => array(
            'Name' => '支付宝',
            'Cfg'  => array(
                'partner' => array(
                    'Name' => '合作身份者ID',
                    'Type' => 'text',
                ),
                'key' => array(
                    'Name' => 'MD5密钥',
                    'Type' => 'text',
                ),
                'api' => array(
                    'Name' => '开发文档',
                    'Type' => 'show',
                    'Html' => '
                        <a class="ly_color_a" href="https://opendocs.alipay.com/open/270/105898?ref=api" target="_blank">PC相关文档 https://opendocs.alipay.com/open/270/105898?ref=api</a>
                        <br/><br/>
                        <a class="ly_color_a" href="https://opendocs.alipay.com/open/203/105288?ref=api" target="_blank">手机相关文档 https://opendocs.alipay.com/open/203/105288?ref=api</a>
                        <br/>
                        <a class="ly_color_a" href="https://opendocs.alipay.com/open/203/107084" target="_blank">准备接入 https://opendocs.alipay.com/open/203/107084</a>
                    ',
                ),
                'test' => array(
                    'Name' => '测试',
                    'Type' => 'show',
                    'Html' => '
                        <a class="ly_btn" href="/api/pay/alipay/example/" target="_blank">测试一下</a>
                    ',
                ),
            ),
        ),
        // 银联支付
        'unionpay' => array(
            'Name' => '银联支付',
            'Cfg'  => array(
                'merId' => array(
                    'Name' => '商户号',
                    'Type' => 'text',
                ),
                'signCertPwd' => array(
                    'Tip' => '测试环境密码为：000000',
                    'Name' => '商户号',
                    'Type' => 'text',
                ),
                'signCertPath' => array(
                    'Name' => '商户私钥证书文件',
                    'Type' => 'img',
                ),
                'encryptCertPath' => array(
                    'Name' => '敏感加密证书文件',
                    'Type' => 'img',
                ),
                'rootCertPath' => array(
                    'Name' => '根证书文件',
                    'Type' => 'img',
                ),
                'middleCertPath' => array(
                    'Name' => '中级证书文件',
                    'Type' => 'img',
                ),
                'api' => array(
                    'Name' => '开发文档',
                    'Type' => 'show',
                    'Html' => '
                        <a href="https://kdocs.cn/l/sdW4rNQ1w" target="_blank">证书下载及导出流程 https://kdocs.cn/l/sdW4rNQ1w</a>
                    ',
                ),
                'is_test' => array(
                    'Name' => '开启测试环境',
                    'Type' => 'open',
                ),
                'test' => array(
                    'Name' => '测试',
                    'Type' => 'show',
                    'Html' => '
                        <a href="/api/pay/unionpay/example/" target="_blank"><btn>测试一下</btn></a>
                        <table class="maxw" border="1">
                            <thead>
                                <tr>
                                    <td>卡号</td>
                                    <td>卡性质</td>
                                    <td>机构名称</td>
                                    <td>手机号码</td>
                                    <td>密码</td>
                                    <td>CVN2</td>
                                    <td>有效期</td>
                                    <td>证件号</td>
                                    <td>姓名</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>6216261000000000018</td>
                                    <td>借记卡</td>
                                    <td>平安银行</td>
                                    <td>13552535506</td>
                                    <td>123456</td>
                                    <td></td>
                                    <td></td>
                                    <td>341126197709218366</td>
                                    <td>全渠道</td>
                                </tr>
                                <tr>
                                    <td>6221558812340000</td>
                                    <td>贷记卡</td>
                                    <td>平安银行</td>
                                    <td>13552535506</td>
                                    <td>123456</td>
                                    <td>123</td>
                                    <td>2311</td>
                                    <td>341126197709218366</td>
                                    <td>互联网</td>
                                </tr>
                                <tr>
                                    <td colspan="3">商户号:777290058182542</td>
                                    <td colspan="3">网关、WAP短信验证码:111111</td>
                                    <td colspan="3">控件短信验证码:123456</td>
                                </tr>
                            </tbody>
                        </table>
                    ',
                ),
            ),
        ),
    ),
);
return $db_config;
?>