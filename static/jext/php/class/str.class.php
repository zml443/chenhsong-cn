<?php

class str {
	/*
	 * 文本编码
	 * @param {string|array} $data 数据
	 * @param {string} $fun 函数名，只能传一个参数的php函数
	 * @return {string|array}
	 */
	public static function code ($data, $fun='htmlspecialchars') {
		if(!is_array($data)){
			return $fun($data);
		}
		$new_data = array();
		foreach((array)$data as $k=>$v){
			if(is_array($v)){
				$new_data[$k] = self::code($v, $fun);
			}else{
				$new_data[$k] = $fun($data[$k]);
			}
		}
		return $new_data;
	}
	/*
	 * 可逆加密
	 * @param {string} $password 密码
	 * @param {string} $ac 类型 encode:加密   decode:解密
	 * @param {string} $key 额外加密键
	 * @return {string}
	 */
	public static function crypt ($data, $ac='', $key='wzbzd') {
		$ac&&$data=base64_decode($data);
		for($i=0; $i<strlen($data); $i++){
			$new_str.=$data[$i]^$key[$i%strlen($key)];
		}
		return $ac ? $new_str : base64_encode($new_str);
	}
	/*
	 * 不可逆加密
	 * @param {string} $password 密码
	 * @param {string} $key 额外加密键
	 * @return {string}
	 */
	public static function password ($password, $key='szlywl') {
		$password = md5($password);
		$password = substr($password, 0, 5) . substr($password, 10, 20) . substr($password, -5) . $key;
		return md5($password . $password);
	}
	/*
	 * 随机命名
	 * @param {int} $length 长度
	 * @param {string} $type 类型, number:数字  string:字母
	 * @return {string}
	 */
	public static function rand ($length=10, $type='default') {
		if ($type=='number') $chars='0123456789';
		else if ($type=='string') $chars='abcdefghijklmnopqrstuvwxyz';
		else {
			$chars='abcdefghijklmnopqrstuvwxyz0123456789';
			$len1 = 10;
		}
		$len = strlen($chars)-1;
		$code=$chars[mt_rand(0, $len-$len1)];
		for($i=0; $i<$length-1; $i++){
			$code.=$chars[mt_rand(0, $len)];
		}
		return $code;
	}
	/*
	 * 返回JSON参数
	 * 并且停止脚本运行
	 * @param {string|array} $msg 需要返回的数据
	 * @param {int} $ret 返回状态
	 * @return {void}
	 */
	public static function msg ($msg, $ret=0) {
		exit(self::json(array(
			'msg'	=>	$msg,
			'ret'	=>	$ret
		)));
	}
	public static function message ($msg, $ret=0) {
		return array(
			'msg'	=>	$msg,
			'ret'	=>	$ret
		);
	}
	public static function result ($result, $ret=0) {
		$result['ret'] = $ret;
		exit(self::json($result));
	}
	/*
	 * 转JSON的时候 \\' 这种格式录入数据库会挂掉
	 * @param {string} $s JSON数据
	 * @return {string}
	 */
	public static function json_code ($s) {
		return preg_replace("/([\\\\]+)'/", "\\'", $s);
	}
	/*
	 * JSON数据编码
	 * @param {string|array} $data 需要转换的JSON数据，或者数组
	 * @param {string} $action 执行类型，encode , decode
	 * @return {string|array}
	 */
	public static function json($data, $action='encode'){
		if($action=='encode'){
			if(!function_exists('unidecode')){
				function unidecode($match){
					return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
				}
			}
			return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'unidecode', json_encode((array)$data));
		} else {
			$rnt=array("\r","\n","\t");
			$bhr=array("|-r-|","|-n-|","|-t-|");
			$data = str_replace($rnt, $bhr, $data);
			$data = (array)json_decode($data, true);
			self::replace($bhr, $rnt, $data);
			return $data;
		}
	}
	public static function replace ($a, $b, &$array) {
		if (is_array($array)) {
			foreach ($array as $key => $val) {
				self::replace($a, $b, $array[$key]);
			}
		} else {
			$array = str_replace($a, $b, $array);
		}
	}
	/*
	 * 格式化文本
	 * @param {string} $str 需要处理的字符串
	 */
	public static function format ($str) {
		$str=str_replace('  ', '&nbsp; ', $str);
		$str=nl2br($str);	
		return $str;
	}

	// 将数组转换成数字类型，并且以逗号隔开 形成 sql 的 in 语句
	public static function sql_in($obj, $type="int"){
		if (is_string($obj)) {
			$obj = explode(',', $obj);
		}
		if ($type=='int') {
			foreach ($obj as $k => $v) {
				$obj[$k] = (int)$v;
			}
		} else {
			foreach ($obj as $k => $v) {
				$obj[$k] = addslashes($v);
			}
		}
		$obj = array_filter($obj);
		asort($obj);
		if ($type=='int') {
			$sql = implode(',',$obj);
			$sql || $sql = '0';
		} else {
			$sql = "'".implode("','",$obj)."'";
		}
		return $sql;
	}

	//隐藏邮箱账号
	public static function hide_email ($str) {
		preg_match('/^(.*)@(.*)$/', $str, $ary);
		if ($ary && $ary[1]) {
			$len = strlen($ary[1]);
			$ddd = '';
			if ($len<5) {
				for ($i=0;$i<$len;$i++) $ddd.='*';
				$str = $ddd.'@'.$ary[2];
			}
			else {
				for ($i=0;$i<$len-3;$i++) $ddd.='*';
				$str = substr_replace($ary[1], $ddd, 2, $len-3).'@'.$ary[2];
			}
		}
		return $str;
	}
	// 姓名
	public static function real_name ($first_name='', $last_name='') {
		if (preg_match('/^[a-zA-Z0-9_ \-]+$/',$first_name.$last_name)) {
			return $first_name.' '.$last_name;
		} else {
			return $last_name.' '.$first_name;
		}
	}

	// html的，不保存的内容
	public static function unsave_html($str){
	    $far=array(
	        "/\s+/",//过滤多余的空白
	        "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",  //过滤 <scrīpt 等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object的过滤
	        "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU", //过滤javascrīpt的on事件
	   	);
	   	$tar=array(" "," "," ");
	  	$str=preg_replace($far,$tar,$str);
	   	return $str;
	}

	//剪切字符串
	public static function cut ($str, $length, $start=0) {
		$str_0=array('&amp;', '&quot;', '&lt;', '&gt;', '&ldquo;', '&rdquo;');
		$str_1=array('&', '"', '<', '>', '“', '”');
		
		$str=str_replace($str_0, $str_1, $str);
		$len=strlen($str);
		if($len<=$length){return str_replace($str_1, $str_0, $str);}
		$substr='';
		$n=$m=0;
		for($i=0; $i<$len; $i++){
			$x=substr($str, $i, 1);
			$a=base_convert(ord($x), 10, 2);
			$a=substr('00000000'.$a, -8);
			if($n<$start){
				if(substr($a, 0, 3)==110){
					$i+=1;
				}elseif(substr($a, 0, 4)==1110){
					$i+=2;
				}
				$n++;
			}else{
				if(substr($a, 0, 1)==0){
					$substr.=substr($str, $i, 1);
				}elseif(substr($a, 0, 3)==110){
					$substr.=substr($str, $i, 2);
					$i+=1;
				}elseif(substr($a, 0, 4)==1110){
					$substr.=substr($str, $i, 3);
					$i+=2;
				}else{
					$substr.='';
				}
				if(++$m>=$length){break;}
			}
		}
		return str_replace($str_1, $str_0, $substr);
	}

	// 中文字符串的长度
	public static function utf8_strlen($s=null) {
		preg_match_all("/./us", $s, $r);
		return count($r[0]);
	}

	

	//$return，0：字符串，1：数组，2：in查询语句，3：or查询语句，4：返回第一个值
	public static function ary_format($data, $return=0, $unset='', $explode_char=',', $implode_char=','){
		!is_array($data) && $data=explode($explode_char, $data);
		foreach($data as $k=>$v){
			$data[$k]=trim($v);
		}
		$data=array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
		if($unset){
			$unset=ary::ary_format($unset, 1, '', $explode_char, $implode_char);
			foreach($data as $k=>$v){
				if(in_array($v, $unset)){
					unset($data[$k]);
				}
			}
		}
		if($return==0){	
			return $data?($implode_char.implode($implode_char, $data).$implode_char):'';
		}elseif($return==1){
			return $data;
		}elseif($return==2 || $return==3){
			if(!$data){return '"0"';}
			if($return==2){
				$is_numeric=true;
				foreach($data as $v){
					if(!is_numeric($v)){
						$is_numeric=false;
						break;
					}
				}
				return ($is_numeric?'':"'").implode($is_numeric?',':"','", $data).($is_numeric?'':"'");
			}else{
				return implode(' or ', $data);
			}
		}elseif($return==4){
			return array_shift($data);
		}
	}

	// 数组替换
	// $a 当前模块的json数据
	// $b 复制模块的json数据
	public static function ary_change ($a, $b) {
		foreach ($b as $k => $v) {
			if (isset($a[$k])) {
				if (is_array($v)) {
					$a[$k] = self::ary_change($a[$k], $v);
				}
			} else if (preg_match("/[^0-9]/", $k)) {
				$a[$k] = $v;
			}
		}
		return $a;
	}

	// 将数组的下标自增长
	public static function ary_values($ary, $key=null, $i=-10000){
		if ($i==1) $ary = array_values($ary);
		foreach ($ary as $k => &$v) {
			if (is_array($v)) {
				if ($key===null || $key===$k) {
					$v = array_values($v);
				}
				$v = self::ary_values($v, $key, $i+1);
			}
		}
		return $ary;
	}


	// 数组打印
	public static function ary_dump ($row, $conf=array(), $hide=0) {
		if (!$row) return 'array();';
		if ($conf['compress']) {
			$_r_n = "";
		} else {
			$_r_n = "\r\n";
		}
		$tab='';
		$moduleCon = $hide?'':$tab."array(".$_r_n;
		foreach ($row as $k => $v) {
			$moduleCon .= self::ary_dump_inside($tab."    ", $k, $v, $conf, 0, false);
		}
		$moduleCon .= $hide?'':$tab.")";
		return $moduleCon;
	}
	public static function ary_dump_inside ($tab, $k, $v, $conf, $is_number=false) {
		if ($conf['compress']) {
			$tab = "";
			$_r_n = "";
			$sk = '';
		} else {
			$_r_n = "\r\n";
			$sk = '     ';
		}
		if (is_array($v)) {
			$con1 = '';
			$v_is_number = true; //判断为纯数字下标
			$typ_k = 0;
			foreach ($v as $k1 => $v1) {
				if ($k1!==$typ_k) {
					$v_is_number = false;
					break; 
				}
				$typ_k++;
			}
			foreach ($v as $k1 => $v1) {
				$con1 .= self::ary_dump_inside($tab.$sk, $k1, $v1, $conf, $v_is_number);
			}
			if ($con1) {
				if ($is_number) {
					$con .= $tab."array(".$_r_n.$con1.$tab."),".$_r_n;
				} else {
					$con .= $tab."'$k' => array(".$_r_n.$con1.$tab."),".$_r_n;
				}
			}
		} else {
			if ($is_number) {
				if (is_numeric($v) && substr($v,0,1)!='0') {
					$con = $tab."$v,".$_r_n;
				} else if (is_bool($v) || $v=='true' || $v=='false') {
					if (is_string($v)) $v = $v=='true';
					$con = $tab.($v?'true':'false').",".$_r_n;
				} else {
					$con = $tab."'".addslashes($v)."',".$_r_n;
				}
			} else {
				if (is_numeric($v) && substr($v,0,1)!='0') {
					$con = $tab."'$k' => $v,".$_r_n;
				} else if (is_bool($v) || $v=='true' || $v=='false') { //如果是
					if (is_string($v)) $v = $v=='true';
					$con = $tab."'$k' => ".($v?'true':'false').",".$_r_n;
				} else {
					$con = $tab."'$k' => '".addslashes($v)."',".$_r_n;
				}
			}
		}
		return $con;
	}

	// 将数组转换成input隐藏域
	public static function ary_input ($ary, $key='') {
		$inp = '';
		if (is_array($ary)) {
			foreach ($ary as $k => $v) {
				$kk = $key ? $key.'['.$k.']' : $k;
				$inp .= self::ary_input($v, $kk);
			}
		}
		else if ($key) {
			$inp .= "<textarea name='$key' hide>$ary</textarea>";
		}
		return $inp;
	}
	// 将数组拼接成 set.manage.edit
	public static function ary_splice ($arr, $key='') {
	    $key = $key ? $key.'.' : '';
	    $key_str = '';
	    foreach ((array)$arr as $k => $v) {
	        $kk = $key.$k;
	        if (is_array($v)) {
	            $key_str .= self::ary_splice($v, $kk);
	        }
	        else {
	        	$key_str .= $kk.',';
	        }
	    }
	    return $key_str;
	}
	/*
	 * 将数组全部转成小写
	 * @param {array} $arr 一个数组
	 * @return {array|string}
	 */
	public static function ary_tolower ($arr) {
	    foreach ($arr as $k => $v) {
	    	$k = strtolower($k);
	        if (is_array($v)) {
	            $arr[$k] = self::ary_tolower($v);
	        }
	        else {
	        	$arr[$k] = strtolower($v);
	        }
	    }
	    return $arr;
	}
	/*
	 * 数组遍历成 html
	 * @param {array} $ary 数组
	 * @return {string}
	 */
	public static function ary_html ($ary, $num=0) {
		$tr = '';
		foreach ($ary as $k => $v) {
			$is_ary = is_array($v);
			$pad = 0;
			for ($i=0; $i<$num; $i++) {
				$pad+=30;
			}
			$tr .= '<div style="padding-left:'.$pad.'px" dept="'.$i.'">';
				$tr .= $k.($is_ary||!$v?'':'&nbsp;:&nbsp;'.$v);
			$tr .= '</div>';
			if ($is_ary) {
				$tr .= self::ary_html($v, $num+1);
			}
		}
		return $tr;
	}

	// 合并多维数组
	// 将数组 arr2 覆盖到 arr1 里面
	public static function ary_merge ($arr1, $arr2) {
		if (!is_array($arr1) || !is_array($arr2)) {
			return $arr1;
		}
		foreach ($arr2 as $k1 => &$v1) {
			if (is_array($v1) && $arr1[$k1] && is_array($arr1[$k1])) {
				$arr1[$k1] = self::ary_merge($arr1[$k1], $v1);
			} else {
				$arr1[$k1] = $v1;
			}
		}
		return $arr1;
	}
	// 将数组 arr2 覆盖到 arr1 里面
	public static function ary_cover ($arr1, $arr2) {
		if (!is_array($arr1)) {
			return $arr1;
		}
		$arr2 = (array)$arr2;
		foreach ($arr1 as $k1 => &$v1) {
			if (isset($arr2[$k1])) {
				$v2 = $arr2[$k1];
				if (is_array($v1) && is_array($v2)) {
					$v1 = self::ary_merge($v1, $v2);
				} else {
					$v1 = $v2;
				}
			}
		}
		return $arr1;
	}
}