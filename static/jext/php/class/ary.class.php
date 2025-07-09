<?php
class ary{
	public static function row_together_by_field($data, $field){	//数组把第二维指定的下标相同的排在一起
		$new_data=$moved_key=array();
		foreach($data as $k=>$v){
			if(in_array($k, $moved_key)){continue;}
			$new_data[]=$v;
			for($i=$k+1; $i<count($data); $i++){
				if($data[$i][$field]==$v[$field]){
					$new_data[]=$data[$i];
					$moved_key[]=$i;
				}
			}
		}
		return $new_data;
	}
	
	public static function remove_password($data){	//删除密码
		foreach($data as $k=>$v){
			if(substr_count(strtolower($k), 'password')){
				$data[$k]='removed';
			}elseif(is_array($v)){
				$data[$k]=ary::remove_password($v);
			}
		}
		return $data;
	}
	
	public static function key_reset($data){	//把数组索引重置为从0开始
		$new_data=array();
		foreach($data as $k=>$v){
			$v=is_array($v)?ary::key_reset($v):$v;
			is_numeric($k)?$new_data[]=$v:$new_data[$k]=$v;
		}
		return $new_data;
	}
	
	public static function unset($data, $key){	//删除数组的指定下标
		$keys=!is_array($key)?explode(',', $key):$key;
		foreach($data as $k=>$v){
			if(in_array((string)$k, $keys)){
				unset($data[$k]);
			}elseif(is_array($v)){
				$data[$k]=ary::unset($v, $key);
			}
		}
		return $data;
	}
	
	public static function filter($data, $key, $value=''){	//返回数组指定下标包含指定值的新数组
		if($value==''){return $data;};
		!is_array($key) && $key=explode('|', $key);
		!is_array($value) && $value=explode('|', $value);
		foreach($data as $k=>$v){
			$unset=false;
			foreach($key as $k1=>$v1){
				if(is_array($v[$v1])){
					$data[$k]=ary::filter($v[$v1], $key, $value);
				}elseif(!in_array($v[$v1], explode(',', $value[$k1]))){
					$unset=true;
					break;
				}
			}
			if($unset){unset($data[$k]);}
		}
		return $data;
	}
	
	public static function compare_filter($data, $compare_condition='==', $compare_value=0, $flag=0){	//返回数组值或下标在指定条件内的新数组
		if(!is_array($data)){return $data;}
		global $par;
		$par=array($compare_condition, $compare_value, $flag);
		return array_filter($data, function(){
			global $par;
			$args=func_get_args();
			return @eval("return {$args[$par[2]]}{$par[0]}{$par[1]};");
		}, 1);
	}
	
	public static function filter_empty($data){	//删除数组中的空值
		if(!is_array($data)){return $data;}
		foreach($data as $k=>$v){
			is_array($v) && $data[$k]=ary::filter_empty($v);
		}
		return array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
	}
	
	public static function addition(){	//数组相同下标所有值相加
		$args=func_get_args();
		$key=array();
		foreach($args as $v){
			$key=array_merge($key, array_keys($v));
		}
		$key=array_unique($key);
		sort($key);
		$new_data=array();
		foreach($key as $v){
			foreach($args as $v1){
				$new_data[$v]+=$v1[$v];
			}
		}
		return $new_data;
	}
	
	public static function ranking($key, $data, $format='第%s名'){	//找出数据在数组中的排名
		$data=(array)$data;
		$value=(float)$data[$key];
		if($value==0){return '-----';}
		$data=array_unique($data);
		rsort($data);
		return sprintf($format, array_search($value, $data)+1);
	}
	
	
	public static function obj_to_ary($data){	//obj对象转数组
		is_object($data) && $data=(array)$data;
		if(!is_array($data)){return $data;}
		foreach($data as $k=>$v){
			$data[$k]=ary::obj_to_ary($v);
		}
		return $data;
	}


	//$return，0：字符串，1：数组，2：in查询语句，3：or查询语句，4：返回第一个值
	public static function format($data, $return=0, $unset='', $explode_char=',', $implode_char=','){
		!is_array($data) && $data=explode($explode_char, $data);
		foreach($data as $k=>$v){
			$data[$k]=trim($v);
		}
		$data=array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
		if($unset){
			$unset=ary::format($unset, 1, '', $explode_char, $implode_char);
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
	public static function change ($a, $b) {
		foreach ($b as $k => $v) {
			if (isset($a[$k])) {
				if (is_array($v)) {
					$a[$k] = self::change($a[$k], $v);
				}
			} else if (preg_match("/[^0-9]/", $k)) {
				$a[$k] = $v;
			}
		}
		return $a;
	}


	// 数组打印
	public static function dump ($row, $conf=array(), $hide=0) {
		if (!$row) return 'array();';
		if ($conf['compress']) {
			$_r_n = "";
		} else {
			$_r_n = "\r\n";
		}
		$tab='';
		$moduleCon = $hide?'':$tab."array(".$_r_n;
		foreach ($row as $k => $v) {
			$moduleCon .= self::dump_inside($tab."    ", $k, $v, $conf, 0, false);
		}
		$moduleCon .= $hide?'':$tab.")";
		return $moduleCon;
	}
	public static function dump_inside ($tab, $k, $v, $conf, $is_number=false) {
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
				$con1 .= self::dump_inside($tab.$sk, $k1, $v1, $conf, $v_is_number);
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
	public static function input ($ary, $key='') {
		$inp = '';
		if (is_array($ary)) {
			foreach ($ary as $k => $v) {
				$kk = $key ? $key.'['.$k.']' : $k;
				$inp .= self::input($v, $kk);
			}
		}
		else if ($key) {
			$inp .= "<textarea name='$key' hide>$ary</textarea>";
		}
		return $inp;
	}
	// 将数组拼接成 set.manage.edit
	public static function splice ($arr, $key='') {
	    $key = $key ? $key.'.' : '';
	    $key_str = '';
	    foreach ((array)$arr as $k => $v) {
	        $kk = $key.$k;
	        if (is_array($v)) {
	            $key_str .= self::splice($v, $kk);
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
	public static function tolower ($arr) {
	    foreach ($arr as $k => $v) {
	    	$k = strtolower($k);
	        if (is_array($v)) {
	            $arr[$k] = self::tolower($v);
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
	public static function html ($ary, $num=0) {
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
				$tr .= self::html($v, $num+1);
			}
		}
		return $tr;
	}

	// 合并多维数组
	public static function merge (&$arr1, &$arr2) {
		foreach ($arr1 as $k1 => &$v1) {
			foreach ($arr2 as $k2 => &$v2) {
				if ($k1 === $k2) {
					if (is_array($v1) && is_array($v2)) {
						$v1 = self::merge($v1, $v2);
					} else {
						$v1 = $v2;
					}
				}
			}
		}
		return $arr1 = array_merge($arr1, array_diff_key($arr2, $arr1));
	}

}
?>