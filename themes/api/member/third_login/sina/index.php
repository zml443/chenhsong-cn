<?php

isset($c)||exit;

include dirname(__FILE__).'/config.php';

$CODE='1234'; // 可随机获取，记录到session，做回调链接的验证

$CodeUrl="https://api.weibo.com/oauth2/authorize?client_id={$CLIENT_ID}&response_type=code&redirect_uri={$REGISTERED_REDIRECT_URI}";
$AccessToken="https://api.weibo.com/oauth2/access_token?client_id={$CLIENT_ID}&client_secret={$CLIENT_SECRET}&grant_type=authorization_code&redirect_uri={$REGISTERED_REDIRECT_URI}&code={$CODE}";

js::location($CodeUrl);