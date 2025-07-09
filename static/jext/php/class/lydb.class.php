<?php

class lydb{
	public static $link='';
	public static $sqli=0;
	public static $host='';
	public static $port='';
	public static $user='';
	public static $charset='';
	public static $password='';
	public static $database='';
	public static $cur_database='';
	public static $result='';
	public static $record=array();
	public static $code=0;
	public static $mysql='';
	
	public static function connect () {	//连接数据库
		if (function_exists('mysqli_connect')) {
			self::$sqli=1;
			self::$link=mysqli_connect(self::$host, self::$user, self::$password, self::$port);
			self::$link||self::halt_msg('数据库连接失败',1);
			mysqli_set_charset(self::$link, self::$charset)||self::halt_msg('charset设置错误');
			mysqli_select_db(self::$link, self::$database)||self::halt_msg('未找到数据库'.self::$database);
		}else{
			self::$link=mysql_connect(self::$host.':'.self::$port, self::$user, self::$password);
			self::$link||self::halt_msg('无法链接数据库，请检查数据库链接配置文件！');
			mysql_select_db(self::$database)||self::halt_msg('无法选择数据库，请检查数据库名称是否正确！');
			self::$charset && mysql_query("set names '".self::$charset."'");
			mysql_query('set sql_mode=""');
		}
	}
	
	public static function use_default () {	//重新调用默认数据库
		self::$cur_database = self::$database;
		self::query("USE ".self::$database);
	}
	public static function use_database ($database) {	//重新调用默认数据库
		self::$cur_database = $database;
		self::query("USE ".$database);
	}
	
	public static function result ($res='', $key='') {	//返回记录集
		if (is_string($res) && $res) {
			if (!preg_match('/\\s(limit)\\s/is', $res) && preg_match('/^(\\s)*select/is', $res)) $res = $res . ' limit 0, 1';
			$result = self::query($res);
		} else {
			$result = $res ? $res : self::$result;
		}
		if (self::$sqli) {
			self::$record=mysqli_fetch_assoc($result);
		}
		else {
			self::$record=mysql_fetch_assoc($result);
		}
		self::$record || self::$record = array();
		if ($key) return self::$record[$key];
		else return self::$record;
	}
	
	public static function halt_msg($msg,$type=0){	//消息提示
		if(self::$sqli){
			if($type) exit("{$msg}<br>错误代码： ".mysqli_connect_errno().':'.mysqli_connect_error());
			else exit("{$msg}<br>错误代码： ".mysqli_errno(self::$link).':'.mysqli_error(self::$link));
		}else{
			exit($msg.'<br>错误代码：<i>#'.mysql_errno(self::$link).'</i> - '.mysql_error(self::$link));
		}
	}
	
	public static function query ($sql, $res=0) {	//直接执行SQL语句
		self::$mysql = $sql;
		self::$link||self::connect();
		if(self::$sqli){
			self::$result=mysqli_query(self::$link, $sql);
			self::$result||self::halt_msg($sql.'<br>连接数据表错误');
		}else{
			self::$result=mysql_query($sql, self::$link);
			self::$result||self::halt_msg('SQL语句出错：'.$sql);
		}
		return self::$result;
	}
	
	public static function sql($sql, $key=''){
		self::query($sql);
		$a = array();
		while ($v = self::result()) {
			if ($key) {
				$a[$v[$key]] = $v;
			} else {
				$a[] = $v;
			}
		}
		return $a;
	}
	public static function all($sql, $key=''){
		return self::sql($sql, $key);
	}
	/**
	 * 获取模板数据
	 * @param {string} $type 查询类型
	 * @param {string} $cfg 绑定数据表
	 * @return {string}
	 */
	public static $_get_data_cache = array();
	public static function get($name, $_get_data=array()){
		$name = explode('::', $name);
		$__module_file = c('root').self::$_get_module_config['backup'].$name[0].'.'.$name[1].'.txt';
		if (self::$_get_module_config['use'] && is_file($__module_file)) {
			$row = file_get_contents($__module_file);
			$row = str_replace('Path000', self::$_get_module_config['path'], $row);
			$row_str_0 = substr($row,0,1);
			if ($row_str_0=='{'||$row_str_0=='[') {
				$row = str::json($row, 'decode');
			}
		} else if (method_exists($name[0], $name[1])) {
			$row = call_user_func($name[0].'::'.$name[1], $_get_data);
			if ($row && self::$_get_module_config['create']) { //数据模板备份
				file::mkdir(c('root').self::$_get_module_config['files']);
				self::backup_module_data($row);
				file_put_contents($__module_file, is_array($row)?str::json($row):$row);
			}
		}
		return $row;
	}
	public static $_get_module_config = array(); //数据模板备份
	public static function set_module_data($config){
		if ($config['path']) {
			$config['path'] = '/'.trim($config['path'], '/').'/';
			self::$_get_module_config['path'] = $config['path'];
			self::$_get_module_config['backup'] = $config['path'].'.backup/';
			self::$_get_module_config['files'] = $config['path'].'.backup/files/';
			self::$_get_module_config['Path000'] = 'Path000/.backup/files/';
			self::$_get_module_config['use'] = !$config['create'] && $config['use'];
			self::$_get_module_config['create'] = $config['create'];
			if ($config['clear'] && self::$_get_module_config['path']) {
				file::rmdir(self::$_get_module_config['backup']);
			}
		} else {
			self::$_get_module_config = array();
		}
	}
	public static function clear_module_data(){
		self::$_get_module_config = array();
	}
	public static function backup_module_data(&$row){
		if (is_array($row)) {
			foreach ($row as $k => $v) {
				self::backup_module_data($row[$k]);
			}
		} else {
			// 配出本地图片，并复制到模板备份里面
			preg_match_all("/[^a-zA-Z0-9_]?([\\\\\/]file[\\\\\/][a-zA-Z0-9_\\/\\-\\. !@#$%^&*\(\)\\\+]*\.(gif|jpe?g|png|bmp|webp))/isU", $row.$row, $images);
			if ($images[1]) {
				$find_str = array();
				$replace_str = array();
				foreach ($images[1] as $v) {
					$file = preg_replace("/[\/]+/", '/', str_replace('\\', '/', $v));
					if (is_file(c('root').$file)) {
						$file_name = basename($file);
						$copy_file = self::$_get_module_config['files'].$file_name;
						copy(c('root').$file, c('root').$copy_file);
						$find_str[] = $v;
						$replace_str[] = self::$_get_module_config['Path000'].$file_name;
					}
				}
				$row = str_replace($find_str, $replace_str, $row);
				$row = preg_replace("/[\\\]+Path000/", 'Path000', $row);
			}
		}
	}
	/**
	 * 获取排序方式
	 * @param {string} $type 排序类型 new:最新   hot:热门
	 * @param {string} $table 绑定数据表
	 * @return {string}
	 */
	public static $orderby_name = array('new','desc','asc','old','hot');
	public static function get_order_by ($type='new', $table='') {
		if (strpos($type, '.')) {
			$t = explode('.', $type);
			$type = $t[1];
			$a = $t[0].'.';
		} else {
			$a = '';
		}
		$ary = array(
			'desc' => $a.'MyOrder asc,'.$a.'AddTime desc,'.$a.'Id desc', //最新
			'new' => $a.'MyOrder asc,'.$a.'AddTime desc,'.$a.'Id desc', //最新
			'asc' => $a.'MyOrder asc,'.$a.'AddTime asc,'.$a.'Id asc', //时间最小
			'old' => $a.'MyOrder asc,'.$a.'Id asc', //id排序
			'hot' => $a.'MyOrder asc,'.$a.'data_number_views desc,'.$a.'Id desc', //热门
		);
		return $ary[$type] ? $ary[$type] : $ary['new'];
	}
	/**
	 * 排序下拉
	 * @param {int} $myorder 排序编号
	 * @return {string}
	 */
	public static function my_order ($myorder) {
		$opt = "<option value='10000'>".language('{/global.default/}')."</option>";
		for ($i=1; $i<=70; $i++) {
			$sel = $myorder==$i?'selected':'';
			$opt .= "<option value='{$i}' {$sel}>{$i}</option>";
		}
		return $opt;
	}
	/**
	 * 获取查询条件
	 * @param {string} $table 绑定数据表
	 * @param {string} $type 提交类型，GET    POST
	 * @return {string}
	 */
	public static function get_where ($table='wb_news', $type='GET') {
		if (strtolower($type)=='get') $ary = $_GET;
		else $ary = $_POST;
		$fields = db::fields($table, 'strtolower');
		$init = array('cateid'=>'cid');
		$where = '1=1 ';
		foreach ($fields as $k => $v) {
			$a = $ary[$k];
			$a || $a = $ary[$init[$k]];
			if ($a) {
				// like   in   find_in_set 查询
				if (preg_match('/^\\./', $a)) {
					$is_like = preg_match('/^\\.(.*)[^\\.]\\.$/', $a);
					$is_find_in_set = preg_match('/^\\.(.*)\\.\\.$/', $a);
					$a = explode('..', str_replace(array('. .', '.+.'), '..', $a));
					$w = '';
					foreach ($a as $k1 => $v1) {
						if ($is_like||$is_find_in_set) {
							$v1 = explode(',', $v1);
							$w1 = '';
							$k2 = 0;
							foreach ($v1 as $v2) {
								$v2 = trim($v2, '.');
								if (!$v2) continue;
								if ($is_like) $w1 .= ($k2?' or ':'')." {$k} like '%{$v2}%'";
								else $w1 .= ($k2?' or':'')." find_in_set('{$v2}', {$k})";
								$k2++;
							}
							$w1 && $w .= " and ($w1)";
						}
						else {
							$v1 = str_replace(',', "','", $v1);
							$v1 && $w .= " and {$k} in($v1)";
						}
					}
					$w && $where .= $w;
				}
				// =
				else {
					$where .= " and {$k}='{$a}'";
				}
			}
		}
		// 关键词
		$keywords = $_GET['keywords'];
		$k_w = '';
		if ($keywords && $fields[ln('name')]) $k_w .= " or ".ln('Name')." like '%$keywords%'";
		if ($keywords && $fields[ln('brief')]) $k_w .= " or ".ln('Brief')." like '%$keywords%'";
		if ($keywords && $fields[ln('briefdescription')]) $k_w .= " or ".ln('BriefDescription')." like '%$keywords%'";
		$k_w && $where .= "and (".ltrim($k_w, ' or ').")";
		return $where;
	}
	
	public static function get_all ($table, $where=1, $field='*', $order=1) {	//返回整个数据表
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		self::query("select $field from $table where $where order by $order");
		$result = array();
		while (self::result()) {
			$result[] = self::$record;
		}
		return $result;
	}
	public static function get_whole ($table, $where=1, $field='*', $order=1) {	//返回整个数据表
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		self::query("select $field from $table where $where order by $order");
		$result = array('row'=>array(), 'ids'=>'0');
		while (self::result()) {
			$result['row'][] = self::$record;
			$result['ids'] .= ','.self::$record['Id'];
		}
		return $result;
	}


	public static function get_id_key($table, $where=1, $id='Id', $field='*', $order=1, $start_row=0, $row_count=0){	//以ID为下标
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		if($row_count){
			self::query("select $field from $table where $where order by $order limit $start_row, $row_count");
		}
		else {
			self::query("select $field from $table where $where order by $order");
		}
		$result=array();
		while(self::result()){
			if (isset($result[self::$record[$id]])) $result[self::$record[$id]]['DbCPArray'][]=self::$record;
			else{
				$result[self::$record[$id]]=self::$record;
			}
		}
		return $result;
	}
	
	public static function get_limit($table, $where=1, $field='*', $order=1, $start_row=0, $row_count=20){	//分页返回记录
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		$row_count || $row_count = 1;
		self::query("select $field from $table where $where order by $order limit $start_row, $row_count");
		$result=array();
		while(self::result()){
			$result[]=self::$record;
		}
		return $result;
	}
	/**
	 * 高级形式分页返回记录
	 * @param {string} $table 表名称
	 * @param {string} $where 查询条件
	 * @param {string} $field 查询字段
	 * @param {string} $order 排序方式
	 * @param {string} $page 当前页面
	 * @param {string} $page_count 每一页显示的个数
	 * @param {string|array} $type 分页样式类型，或者为数组时变成分页参数
	 * @return {array} 多维数组
	 */
	public static function get_limit_page($table, $where=1, $field='*', $order=1, $page=1, $page_count=20, $type=''){
		$page_ary = array();
		if (is_array($type)) {
			$page_ary = $type;
		}
		else {
			$page_ary['type'] = $type;
		}
	    $paging = page::html($page_ary, array(
	        'limit' => $page_count,
	        'page'  => $page,
	        'total' => db::get_row_count($table, $where)
	    ));
	    $paging['row'] = db::get_limit($table, $where, $field, $order, $paging['start'], $paging['limit']);
		return $paging;
	}
	
	public static function get_prev_next($v, $table, $where=1, $field='*'){	//上下页
        $prev=db::get_one($table, $where." and MyOrder='{$v['MyOrder']}' and AddTime='{$v['AddTime']}' and Id>'{$v['Id']}'", '*', 'Id asc');
        $prev||$prev=db::get_one($table, $where." and MyOrder='{$v['MyOrder']}' and AddTime>'{$v['AddTime']}'", '*', 'AddTime asc');
        $prev||$prev=db::get_one($table, $where." and MyOrder<'{$v['MyOrder']}'", '*', 'MyOrder desc,AddTime asc');
        $next=db::get_one($table, $where." and MyOrder='{$v['MyOrder']}' and AddTime='{$v['AddTime']}' and Id<'{$v['Id']}'", '*', 'Id desc');
        $next||$next=db::get_one($table, $where." and MyOrder='{$v['MyOrder']}' and AddTime<'{$v['AddTime']}'", '*', 'AddTime desc');
        $next||$next=db::get_one($table, $where." and MyOrder>'{$v['MyOrder']}'", '*', 'MyOrder asc, AddTime desc');
        return array($prev, $next);
	}
	
	public static function get_one($table, $where=1, $field='*', $order=1){	//返回一条记录
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		self::query("select $field from $table where $where order by $order limit 1");
		return (array)self::result();
	}
	
	public static function get_rand($table, $where=1, $field='*', $id_field, $row_count=1){	//返回随机N条记录
		self::query("select $field from $table as t1 join(select round(rand()*((select max($id_field) from $table where $where)-(select min($id_field) from $table where $where))+(select min($id_field) from $table where $where)) as $id_field) as t2 where t1.$id_field>=t2.$id_field and $where order by t1.$id_field asc limit $row_count");
		$result=array();
		while(self::result()){
			$result[]=self::$record;
		}
		return $result;
	}
	
	public static function get_in_value($table, $where=1, $field, $order=1){	//返回 数据库字段内容，以逗号“,”隔开
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		self::query("select $field from $table where $where order by $order");
		while(self::result()){
			$result.="','" . addslashes(self::$record[$field]);
		}
		$result=ltrim($result,"','");
		return $result?"'{$result}'":'';
	}
	
	public static function get_value($table, $where=1, $field, $order=1){	//返回一个字段值
		if (in_array($order, self::$orderby_name)) {
			$order = self::get_order_by($order, $table);
		}
		self::query("select $field from $table where $where order by $order limit 1");
		self::result();
		$result=self::$record;
		return $result[$field];
	}
	
	public static function get_row_count($table, $where=1){	//返回总记录数
		self::query("select count(*) as row_count from $table where $where");
		if(substr_count(strtolower($where), 'group by')){
			return mysqli_num_rows(self::$result);
		}else{
			self::result();
			$result=self::$record;
			return $result['row_count'];
		}
	}
	
	public static function get_sum($table, $where=1, $field){	//回返合计值
		self::query("select sum($field) as sum_count from $table where $where");
		self::result();
		$result=self::$record;
		return $result['sum_count'];
	}
	
	public static function get_max($table, $where=1, $field){	//返回最大的值
		self::query("select max($field) as max_value from $table where $where");
		self::result();
		$result=self::$record;
		return $result['max_value'];
	}
	/**
	 * 最后一次操作关联ID号
	 * @return {int}
	 */
	public static function get_insert_id () {
		return mysqli_insert_id(self::$link);
	}
	/**
	 * 订单生成器
	 * @param {string} $tables 表名，多个表以逗号隔开
	 * @param {string} $field 字段名
	 * @param {string} $type 类型，time:按时间随机，string:按字符随机
	 * @param {string} $prefix 前缀
	 * @return {string}
	 */
	public static function randcode ($tables, $field='OrderNumber', $type='time', $prefix='LY') {
		$tables = array_unique(array_filter(explode(',', $tables)));
		while (1) {
			if ($type=='default') $num = strtoupper(str::rand(12));
			else if ($type=='string') $num = strtoupper(str::rand(12, 'string'));
			else if ($type=='number') {
				if ($az) {
					$az = (int)$az;
				} else {
					$az = @(int)str_replace($prefix, '', db::get_value($tables[0], "1=1", $field, $field." desc"));
				}
				$az = sprintf("%05d", $az+1);
				$num = $prefix.$az;
			} else $num = date('YmdHis').rand(10,99);
			$has = 0;
			foreach ($tables as $v) {
				$has = db::get_row_count($v, "{$field}='{$num}'");
				if ($has) break;
			}
			if (!$has) break;
		}
		return $num;
	}
	/**
	 * 返回数据表字段
	 * @param {string} $table 表名
	 * @param {string} $type 默认空，strtolower:全部下标小写
	 * @return {string}
	 */
	public static function fields ($table, $type='') {
		$f = self::query("show columns from $table");
		$fi = array();
		if ($type=='strtolower') {
			while ($v = self::result($f)) {
				$fi[strtolower($v['Field'])] = $v;
			}
		}
		else {
			while ($v = self::result($f)) {
				$fi[$v['Field']] = $v;
			}
		}
		return $fi;
	}
	/**
	 * 判断表是否存在
	 * @param {string} $table 表名
	 * @param {string} $dbname 数据库名称
	 * @return {bool}
	 */
	public static $table_ary = array();
	public static function has_table ($table, $dbname='') {
		if (!$table) {
			return 0;
		}
		$dbname || $dbname = self::$cur_database;
		if (!$dbname) {
			return 0;
		}
		if (!self::$table_ary[$dbname]) {
			$has = self::query("show tables from `".$dbname."`");
			$tbl = array();
			while ($v = self::result($has)) {
				$tbl[] = reset($v);
			}
			self::$table_ary[$dbname] = $tbl;
		}
		return in_array($table, self::$table_ary[$dbname]);
	}
	
	// 编辑器
	public static function detail ($table, $Id, $name='') {
		return self::editor($table, $Id, $name);
	}
	public static function editor ($table, $Id, $name='') {
		$Id = (int)$Id;
		$dbname = '';
		if (strpos($table,'.')!==false) {
			$tables = explode('.', $table);
			$table = $tables[1];
			$dbname = $tables[0];
		}
		$tbl = $dbname.($dbname?'.':'').$table."_detail";
		if (self::has_table($tbl, $dbname)) {
			$where = "ExtId='$Id'";
			if ($name) {
				$res = self::result("select * from {$tbl} where $where and Name='$name'",'Detail');
			} else {
				$detail = self::all("select * from {$tbl} where $where");
				foreach ($detail as $k=>$v) {
					$res[$v['Name']] = $v['Detail'];
				}
			}
		}
		if (!$res) {
			$tbl = $dbname.($dbname?'.':'')."data_editor";
			$where = "ExtTable='$table' and ExtId='$Id'";
			if ($name) {
				$res = self::result("select * from {$tbl} where $where and Name='$name'",'Contents');
			} else {
				$detail = self::all("select * from {$tbl} where $where");
				foreach ($detail as $k=>$v) {
					$res[$v['Name']] = $v['Detail'];
				}
			}
		}
		return $res;
	}
	// 编辑器
	public static function detail_mod ($table, $Id, $name, $contents) {
		return self::editor_mod($table, $Id, $name, $contents);
	}
	public static function editor_mod ($table, $Id, $name, $contents) {
		$Id = (int)$Id;
		if (!$table || !$Id || !$name) {
			return 0;
		}
		$dbname = '';
		if (strpos($table,'.')!==false) {
			$tables = explode('.', $table);
			$table = $tables[1];
			$dbname = $tables[0];
		}
		$tbl = $dbname.($dbname?'.':'').$table."_detail";
		if (!self::has_table($tbl, $dbname)) {
			db::query("
				create table if not exists ".$tbl." (
				  `Id` int(11) not null AUTO_INCREMENT,
				  `ExtId` int(11) default '0',
				  `Name` varchar(50) default '',
				  `Detail` longtext,
				  PRIMARY KEY (`Id`),
				  KEY `ExtId` (`ExtId` asc)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
		}
		$where = "ExtId='$Id' and Name='$name'";
		$i = self::result("select Id from {$tbl} where $where",'Id');
		if ($i) {
			db::update($tbl, "Id=$i", array('Detail'=>$contents));
		}
		else {
			$i = db::insert($tbl, array(
				'ExtId'		=>	$Id,
				'Name'		=>	$name,
				'Detail'	=>	$contents
			));
		}
		return $i;
	}

	// 
	public static function log_id($name, $table, $id, $type=''){
		self::create_log($name, $table);
		$ex_na = $table.'_id';
		$data_table = $table.'_'.$name.'_log';
		$where = "{$ex_na}='{$id}'";
		if (member('Id')) {
			$where .= " and wb_member_id='".member('Id')."'";
		} else {
			$where .= " and session_id='".c('session_id')."'";
		}
		$a = db::result("select Id,AddTime from `$data_table` where $where");
		if ($a) {
			db::delete($data_table, $where);
			$number = -1;
		} else {
			db::insert($data_table, array(
				"$ex_na" => $id,
				'AddTime' => c('time'),
				'Ip' => ip::get(),
				'wb_member_id' => member('Id'),
				'session_id' => c('session_id')
			));
			$number = 1;
		}
		$data = self::number($name, $table, $id, $number, $type, $a['AddTime']);
		if ($number>0) {
			$data['is_insert'] = true;
		} else {
			$data['is_delete'] = true;
		}
		return $data;
	}
	// 
	public static function delete_log_id($name, $table, $id, $type=''){
		self::create_log($name, $table);
		$ex_na = $table.'_id';
		$data_table = $table.'_'.$name.'_log';
		$where = "{$ex_na}='{$id}'";
		if (member('Id')) {
			$where .= " and wb_member_id='".member('Id')."'";
		} else {
			$where .= " and session_id='".c('session_id')."'";
		}
		$a = db::result("select Id,AddTime from `$data_table` where $where");
		if ($a) {
			db::delete($data_table, $where);
			$number = -1;
			$data = self::number($name, $table, $id, $number, $type, $a['AddTime']);
			$data['is_delete'] = true;
			return $data;
		} else {
			return array('is_delete'=>true);
		}
	}
	// 
	public static function create_log($name, $table){
		$ex_na = $table.'_id';
		$data_table = $table.'_'.$name.'_log';
		if (!db::has_table($data_table)) {
			db::query("
				CREATE TABLE IF NOT EXISTS `$data_table` (
				  `Id` int(11) NOT NULL AUTO_INCREMENT,
				  `session_id` varchar(32) DEFAULT '',
				  `wb_member_id` int(11) DEFAULT '0',
				  `{$ex_na}` int(11) DEFAULT '0',
				  `Ip` varchar(15) DEFAULT '',
				  `AddTime` int(11) DEFAULT '0',
				  PRIMARY KEY (`Id`),
				  KEY `wb_member_id` (`wb_member_id`),
				  KEY `{$ex_na}` (`{$ex_na}`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			");
		}
	}
	// 记录次数
	// db::number('ups', 'wb_news', $id, 1, 'day week month year');
	public static function number($name='', $table, $id=0, $number=1, $type='', $time=0){
		$type = explode(' ', $type);
		$ex_na = $table.'_id';
		$data_table = $table.'_data_number_'.$name;
		if (!db::has_table($data_table)) {
			db::query("
				CREATE TABLE IF NOT EXISTS `$data_table` (
				  `Id` int(11) NOT NULL AUTO_INCREMENT,
				  `Number` int(11) DEFAULT '0',
				  `{$ex_na}` int(11) DEFAULT '0',
				  `DayTime` varchar(20) DEFAULT '',
				  PRIMARY KEY (`Id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
			");
		}
		// 统计数据
		$time || $time = c('time');
		$day = date('Y-m-d',$time);
		$data_name = 'data_number_'.$name;
		$a = db::result("select Id, Number from `$data_table` where `{$ex_na}`='{$id}' and DayTime='$day'");
		if ($a) {
			$a['Number'] += $number;
			db::update($data_table, "Id='{$a['Id']}'", array('Number'=>$a['Number']));
		} else {
			db::insert($data_table, array(
				'Number' => $number,
				$ex_na => $id,
				'DayTime' => $day
			));
		}
		$data = array(
			$data_name => (int)db::result("select sum(Number) as a from $data_table where `{$ex_na}`='$id'", 'a'),
		);
		if (in_array('day', $type)) {
			$day = date('Y-m-d');
			$data_name_day = 'data_number_'.$name.'_day';
			$data[$data_name_day] = (int)db::result("select sum(Number) as a from $data_table where `{$ex_na}`='$id' and DayTime='$day'", 'a');
		}
		if (in_array('week', $type)) {
			$week = date('Y-m-d', strtotime('-1 week monday'));
			$data_name_week = 'data_number_'.$name.'_week';
			$data[$data_name_week] = (int)db::result("select sum(Number) as a from $data_table where `{$ex_na}`='$id' and DayTime>'$week'", 'a');
		}
		if (in_array('month', $type)) {
			$month = date('Y-m-01');
			$data_name_month = 'data_number_'.$name.'_month';
			$data[$data_name_month] = (int)db::result("select sum(Number) as a from $data_table where `{$ex_na}`='$id' and DayTime>'$month'", 'a');
		}
		db::update($table, "Id='$id'", $data);
		return $data;
	}
	/**
	 * SEO
	 * @param {string} $table 数据表 或者 类型
	 * @param {int} $Id 对应的数据id
	 * @return {array}
	 */
	public static function seo ($table, $Id=0) {
		$Id = (int)$Id;
		$dbname = '';
		if (strpos($table,'.')!==false) {
			$tables = explode('.', $table);
			$table = $tables[1];
			$dbname = $tables[0];
		}
		if (!$Id) {
			$type = $table;
			$table = 'wb_seo_list';
		}
		$tbl = $dbname.($dbname?'.':'').$table."_tdk";
		if (self::has_table($table."_tdk", $dbname)) {

			if ($Id) {
				$where = "ExtId='$Id'";
			}
			else {
				$where = "Type='$type'";
			}
			$res = self::result("select * from {$tbl} where $where");
		}
		return $res;
	}
	// 修改seo
	public static function seo_mod ($table, $Id, $array) {
		$Id = (int)$Id;
		$dbname = '';
		if (strpos($table,'.')!==false) {
			$tables = explode('.', $table);
			$table = $tables[1];
			$dbname = $tables[0];
		}
		$tbl = $dbname.($dbname?'.':'').$table."_tdk";
		if (!self::has_table($tbl, $dbname)) {
			db::query("
				create table if not exists ".$tbl." (
				  `Id` int(11) not null AUTO_INCREMENT,
				  `ExtId` int(11) default '0',
				  `Type` varchar(80) default '',
				  PRIMARY KEY (`Id`),
				  KEY `ExtId` (`ExtId` asc)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
			");
		}
		$fields = self::fields($tbl);
		if (!$fields['IsMonolingual']) {
			db::query("alter table ".$tbl." add `IsMonolingual` int(1) default '0'");
		}
		if (!$fields['SeoTitle']) {
			db::query("alter table ".$tbl." add `SeoTitle` varchar(250) default ''");
			db::query("alter table ".$tbl." add `SeoKeyword` varchar(250) default ''");
			db::query("alter table ".$tbl." add `SeoDescription` varchar(500) default ''");
		}
		foreach (c('language') as $v) {
			$data_name = 'SeoTitle_'.$v;
			if (!$fields[$data_name]) {
				db::query("alter table ".$tbl." add `$data_name` varchar(250) default ''");
			}
			$data_name = 'SeoKeyword_'.$v;
			if (!$fields[$data_name]) {
				db::query("alter table ".$tbl." add `$data_name` varchar(250) default ''");
			}
			$data_name = 'SeoDescription_'.$v;
			if (!$fields[$data_name]) {
				db::query("alter table ".$tbl." add `$data_name` varchar(500) default ''");
			}
		}
		$where = "ExtId='$Id'";
		$array['ExtId'] = $Id;
		$i = self::result("select Id from {$tbl} where $where", 'Id');
		if ($i) {
			db::update($tbl, "Id=$i", $array);
		} else {
			$i = db::insert($tbl, $array);
		}
		return $i;
	}
	
	//插入记录
	public static function insert ($table, $data) {
		foreach($data as $field => $value){
			$fields.="`$field`,";
			$values.="'$value',";
		}
		$fields=substr($fields, 0, -1);
		$values=substr($values, 0, -1);
		self::query("insert into $table($fields) values($values)");
		return mysqli_insert_id(self::$link);
	}
	//批量插入记录
	public static function insert_bat ($table, $data) {
		if ($data) {
			$field='`'.implode('`,`', array_keys(current($data))).'`';
			$value=array();
			foreach($data as $v){
				$value[]="'".implode("','", $v)."'";
			}
			$value=implode('),(', $value);
			self::query("insert into $table($field) values($value)");
		}
	}
	//批量修改记录
	public static function update_bat ($table, $w_name, $data) {
		if ($data) {
			$field='`'.implode('`,`', array_keys(current($data))).'`';
			$value=array();
			$id_array = array();
			$w_name_where = '';
			foreach($data as $id => $ary){
				$w_id = addslashes($ary[$w_name]?:$id);
				$w_name_where .= ",'$w_id'";
				foreach ($ary as $name => $val) {
					$id_array[$name] || $id_array[$name] = array();
					$id_array[$name][$w_id] = $val;
				}
			}
			$w_name_where = ltrim($w_name_where, ',');
			$case_str = '';
			foreach ($id_array as $k => $v) {
				$when = '';
				foreach ($v as $k1 => $v1) {
					$when .= " when '{$k1}' then '$v1'";
				}
				if ($when) $case_str .= ",`$k`=(case `$w_name` $when end)";
			}
			$case_str = trim($case_str, ',');
			if ($w_name_where) self::query("update $table set $case_str where `$w_name` in($w_name_where)");
		}
	}

	//更新数据表
	public static function update($table, $where=0, $data){
		foreach ($data as $field => $value) {
			$upd_data.="`$field`='$value',";
		}
		$upd_data=substr($upd_data, 0, -1);
		self::query("update $table set $upd_data where $where");
	}
	
	public static function get_sql(){	//返回最后一条SQL语句
		return self::$sql;
	}
	
	public static function fetch($sql){	//执行sql直接返回结果数组
		self::query($sql);
		$result = array();
		while(self::result()){
			$result[]=self::$record;
		}
		return $result;
	}
	
	public static function get_records(){//返回更新或删除的受影响记录数
		$result = self::fetch('SELECT ROW_COUNT() AS `r`');
		return $result[0]['r'];
	}
	
	public static function delete($table, $where=0){	//删除数据
		self::query("delete from $table where $where");
	}
	
	public static function lock($table, $method='write'){	//锁定表
		self::query("lock tables $table $method");
	}
	
	public static function unlock(){	//解除锁定表
		self::query('unlock tables');
	}
	
	public static function close(){	//关闭数据库连接
		if(self::$link && self::$sqli){
			mysqli_close(self::$link);
		}else if(self::$link){
			mysql_close(self::$link);
		}
		self::$link='';
	} 
	/**
	 * 分类的整理
	 * @param {string} $field 字段名，用于做判断，对比
	 * @param {string} $value 选中的值
	 * @param {string} $table 数据表名称
	 * @param {string} $where 条件
	 * @param {string} $type 类型
	 * @return {array}
	 */
	public static function category ($field='Id', $value, $table, $where='Dept<4', $type='select') {
		$category = self::get_category($table, $where, '*', 'MyOrder asc, Id asc');
		if ($type=='select') {
			return self::category_s($category, $field, $value, $PreChars, $category['uid']);
		}
		return '';
	}
	public static function category_s ($category, $field, $value, $PreChars='', $uid='0,') {
		if (!$category[$uid]) {
			return '';
		}
		$s = '';
		$count = count($category[$uid])-1;
		foreach ($category[$uid] as $k=>$v) {
			$u = $v['UId'].$v['Id'].',';
			if ($field=='UId') {
				$val = $u;
			} else {
				$val = $v[$field];
			}
			$sel = $val==$value?'selected':'';
			$pre = str_replace(' ', '&nbsp;', $PreChars.($k==$count?'└':'├'));
			$prc = $PreChars.($k==$count?'    ':'│');   //前导符
			$s .= "<option value='$val' $sel dept='{$v['Dept']}'>".$pre.($v[ln('Name')]?$v[ln('Name')]:$v['Name'])."</option>".self::category_s($category, $field, $value, $prc, $u);
		}
		return $s;
	}
	/**
	 * 获取全部分类
	 * @param {string} $table 数据表名称
	 * @param {string} $where 条件
	 * @param {string} $fields 字段
	 * @param {string} $orderby 排序
	 * @return {array}
	 */
	public static $category_log = array();
	public static function get_category ($table, $where='1', $fields='*', $orderby='MyOrder asc, Id asc') {
		if (in_array($orderby, self::$orderby_name)) {
			$orderby = self::get_order_by($orderby, $table);
		}
		if (self::$category_log[$table.'-'.$where]) {
			return self::$category_log[$table.'-'.$where];
		}
		else {
			$category = array();
			self::query("select $fields from $table where $where order by Dept asc, $orderby");
			while ($v = self::result()) {
				$u = $v['UId'];
				$v['UId.Id'] = $v['UId'].$v['Id'].',';
				if (!$category['uid']) $category['uid']=$u;
				if (!$category[$u]) $category[$u] = array();
				$category[$u][] = $v;
				$category[$v['Id']] = $v;
				$u_ = explode(',', $u);
				$u__ = '';
				if (!$category['id'][$v['UId.Id']]) $category['id'][$v['UId.Id']]=$v['Id'];
				foreach ($u_ as $uk => $uv) {
					$u__ .= $uv.',';
					if ($uv) {
						// if (!$category['id'][$u__]) $category['id'][$u__]=$uv;
						$category['count'][$u__]++;
						$category['id'][$u__].=','.$v['Id'];
					}
				}
			}
			self::$category_log[$table.'-'.$where] = $category;
			return $category;
		}
	}
	/*public static function get_category_ary ($table, $idary) {
		$row = db::get_category($table);
		foreach ($row['0,'] as $k => $v) {
			// 
		}
	}*/
	/**
	 * 获取分类下包含的id
	 * @param {string} $table 数据表名称
	 * @param {string|int} 数据ID或者UId
	 * @return {string} 0,1,2,3
	 */
	public static function get_category_id ($table, $uid='0,') {
		if (is_numeric($uid)) {
			self::query("select Id from $table where find_in_set($uid, UId)");
		}
		else {
			self::query("select Id from $table where UId like '$uid%'");
		}
		$id = '0';
		while ($v = self::result()) {
			$id .= ','.$v['Id'];
		}
		return $id;
	}
	/**
	 * 分类名称
	 * @param {string|int} $id 分类id
	 * @param {array} $category 分类数据
	 * @return {string}
	 */
	public static function category_name ($id, $category) {
		$ids = is_array($id) ? $id : explode(',', $id);
		$id = '0';
		foreach ($ids as $v) {
			$id .= ','.(int)$v;
		}
		if (!is_array($category)) {
			$category = self::get_category($category);
		}
		$u = '';
		$category && $first = reset($category['0,']);
		$naa = $first[ln('Name')] ? ln('Name') : 'Name';
		foreach ($ids as $k => $v) {
			$uid = explode(',', $category[$v]['UId'].$v);
			$u .= "\r\n";
			foreach ($uid as $k1 => $v1) {
				if ($n = $category[$v1][$naa]) {
					$u .= ($k1>2 ? ' . ' : ($k1==2 ? ' : ' : '')).$n;
				}
			}
		}
		return ltrim($u, "\r\n");
	}
	/**
	 * 分类 - 产品属性整理
	 * @param {string|int} $id 分类id
	 * @param {array} $category 分类数据
	 * @return {string}
	 */
	public static function category_param ($id, $category) {
		$ids = is_array($id) ? $id : explode(',', $id);
		$id = '0';
		foreach ($ids as $v) {
			$id .= ','.(int)$v;
		}
		if (!is_array($category)) {
			$category = self::get_category($category);
		}
		$first = reset($category['0,']);
		$naa = $first[ln('Name')] ? ln('Name') : 'Name';
		$arr = array();
		foreach ($ids as $k => $v) {
			$uid = explode(',', $category[$v]['UId'].$v);
			foreach ($uid as $k1 => $v1) {
				if ($n = $category[$v1][$naa]) {
					if ($k1==1) {
						$na = $n;
						$arr[$na] = '';
					}
					else {
						$arr[$na] .= ($k1>3 ? ' . ' : '').$n;
					}
				}
			}
		}
		return str::json($arr);
	}
}
if (!c('lysaas_db_cfg')) {
	c('lysaas_db_cfg', c('db_cfg'));
}
lydb::$host=c('lysaas_db_cfg.host');
lydb::$port=c('lysaas_db_cfg.port');
lydb::$user=c('lysaas_db_cfg.username');
lydb::$password=c('lysaas_db_cfg.password');
lydb::$charset =c('lysaas_db_cfg.charset');
lydb::$database=lydb::$cur_database=c('lysaas_db_cfg.database');
?>