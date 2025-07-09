<?php


class aliyun_dns{
	
	public static function record($domain, $record_value, $record_resource=array('@', '*'), $record_type='A'){
        global $c;
		include_once(__DIR__.'/aliyun/aliyun-php-sdk-core/Config.php');
        $aliyun = new DefaultAcsClient(DefaultProfile::getProfile('cn-hangzhou', c('aliyun.id'), c('aliyun.secret')));
        $del_request = new Alidns\Request\V20150109\DeleteSubDomainRecordsRequest();
        $add_request = new Alidns\Request\V20150109\AddDomainRecordRequest();
        $record_value = (array)$record_value;
        $record_resource = (array)$record_resource;
        $record_type = (array)$record_type;
        $add_result = array();
        $conflict=array(
            'CNAME' => array('A', 'URL', 'TXT', 'AAAA', 'SRV', 'CAA'),
            'A'     => array('CNAME', 'URL'),
            'URL'   => array('CNAME', 'A', 'URL', 'AAAA'),
            'TXT'   => array('CNAME'),
            'AAAA'  => array('CNAME', 'URL'),
            'SRV'   => array('CNAME'),
            'CAA'   => array('CNAME')
        );
        foreach($record_resource as $k=>$v){
            $type = $record_type[$k]!=''?$record_type[$k]:$record_type[0];
            $type_ary = array_merge($conflict[$type], array($type));
            foreach($type_ary as $v2){
                $del_request->setDomainName($domain);
                $del_request->setRR($v);
                $del_request->setType($v2);
                $del_result = $aliyun->getAcsResponse($del_request);
	            /*if (!$del_result['ret'] && $exit) {
	            	exit(str::json(array(
	            		'ret' => 1,
	            		'msg' => "删除{$v}.{$domain}解析：".$del_result['Message'],
	            	)));
	            }*/
            }
        }
        foreach($record_resource as $k=>$v){
            $type = $record_type[$k]!=''?$record_type[$k]:$record_type[0];
            $value = $record_value[$k]!=''?$record_value[$k]:$record_value[0];
            $add_request->setMethod('GET');
            $add_request->setDomainName($domain);
            $add_request->setRR($v);
            $add_request->setType($type);
            $add_request->setValue($value);
            substr_count($v, '_acme-challenge') && $add_request->setTTL(600);
            $add_result[] = $aliyun->getAcsResponse($add_request);
            /*if (!$add_result['ret'] && $exit) {
            	exit(str::json(array(
            		'ret' => 1,
            		'msg' => "添加{$v}.{$domain}解析到{$value}：".$add_result['Message'],
            	)));
            }*/
        }
        return $add_result;
    }

}
?>