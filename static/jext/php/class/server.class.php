<?php

class server {
	// 是否手机
	public static function mobile () {
		if (stripos($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
			return 2;
		} else {
			$phone_client_agent_array = array('240x320','acer','acoon','acs-','abacho','ahong','airness','alcatel','amoi','android','anywhereyougo.com','applewebkit/525','applewebkit/532','asus','audio','au-mic','avantogo','becker','benq','bilbo','bird','blackberry','blazer','bleu','cdm-','compal','coolpad','danger','dbtel','dopod','elaine','eric','etouch','fly ','fly_','fly-','go.web','goodaccess','gradiente','grundig','haier','hedy','hitachi','htc','huawei','hutchison','inno','ipaq','ipod','jbrowser','kddi','kgt','kwc','lenovo','lg ','lg2','lg3','lg4','lg5','lg7','lg8','lg9','lg-','lge-','lge9','longcos','maemo','mercator','meridian','micromax','midp','mini','mitsu','mmm','mmp','mobi','mot-','moto','nec-','netfront','newgen','nexian','nf-browser','nintendo','nitro','nokia','nook','novarra','obigo','palm','panasonic','pantech','philips','phone','pg-','playstation','pocket','pt-','qc-','qtek','rover','sagem','sama','samu','sanyo','samsung','sch-','scooter','sec-','sendo','sgh-','sharp','siemens','sie-','softbank','sony','spice','sprint','spv','symbian','tablet','talkabout','tcl-','teleca','telit','tianyu','tim-','toshiba','tsm','up.browser','utec','utstar','verykool','virgin','vk-','voda','voxtel','vx','wap','wellco','wig browser','wii','windows ce','wireless','xda','xde','zte','mobile');
			foreach ($phone_client_agent_array as $v) {
				if (stripos($_SERVER['HTTP_USER_AGENT'], $v)) {
					return 1;
					break;
				}
			}
		}
		return 0;
	}

	// ipad
	public static function ipad () {
		if (stripos($_SERVER['HTTP_USER_AGENT'], 'ipad')) {
			return 1;
		}
		return 0;
	}

	//获取网站域名
	public static function domain ($protocol=1) {
		return ($protocol == 1 ? ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 'https://' : 'http://') : '').$_SERVER['HTTP_HOST'];
	}
}