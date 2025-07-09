<?php
/**
 * @author Zhao Binyan <itbudaoweng@gmail.com>
 * @since  2015-06-11
 */
header('Content-Type: text/html; charset=utf-8');

//you do not need to do this if use composer!
require dirname(__DIR__) . '/src/IpLocation.php';
        // print_r('123');die;


// $input = getopt("i:", array('ip:'));
use itbdw\Ip\IpLocation;

$ips = array(
    "172.217.25.14",//美国
    '124.156.168.237',
    //"140.205.172.5",//杭州
    //"123.125.115.110",//北京
    //"221.196.0.0",//
    //"60.195.153.98",

    //bug ip 都是涉及到直辖市的
    //"218.193.183.35", //"province":"上海交通大学闵行校区",
    //"210.74.2.227", //,"province":"北京工业大学","city":"",
    //"162.105.217.0", //,"province":"北京大学万柳学区","ci



);

/*if (isset($input['i']) || isset($input['ip'])) {
    $ips = array();

    if (isset($input['i'])) {
        $ips[] = $input['i'];
    }

    if (isset($input['ip'])) {
        $ips[] = $input['ip'];
    }
}*/

foreach ($ips as $ip) {
    echo str::json(IpLocation::getLocation($ip)) . "<br>";
}


class jxs {
    /*
     * json 自动转换
     * 
    **/
    public static function json($data) {
        if (is_array($data)) {
            if (!function_exists('unidecode')) {
                function unidecode($match) {
                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
                }
            }
            return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'unidecode', str_replace("'", "\'", json_encode($data)));
        } else {
            $rnt = array("\r", "\n", "\t");
            $bhr = array("|-r-|", "|-n-|", "|-t-|");
            $data = str_replace($rnt, $bhr, $data);
            $data = (array)json_decode(str_replace("\'", "'", $data), true);
            self::replace($bhr, $rnt, $data);
            return $data;
        }
    }
    public static function replace($a, $b, &$array){
        $array = str_replace($a, $b, $array);
        if(is_array($array)){
            foreach($array as $key => $val) {
                if (is_array($val)) {
                    self::replace($a, $b, $array[$key]);
                }
            }
        }
    }
}
