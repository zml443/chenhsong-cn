<?php

class crumbs {
	public static $homeico = '<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M985.918174 407.306852C833.587596 278.999733 536.843261 21.020528 533.840328 18.290589L512.273813 0l-21.293522 18.017595-27.299387 22.658491C391.610523 104.829645 165.5716 300.293255 36.718494 407.306852A78.34924 78.34924 0 0 0 88.314335 545.987737H145.916042v399.117035a78.895228 78.895228 0 0 0 78.895228 78.895228h150.419621a78.895228 78.895228 0 0 0 78.895228-78.895228v-149.054652h116.295388v149.054652a78.895228 78.895228 0 0 0 78.895228 78.895228h150.965609a79.441216 79.441216 0 0 0 78.076246-78.34924V545.987737h58.147694a78.076246 78.076246 0 0 0 49.957878-138.953879zM388.607591 729.166622v215.93815a12.830712 12.830712 0 0 1-12.830712 12.830712H223.992288a12.830712 12.830712 0 0 1-12.830712-12.830712v-464.089576H88.041342a12.830712 12.830712 0 0 1-12.284725-12.830712 15.014663 15.014663 0 0 1 4.640896-10.373767c131.856038-109.197547 363.900826-310.940016 432.149294-370.452679 78.34924 68.521461 301.658224 263.712077 431.876299 371.544655a12.01173 12.01173 0 0 1 4.640896 9.554785 12.830712 12.830712 0 0 1-12.830712 12.830712h-123.939216v464.089576a12.830712 12.830712 0 0 1-12.830712 12.830712h-150.965609a12.830712 12.830712 0 0 1-12.830712-12.830712v-216.211144z" p-id="9676"></path></svg>';
	public static $backico = '<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M802.228902 89.261802A51.197491 51.197491 0 1 0 733.726659 13.18233l-511.974913 460.777422a51.197491 51.197491 0 0 0 0 76.079472l511.974913 460.777422a51.197491 51.197491 0 1 0 68.502243-76.079472L332.543117 511.999488l469.685785-422.737686z"></path></svg>';
	// css 样式
	public static $css = array();
	public static function css ($type) {
		if (self::$css[$type]) return '';
		// self::$css[$type] = 1;
		$css = dirname(__FILE__).'/../../web/css/crumbs/'.$type.'.css';
		ob_start();
		echo '<style>';
		is_file($css) && include $css;
		echo '</style>';
		self::$css[$type] = ob_get_contents();
		ob_end_clean();
		return self::$css[$type];
	}
	// html 代码
	public static function html ($arr=array()) {
		$arr['type'] || $arr['type'] = 'type';
		$css = self::css($arr['type']);
		switch ($arr['type']) {

			case 'zw-yw-zwbrief':
				$html = '
					<div class="jcss-zw">'.$arr['zw'].'</div>
					<div class="jcss-yw '.($arr['yw']?'':'hide').'">'.$arr['yw'].'</div>
					<div class="jcss-zwbrief '.($arr['zwbrief']?'':'hide').'">'.$arr['zwbrief'].'</div>
				';
				break;
			
			default:
				$li .= '
					<a class="jcss-back v-middle m-pic fr" href="javascript:back();">
						<div class="jcss-back-2 v-middle">'.lang('global.back').'</div>
					</a>
				';
				foreach ((array)$arr['crumbs'] as $k => $v) {
					if ($k) {
						$li .=  '
							<div class="jcss-li v-middle m-pic">
				                <div class="jcss-name v-middle">'.$v['name'].'</div>
				                <div class="jcss-arrow v-middle">/</div>
				            </div>
			            ';
					}
					else {
						$li .=  '
							<div class="jcss-li v-middle m-pic">
								<a class="jcss-home v-middle" href="/">'.self::$homeico.'</a>
				                <div class="jcss-arrow v-middle">/</div>
				            </div>
			            ';
					}
            	}
            	$html = '<div class="jcss-ul m-pic text-left">'.$li.'</div>';
				break;
		}
		return $css.'<div clean css="crumbs,'.$arr['type'].'" open_back="'.$arr['open_back'].'">'.$html.'</div>';
	}
}
?>