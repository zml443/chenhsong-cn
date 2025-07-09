<?php
class ly200 {

	public static function icp () {
		return '<a href="https://beian.miit.gov.cn/" rel="nofollow" target="_blank">'.g('wb_site_config.icp').'</a>';
	}

	public static function icp2 () {
		if (g('wb_site_config.beian')) {
			return '<a href="'.g('wb_site_config.beian_url').'" rel="nofollow" target="_blank"><img src="https://www.seoshipin.cn/wp-content/uploads/beian.png" />'.g('wb_site_config.beian').'</a>';
		} else {
			return '';
		}
	}

	public static function copyright () {
		return g(ln('wb_site_config.copyright'));
	}

	public static function load_static () {
		$static = '';
		$args = func_get_args();
		foreach ((array)$args as $v) {
			if (is_array($v)) {
				$a = $v[1];
				$v = $v[0];
			}
			if (!is_file(c('root') . $v)) {
				continue;
			}
			if (preg_match('#\.css$#', $v)) {
				$static .= "<link href='{$v}' rel='stylesheet' type='text/css' $a />\r\n";
			} else if (preg_match('#\.js$#', $v)) {
				$static .= "<script type='text/javascript' src='{$v}' $a></script>\r\n";
			}
		}
		return $static;
	}

	public static function cnzz($id){
		if($id){
			return "<script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id='cnzz_stat_icon_{$id}'%3E%3C/span%3E%3Cscript src='\" + cnzz_protocol + \"s22.cnzz.com/z_stat.php%3Fid%3D{$id}%26show%3Dpic' type='text/javascript'%3E%3C/script%3E\"));</script>";
		}else{
			return '';
		}
	}

	public static function seo ($seo='', $ext_str='') {
		if ($seo['IsMonolingual']) {
			$SeoTitle=$seo['SeoTitle'];
			$SeoKeywords=$seo['SeoKeyword'];
			$SeoDescription=$seo['SeoDescription'];
		} else {
			$SeoTitle=$seo[ln('SeoTitle')];
			$SeoKeywords=$seo[ln('SeoKeyword')];
			$SeoDescription=$seo[ln('SeoDescription')];
		}

		if(!$SeoTitle && !$SeoKeywords && !$SeoDescription){
			$SeoTitle=g(ln('wb_seo_config.title'));
			$SeoKeywords=g(ln('wb_seo_config.keyword'));
			$SeoDescription=g(ln('wb_seo_config.brief'));
		}

		$copyCode=(int)$mCfg['IsCopy']?'<script type="text/javascript">document.oncontextmenu=new Function("event.returnValue=false;");document.onselectstart=new Function("event.returnValue=false;");</script>':'';	//防复制

		$str='';
		$where='IsOpen=1 and IsFooter=0 and '.(server::mobile()?'Type in(0,2)':'Type in(0,1)');
		$third_row=db::get_all('wb_third', $where, '*', 'Id desc');
		foreach((array)$third_row as $v){
			$str.=$v['Code'];
		}
		return "{$str}<link rel='shortcut icon' href='".img::ary(g('set.base.ico'),0)."' />\r\n<meta name=\"keywords\" content=\"$SeoKeywords\" />\r\n<meta name=\"description\" content=\"$SeoDescription\" />\r\n<title>$SeoTitle</title>\r\n".$copyCode;
	}

	public static function out_put_third_code () {	//输出第三方代码
		$where = 'IsOpen=1 and IsFooter=1 and ' . (server::mobile()?'Type in(0,2)':'Type in(0,1)');
		$third_row = db::get_all('wb_third', $where, '*', 'Id desc');
		$str = '';
		foreach ((array)$third_row as $v) $str .= $v['Code'];
		return $str;
	}

	public static function tech_support($type=0){	//技术支持 1:显示，0：隐藏
		if (c('FnType.technical_support_hidden')) {
			return '';
		}
		if (ln('')=='_cn') {
			$str = '
				<a href="http://www.szlianya.net" target="_blank">深圳网站建设</a>
				<a href="http://www.szlianya.net" target="_blank">深圳联雅</a>
			';
		} else {
			$str = '
				<a href="http://www.szlianya.net" target="_blank">Web design</a>
				<a href="http://www.szlianya.net" target="_blank">LY Network</a>
			';
		}
		return $str;
	}

	public static function sendmail($toEmail, $Msubject, $Mbody){	//发送邮件
		$config_row = (array)g('wb_email_config');
		$data = array(
			'From'			=>	$config_row['FromEmail']?$config_row['FromEmail']:'noreply@szlianya.com',
			'FromName'		=>	$config_row['FromName']?$config_row['FromName']:'联雅云',
			'To'			=>	$toEmail,
			'Domain'		=>	server::domain(0),
			'lang'			=>	'zh-cn',
			'Number'		=>	c('Number'),
			'Subject'		=>	$Msubject,
			'Body'			=>	str_replace(array("\t","\n","\r"),'',$Mbody),
			'timestamp'		=>	c('time'),
		);

		if ($config_row['SmtpHost'] && $config_row['SmtpPort'] && $config_row['SmtpUserName'] && $config_row['SmtpPassword']) {
			$data['SmtpHost'] = $config_row['SmtpHost'];
			$data['SmtpPort'] = $config_row['SmtpPort'];
			$data['SmtpUserName'] = $config_row['SmtpUserName'];
			$data['SmtpPassword'] = $config_row['SmtpPassword'];
		}
		return curl::api('https://api.lianyayun.com/gateway/lyy-sign/email/send', c('Apikey'), $data);
	}

	public static function send_sms($MobilePhone, $Contents, $SmsSign=''){
		if (!$MobilePhone || !$Contents){ str::msg('缺少相关的参数！'); }
		$url = 'http://qxt.1166.com.cn/qxtsys/recv_center';
		$MobilePhone = str::ary_format((array)$MobilePhone, 2);
		$par=array(
			"CpName"	=>	c('sms.account'),	//账号
			"CpPassword"=>	c('sms.password'),	//密码
			"DesMobile"	=>	$MobilePhone,
			"Content"	=>	$Contents.$SmsSign,
		);
		$run = curl::init($url, $par);
		$result = str::json($run[0], 'decode');
		if ($result['code'] == -1000) {
			return false;
		} else {
			return $result;
		}
	}
	//////////////////////////////////////////////////////////








		// 汇率 rate
	//////////////////////////////////////////////////////////////////
	/**
	 * 货币类型，并且转换汇率
	 * @param {float} $price 价钱
	 * @param {string} 返回类型 默认0：返回汇率符号+价格，1：返回汇率符号，2：返回两位小数点的价格
	 * @return {string|float}
	 */
	public static $rate_current = array();
	public static function rate ($price=0, $type=0) {
		if (!self::$rate_current) {
			if ($_SESSION['exchange_rate_id']) {
				$where = "Id='{$_SESSION['exchange_rate_id']}'";
			} else {
				$where = "`Default`=1";
			}
			self::$rate_current = db::result("select Ico,Rate from wb_site_rate where $where");
		}
		$row = self::$rate_current;
		$price = ((float)$price)*$row['Rate'];
		if (0) {
			$price = floatval($price);
		} else {
			$price = sprintf("%.2f", $price);
		}
		if($type==1) {
			return $row['Ico'];
		} else if($type==2) {
			return $price;
		} else {
			return $row['Ico'].$price;
		}
	}
	//////////////////////////////////////////////////////////////////





	// 订单 orders
	//////////////////////////////////////////////////////////////////
	// 订单进度条状态,self为自身状态，current为订单状态
	public static function orders_progress_status($_ARG=array()){
		switch ($_ARG['current']) {
			case 'unpay':
				$has = in_array($_ARG['self'], array('unpay'));
				break;
			case 'pay':
				$has = in_array($_ARG['self'], array('unpay', 'pay'));
				break;
			case 'wait':
				$has = in_array($_ARG['self'], array('unpay', 'pay', 'wait'));
				break;
			case 'unshipping':
				$has = in_array($_ARG['self'], array('unpay', 'pay', 'wait', 'unshipping'));
				break;
			case 'shipping':
				$has = in_array($_ARG['self'], array('unpay', 'pay', 'wait', 'unshipping', 'shipping'));
				break;
			case 'finished':
				$has = in_array($_ARG['self'], array('unpay', 'pay', 'wait', 'unshipping', 'shipping', 'finished'));
				break;
			// case 'cancel':
			// 	$has = in_array($_ARG['self'], array('unpay', 'pay', 'wait', 'unshipping', 'shipping', 'finished', 'cancel'));
			// 	break;
			default:
				$has = in_array($_ARG['self'], array('unpay'));
				break;
		}
		return $has;

	}
	/**
	 * 订单价格
	 * @param {array} $order 订单数据
	 * @return {float}
	 */
	public static function orders_real_price ($order) {
		return ($order['TotalPrice']*$order['FreeDiscount']/100+$order['ShippingPrice'])*(1+$order['PayAdditionalFee']/100) - $order['FreeMoney'] - $order['IntegralPrice'];
	}
	//////////////////////////////////////////////////////////////////




	// 运费 shipping
	//////////////////////////////////////////////////////////////////
	public static function shipping_all_price($_ARG=array()){
		$weight = (float)$_ARG['weight'];
		$lang = $_ARG['lang']?:c('lang');
		$country = $_ARG['country'];
		$province = $_ARG['province'];
		$price = (float)$_ARG['price'];
		$shipping_row = db::query("select * from wb_shipping order by Id asc");
		$shipping = array();
		$ids = '0';
		$k = -1;
		if ($lang=='cn') {
			$field = 'Name_cn';
		} else {
			$field = 'Name_en';
		}
		while ($v=db::result($shipping_row)) {
			$k++;
			$ids .= ','.$v['Id'];
			$shipping[$v['Id']] = array(
				'Id' => $v['Id'],
				// 'Name' => $v[ln('Name')],
				'Name' => $v[$field],
				'Price' => 0,
				'FreeOpen' => $v['FreeOpen'],
				'FreeStartPrice' => $v['FreeStartPrice'],
				'Picture' => $v['Picture'],
			);
		}
		// $field = ln('Name');
		// if ($country && preg_match("/(中国|中國|China)/", $country)) {
		if ($country) {
			$shipping_price = db::query("select * from wb_shipping_country_price where wb_shipping_id in({$ids}) and ($field like '%{$country}%' or '{$country}' like CONCAT('%',{$field},'%'))");
		} else {
			$shipping_price = db::query("select * from wb_shipping_price where wb_shipping_id in({$ids}) and ($field like '%{$province}%' or '{$province}' like CONCAT('%',{$field},'%'))");
		}
		$row = array();
		while($v = db::result($shipping_price)){
			if ($ship = $shipping[$v['wb_shipping_id']]) {
				$ship['FirstWeight'] = $v['FirstWeight'];
				$ship['FirstPrice'] = $v['FirstPrice'];
				$ship['ExtWeight'] = $v['ExtWeight'];
				$ship['ExtWeightPrice'] = $v['ExtWeightPrice'];
				// 免运费
				if ($ship['FreeOpen'] && $ship['FreeStartPrice']<=$price) {
					$ship['Price'] = 0;
				} else {
					$ship['Price'] = $ship['FirstPrice'];
					if ($weight>$ship['FirstWeight']) {
						$ship['Price'] += ($weight-$ship['FirstWeight'])*$ship['ExtPrice'];
					}
				}
				$row[] = $ship;
			}
		}
		return $row;
	}
	// 获取运费价格
	public static function shipping_one_price($_ARG=array()){
		$weight = (float)$_ARG['weight'];
		$lang = $_ARG['lang']?:c('lang');
		$country = $_ARG['country'];
		$province = $_ARG['province'];
		$price = (float)$_ARG['price'];
		$wb_shipping_id = (int)$_ARG['wb_shipping_id'];
		$v = db::result("select * from wb_shipping where Id='{$wb_shipping_id}' limit 0,1");
		if (!$v) {
			return array();
		}
		if ($lang=='cn') {
			$field = 'Name_cn';
		} else {
			$field = 'Name_en';
		}
		$row = array(
			'Id' => $v['Id'],
			// 'Name' => $v[ln('Name')],
			'Name' => $v[$field],
			'Price' => 0,
			'FreeOpen' => $v['FreeOpen'],
			'FreeStartPrice' => $v['FreeStartPrice'],
			'Picture' => $v['Picture'],
		);
		// if ($country && preg_match("/(中国|中國|China)/", $country)) {
		if ($country) {
			$shipping_price = db::result("select * from wb_shipping_country_price where wb_shipping_id='{$row['Id']}' and ($field like '%{$country}%' or '{$country}' like CONCAT('%',{$field},'%'))");
		} else {
			$shipping_price = db::result("select * from wb_shipping_price where wb_shipping_id='{$row['Id']}' and ($field like '%{$province}%' or '{$province}' like CONCAT('%',{$field},'%'))");
		}
		if ($shipping_price) {
			$row['FirstWeight'] = $shipping_price['FirstWeight'];
			$row['FirstPrice'] = $shipping_price['FirstPrice'];
			$row['ExtWeight'] = $shipping_price['ExtWeight'];
			$row['ExtWeightPrice'] = $shipping_price['ExtWeightPrice'];
			// 免运费
			if ($row['FreeOpen'] && $row['FreeStartPrice']<=$price) {
				$row['Price'] = 0;
			} else {
				$row['Price'] = $row['FirstPrice'];
				if ($weight>$row['FirstWeight']) {
					$row['Price'] += ($weight-$row['FirstWeight'])*$row['ExtPrice'];
				}
			}
		} else {
			return array();
		}
		return $row;
	}
	//////////////////////////////////////////////////////////////////




	// 产品 products
	//////////////////////////////////////////////////////////////////
	// 计算产品真实价格
	// $_ARG['row'] 产品数据
	// $_ARG['wb_products_parameter_id'] 产品所选参数id
	// $_ARG['qty'] 购买数量
    public static function  products_parameter_price($_ARG=array()){
		$row = $_ARG['row'];
		$realPrice = $row['Price'];
		$realStock = $row['Stock'];
		$realWeight = $row['Weight'];
		$realSKU = $row['SKU'];
		$realPicture = array();
		$Price = 0;
		$Stock = 0;
		$Weight = 0;
		$SKU = 0;
		$Picture = 0;

		if (!is_array($row['Pictures'])) {
			$row['Pictures'] = str::json($row['Pictures'], 'decode');
		}
		$realPicture = $row['Pictures'][0]?:array('path'=>'','alt'=>$row[ln('Name')]);

		$wb_products_parameter = array();
		$wb_products_parameter_price = array();//产品可选参数的组合
		if (!is_array($row['wb_products_parameter_price'])) {
			$wb_products_parameter = str::json($row['wb_products_parameter'], 'decode');
			$wb_products_parameter_price = str::json($row['wb_products_parameter_price'], 'decode');
		}
		$wb_products_parameter_id_buy = '';	//购买的产品 所选的参数id
		$wb_products_parameter_buy = array(); //购买的产品 所选的参数具体数据
		if ($_ARG['wb_products_parameter_id']) {
			foreach ($wb_products_parameter_price as $k => $v) {
				if ($_ARG['wb_products_parameter_id']==$v['parameter_id']) {
					$wb_products_parameter_buy = $v['parameter'];
					$Stock = $v['stock'];
					$Weight = $v['weight'];
					$SKU = $v['SKU'];
					$Price = $v['price'];
					$wb_products_parameter_id_buy = $v['parameter_id'];
					if ($v['picture']) {
						$Picture['path'] = $v['picture'];
					}
				}
			}
		}

		// 参数价格
		if ($row['ProPriceType']==1&&$wb_products_parameter_id_buy) {
			$realPicture = $Picture;
			$realPrice = $Price;
			$realStock = $Stock;
			$realWeight = $Weight;
			$realSKU = $SKU;
		}
		// 批发价
		if ($_ARG['qty']) {
			// $row['WholesalePrice']
		}
		return array(
			'Picture' => $realPicture,
			'Price' => $realPrice,
			'Stock' => $realStock,
			'Weight' => $realWeight,
			'SKU' => $realSKU,
			'ProPriceType' => $row['ProPriceType'],
			'wb_products_parameter_id_buy' => $wb_products_parameter_id_buy,
			'wb_products_parameter_buy' => $wb_products_parameter_buy,
		);
	}
	//////////////////////////////////////////////////////////////////
}