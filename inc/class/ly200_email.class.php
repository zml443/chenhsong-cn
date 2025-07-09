<?php

class ly200_email {
	public static $secret = 'l6tSQsmUSeil9Dul1iHavYztBVFagd';
	public static $keyId = 'LTAI5tRAErBmBBvC8NFoFn1g';
	// 发送
	public static function send($data){
		date_default_timezone_set("UTC");
		// 单邮件发送
		$data['From'] || $data['From'] = 'noreply@szlianya.com';
		$data['FromName'] || $data['FromName'] = '联雅云';
		is_array($data['To']) && $data['To'] = implode(',', $data['To']);
		$options = array(
			'Format' => 'JSON',
			'Version' => '2015-11-23',
			'AccessKeyId' => self::$keyId,
			'SignatureMethod' => 'HMAC-SHA1',
			'SignatureNonce' => date('Y-m-d-H:i:s-').rand(100, 900),
			'SignatureVersion' => '1.0',
			'RegionId' => 'cn-hangzhou',
			'AccountName' => 'noreply@sendmail.ooofoo.com',
			'AddressType' => 1,

			'ReplyToAddress' => 'true',
			'ReplyAddress' => $data['From'], //回信地址
			'ReplyAddressAlias' => $data['FromName'], //回信昵称

			'Action' => 'SingleSendMail',
			'Subject' => $data['Subject'],
			'TagName' => 'lianyayun',
			'FromAlias' => $data['FromName'], //发送人昵称
			'ToAddress' => $data['To'],
			'HtmlBody' => $data['Body'],
			'Timestamp' => date('Y-m-d\TH:i:s\Z', c('time')+300),
		);
		$options['Signature'] = self::sign($options);
		$result = curl::init('http://dm.aliyuncs.com/', $options);
		$result = str::json($result[0], 'decode');
		if ($result['Code']) {
			$xxx = array(
				'ret' => 0,
				'msg' => $result['Code']
			);
		} else {
			$xxx = array(
				'ret' => 1,
				'msg' => 'success'
			);
		}
		return $xxx;
	}
	// 签名
	public static function sign($data){	//生成签名
		$str = '';
		$data = str::code($data, 'trim');
		ksort($data);
		$i=0;
		foreach ((array)$data as $k => $v) {
			if ($k=='Signature' || $v===''){ continue; }
			$str .= ($i?'&':'')."$k=".str_replace('+','%20',urlencode($v));
			$i++;
		}
		$str = 'POST&'.urlencode('/').'&'.urlencode($str);
	    $apikey = self::$secret.'&';
	    $sign = base64_encode(hash_hmac("sha1", $str, $apikey, true));
		return $sign;
	}
}
