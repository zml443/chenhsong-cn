<?php
namespace system;
use str;
use db;
use ly200;

class log{

	
	public static function operation($log){
		if ($_SESSION['Manage']['Id']==-1) return;
		$data = '';
		if ($_GET) {
			$get_data = array_filter($_GET);
			foreach ($get_data as $k => $v) {
				$get_data[$k] = substr_count(strtolower($k), 'password')?'<font color=red>removed</font>':htmlspecialchars((string)$v);
			}
			$data .= 'GET='.print_r($get_data, true);
		}
		if ($_POST) {
			$post_data = array_filter($_POST);
			foreach ($post_data as $k => $v) {
				$post_data[$k] = substr_count(strtolower($k), 'password')?'<font color=red>removed</font>':htmlspecialchars(substr((string)$v, 0, 200));
			}
			$data .= ($data?"\n":'').'POST='.print_r($post_data, true);
		}
		$data = str_replace(array("Array\n(", "\n)\n"), array('Array(', "\n)"), $data);
		
		$do_action = explode('.', (isset($_POST['do_action']) ? $_POST['do_action'] : $_GET['do_action']));
		db::insert('wb_manage_log', array(
				'ExtId'		=>	$_SESSION['Manage']['Id'],
				'UserName'	=>	addslashes($_SESSION['Manage']['UserName']),
				'Ip'		=>	ly200::get_ip(),
				'Log'		=>	addslashes($log),
				'Data'		=>	$data,
				'AccTime'	=>	Time
			)
		);
	}
	
	public static function email($Email, $Subject, $Body){
		if ($_SESSION['Manage']['Id']==-1) { return; }
		$time = Time;
		foreach ($Email as $k => $v) {
			db::insert('email_log', array(
					'Email'		=>	$v,
					'Subject'	=>	addslashes($Subject),
					'Body'		=>	addslashes($Body),
					'AccTime'	=>	$time
				)
			);
		}
	}
	
}
