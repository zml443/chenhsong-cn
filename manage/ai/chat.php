<?php

function_exists('c')||exit();

$params = array(
    'ApiName' => 'chat',
    'type' => $_POST['type'],
    'uid' => $_POST['uid'],
    'question' => $_POST['question'],
);

if($_POST['type'] == 'reset'){
    $params['id'] = $_POST['id'];
}

$res = curl::api('http://ai.test.lianyayun.com/gateway/xfyun.php', 'iw2QlKtUWmRZrJuS4kpKOt40nnPcvJag', $params);

echo $res;