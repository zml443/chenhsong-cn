<?php
namespace com\unionpay\acp\sdk;
use db,ly200,str;
include_once 'log.class.php';
include_once 'common.php';

class SDKConfig {
	
	private static $_config = null;
	public static function getSDKConfig(){
		if (SDKConfig::$_config == null ) {
			SDKConfig::$_config = new SDKConfig();
		}
		return SDKConfig::$_config;
	}
	
	private $merId;
	private $frontTransUrl;
	private $backTransUrl;
	private $singleQueryUrl;
	private $batchTransUrl;
	private $fileTransUrl;
	private $appTransUrl;
	private $cardTransUrl;
	private $orderTransUrl;
	private $jfFrontTransUrl;
	private $jfBackTransUrl;
	private $jfSingleQueryUrl;
	private $jfCardTransUrl;
	private $jfAppTransUrl;
	private $qrcBackTransUrl;
	private $qrcB2cIssBackTransUrl;
	private $qrcB2cMerBackTransUrl;
	private $zhrzFrontTransUrl;
	private $zhrzBackTransUrl;
	private $zhrzSingleQueryUrl;
	private $zhrzBatchTransUrl;
	private $zhrzAppTransUrl;
	private $zhrzFaceTransUrl;
	
	private $signMethod;
	private $version;
	private $ifValidateCNName;
	private $ifValidateRemoteCert;
	
	private $signCertPath;
	private $signCertPwd;
	private $validateCertDir;
	private $encryptCertPath;
	private $rootCertPath;
	private $middleCertPath;
	private $frontUrl;
	private $frontFailUrl;
	private $backUrl;
	private $secureKey;
	private $logFilePath;
	private $logLevel;
	//panelhunt.ly300.cn/api/unionpay/payapi.php
	function __construct(){
		global $c;
		// $row =str::str_code(db::get_one('config', "GroupId='UnionPay'"));
		// $text=str::str_code(str::json_data(htmlspecialchars_decode($row['Value']),1));

		if(g('third_pay.unionpay.is_test')){
			$url = 'https://gateway.test.95516.com';
		}else{
			$url = 'https://gateway.95516.com';
		}
		
		$this->merId = $text['merId'];//商户代码
		
		$this->frontTransUrl = $url.'/gateway/api/frontTransReq.do';//前台交易请求地址
		$this->backTransUrl = $url.'/gateway/api/backTransReq.do';//后台交易请求地址(无卡交易配置该地址)
		$this->singleQueryUrl = $url.'/gateway/api/queryTrans.do';//单笔查询请求地址
		$this->batchTransUrl = $url.'/gateway/api/batchTrans.do';//批量交易请求地址
		$this->fileTransUrl = $url.'https://filedownload.test.95516.com/';//文件传输类交易地址
		$this->appTransUrl = $url.'/gateway/api/appTransReq.do';//APP交易请求地址
		$this->cardTransUrl = $url.'/gateway/api/cardTransReq.do';//后台交易请求地址(若为有卡交易配置该地址)
		$this->orderTransUrl = $url.'/gateway/api/order.do';
		
		$this->jfFrontTransUrl = $url.'/jiaofei/api/frontTransReq.do';//缴费产品前台交易请求地址
		$this->jfBackTransUrl = $url.'/jiaofei/api/backTransReq.do';//缴费产品后台交易请求地址(无卡交易配置该地址)
		$this->jfSingleQueryUrl = $url.'/jiaofei/api/queryTrans.do';//缴费产品笔查询请求地址
		$this->jfCardTransUrl = $url.'/jiaofei/api/cardTransReq.do';//缴费产品后台交易请求地址(若为有卡交易配置该地址)
		$this->jfAppTransUrl = $url.'/jiaofei/api/appTransReq.do';//缴费产品手机APP交易请求地址
		
		/* $this->qrcBackTransUrl = array_key_exists("acpsdk.qrcBackTransUrl", $sdk_array)?$sdk_array["acpsdk.qrcBackTransUrl"] : null;
		$this->qrcB2cIssBackTransUrl = array_key_exists("acpsdk.qrcB2cIssBackTransUrl", $sdk_array)?$sdk_array["acpsdk.qrcB2cIssBackTransUrl"] : null;
		$this->qrcB2cMerBackTransUrl = array_key_exists("acpsdk.qrcB2cMerBackTransUrl", $sdk_array)?$sdk_array["acpsdk.qrcB2cMerBackTransUrl"] : null;
		$this->zhrzFrontTransUrl = array_key_exists("acpsdk.zhrzFrontTransUrl", $sdk_array)?$sdk_array["acpsdk.zhrzFrontTransUrl"] : null;
		$this->zhrzBackTransUrl = array_key_exists("acpsdk.zhrzBackTransUrl", $sdk_array)?$sdk_array["acpsdk.zhrzBackTransUrl"] : null;
		$this->zhrzSingleQueryUrl = array_key_exists("acpsdk.zhrzSingleQueryUrl", $sdk_array)?$sdk_array["acpsdk.zhrzSingleQueryUrl"] : null;
		$this->zhrzBatchTransUrl = array_key_exists("acpsdk.zhrzBatchTransUrl", $sdk_array)?$sdk_array["acpsdk.zhrzBatchTransUrl"] : null;
		$this->zhrzAppTransUrl = array_key_exists("acpsdk.zhrzAppTransUrl", $sdk_array)?$sdk_array["acpsdk.zhrzAppTransUrl"] : null;
		$this->zhrzFaceTransUrl = array_key_exists("acpsdk.zhrzFaceTransUrl", $sdk_array)?$sdk_array["acpsdk.zhrzFaceTransUrl"] : null; */
		
		$this->signMethod = '01';//签名方式，证书方式固定01，请勿改动
		$this->version = '5.1.0';//报文版本号，固定5.1.0，请勿改动
		$this->ifValidateCNName = g('third_pay.unionpay.is_test')?'false':'true';//是否验证验签证书的CN，测试环境请设置false，生产环境请设置true。非false的值默认都当true处理。
		$this->ifValidateRemoteCert = g('third_pay.unionpay.is_test')?'false':'true';//是否验证https证书，测试环境请设置false，生产环境建议优先尝试true，不行再false。非true的值默认都当false处理。
		
		/*------------------------入网测试环境签名证书配置 --------------------------------
		; 多证书的情况证书路径为代码指定，可不对此块做配置。
		; 签名证书路径，必须使用绝对路径，如果不想使用绝对路径，可以自行实现相对路径获取证书的方法；测试证书所有商户共用开发包中的测试签名证书，生产环境请从cfca下载得到。
		; 测试环境证书位于assets/测试环境证书/文件夹下，请复制到d:/certs文件夹。生产环境证书由业务部门邮件发送。
		*/
		$this->signCertPath = c('root').g('third_pay.unionpay.signCertPath');//商户私钥证书
		$this->signCertPwd = g('third_pay.unionpay.signCertPwd');//签名证书密码，测试环境固定000000，生产环境请修改为从cfca下载的正式证书的密码，正式环境证书密码位数需小于等于6位，否则上传到商户服务网站会失败
		
		// $this->validateCertDir = array_key_exists("acpsdk.validateCert.dir", $sdk_array)? $sdk_array["acpsdk.validateCert.dir"]: null;
		$this->encryptCertPath = c('root').g('third_pay.unionpay.encryptCertPath');//敏感加密证书
		$this->rootCertPath = c('root').g('third_pay.unionpay.rootCertPath');//根证书
		$this->middleCertPath =  c('root').g('third_pay.unionpay.middleCertPath');//中级证书
		
		$this->frontUrl =  \server::domain(1)."/api/unionpay/return.html";//'http://localhost:8086/upacp_demo_b2c/demo/api_01_gateway/FrontReceive.php';//前台通知地址，填写处理银联前台通知的地址，必须外网能访问
		// $this->frontFailUrl =  array_key_exists("acpsdk.frontFailUrl", $sdk_array)?$sdk_array["acpsdk.frontFailUrl"]: null;//失败交易前台跳转地址，，可为空
		$this->backUrl =  \server::domain(1)."/api/pay/unionpay/callback";//'http://222.222.222.222:8080/upacp_demo_b2c/demo/api_01_gateway/BackReceive.php';//后台通知地址，填写接收银联后台通知的地址，必须外网能访问
		// $this->secureKey =  array_key_exists("acpsdk.secureKey", $sdk_array)?$sdk_array["acpsdk.secureKey"]: null;
		$this->logFilePath =  dirname(__FILE__).'/../logs/';//日志打印路径，linux注意要有写权限
		$this->logLevel =  'DEBUG';//日志级别，debug级别会打印密钥，生产请用info或以上级别
		// print_r($this);exit;
	}

	public function __get($property_name)
	{
		if(isset($this->$property_name))
		{
			return($this->$property_name);
		}
		else
		{
			return(NULL);
		}
	}

}


