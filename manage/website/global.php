<?php
// 安全入口
function_exists('c') || exit;

$_GET['_inline_view_'] = 1;

$_SESSION['website_preview_model'] = 1;

// 
class webGlobal {
	public static $c = array();
	// 初始化
	public static function init(){
		self::$c['id'] = $_POST['id'];
		self::$c['css'] = array(
			'mainColor' => g('website.mainColor'),
		);
		self::$c['c'] = array(
			'HostType' => c('HostType'),
		);
	}

	// 获取当前页数据
	public static function current(){
		$page_entity = wb_site_page::get_page();
		$id = self::$c['id'];
		$jump_foreach = 0;
		$page_current = array();
		foreach ($page_entity as $k => $v) {
			if ($v['type']=='index') {
				$page_current = $v;
			}
			if ($v['children']) {
				foreach ($v['children'] as $k1 => $v1) {
					if ($id && ($v1['type']==$id || $v1['id']==$id)) {
						$page_current = $v1;
						$jump_foreach = 1;
						break;
					}
				}
			} else if ($id && ($v['type']==$id || $v['id']==$id)) {
				$page_current = $v;
				break;
			}
			if ($jump_foreach) break;
		}
		$page_current['value'] = $page_current['value'];
		self::$c['current'] = $page_current;
		self::$c['allPage'] = $page_entity;
	}

	// 获取所有页面链接
	public static function allUrl(){
		self::$c['allUrl'] = wb_site_page::url();
		self::$c['target_select'] = array(
			array(
				'value' => '_top',
				'label' => '当前窗口',
			),
			array(
				'value' => '_blank',
				'label' => '新窗口',
			),
		);
		self::$c['allUrl_service'] = wb_service::url();
	}

	// 语言包
	public static function language(){
		self::$c['language'] = array(
	        'cur' => c('lang'),
	        'all' => c('language')
	    );
		self::$c['lang'] = language('');

		self::$c['lang']['_DB_'] = array(
			'wb_products' => array(
				'key' => 'wb_products',
				'ma' => 'products/index',
				'name' => language('menu.products.module_name'),
				'referrer' => language('menu.products.module_referrer'),
				'href' => '/manage/?u=products,products&m=products&a=index',
	        ),
			'wb_blog' => array(
				'key' => 'wb_blog',
				'ma' => 'blog/index',
				'name' => language('menu.app.blog.module_name'),
				'referrer' => language('menu.app.blog.module_referrer'),
				'href' => '/manage/?u=app,blog,index&m=blog&a=index&l=app',
	        ),
			'wb_hotel' => array(
				'key' => 'wb_hotel',
				'ma' => 'hotel/index',
				'name' => language('menu.app.hotel.module_name'),
				'referrer' => language('menu.app.hotel.module_referrer'),
				'href' => '/manage/?u=app,hotel,index&m=hotel&a=index&l=app',
	        ),
			'wb_branches' => array(
				'key' => 'wb_branches',
				'ma' => 'branches/index',
				'name' => language('menu.app.branches.module_name'),
				'referrer' => language('menu.app.branches.module_referrer'),
				'href' => '/manage/?u=app,branches,index&m=branches&a=index&l=app',
	        ),
			'wb_fashion' => array(
				'key' => 'wb_fashion',
				'ma' => 'fashion/index',
				'name' => language('menu.app.fashion.module_name'),
				'referrer' => language('menu.app.fashion.module_referrer'),
				'href' => '/manage/?u=app,fashion,index&m=enterprise&a=index&l=app',
	        ),
			'wb_enterprise' => array(
				'key' => 'wb_enterprise',
				'ma' => 'enterprise/index',
				'name' => language('menu.app.enterprise.module_name'),
				'referrer' => language('menu.app.enterprise.module_referrer'),
				'href' => '/manage/?u=app,enterprise,index&m=enterprise&a=index&l=app',
	        ),
			'wb_exhibition' => array(
				'key' => 'wb_exhibition',
				'ma' => 'exhibition/index',
				'name' => language('menu.app.exhibition.module_name'),
				'referrer' => language('menu.app.exhibition.module_referrer'),
				'href' => '/manage/?u=app,exhibition,index&m=exhibition&a=index&l=app',
	        ),
			'wb_activity' => array(
				'key' => 'wb_activity',
				'ma' => 'activity/index',
				'name' => language('menu.app.activity.module_name'),
				'referrer' => language('menu.app.activity.module_referrer'),
				'href' => '/manage/?u=app,activity,index&m=activity&a=index&l=app',
	        ),
			'wb_case' => array(
				'key' => 'wb_case',
				'ma' => 'case/index',
				'name' => language('menu.app.case.module_name'),
				'referrer' => language('menu.app.case.module_referrer'),
				'href' => '/manage/?u=app,case,index&m=case&a=index&l=app',
	        ),
			'wb_solution' => array(
				'key' => 'wb_solution',
				'ma' => 'solution/index',
				'name' => language('menu.app.solution.module_name'),
				'referrer' => language('menu.app.solution.module_referrer'),
				'href' => '/manage/?u=app,solution,index&m=solution&a=index&l=app',
	        ),
			'wb_team' => array(
				'key' => 'wb_team',
				'ma' => 'team/index',
				'name' => language('menu.app.team.module_name'),
				'referrer' => language('menu.app.team.module_referrer'),
				'href' => '/manage/?u=app,team,index&m=team&a=index&l=app',
	        ),
			'wb_partner' => array(
				'key' => 'wb_partner',
				'ma' => 'partner/index',
				'name' => language('menu.app.partner.module_name'),
				'referrer' => language('menu.app.partner.module_referrer'),
				'href' => '/manage/?u=app,partner&m=partner&a=index&l=app',
	        ),
			'wb_video' => array(
				'key' => 'wb_video',
				'ma' => 'video/index',
				'name' => language('menu.app.video.module_name'),
				'referrer' => language('menu.app.video.module_referrer'),
				'href' => '/manage/?u=app,video&m=video&a=index&l=app',
	        ),
			'wb_download' => array(
				'key' => 'wb_download',
				'ma' => 'download/index',
				'name' => language('menu.app.download.module_name'),
				'referrer' => language('menu.app.download.module_referrer'),
				'href' => '/manage/?u=app,download&m=download&a=index&l=app',
	        ),
			'wb_faq' => array(
				'key' => 'wb_faq',
				'ma' => 'faq/index',
				'name' => language('menu.app.faq.module_name'),
				'referrer' => language('menu.app.faq.module_referrer'),
				'href' => '/manage/?u=app,faq&m=faq&a=index&l=app',
	        ),
			'wb_history' => array(
				'key' => 'wb_history',
				'ma' => 'history/index',
				'name' => language('menu.app.history.module_name'),
				'referrer' => language('menu.app.history.module_referrer'),
				'href' => '/manage/?u=app,history&m=history&a=index&l=app',
	        ),
			'wb_server' => array(
				'key' => 'wb_server',
				'ma' => 'server/index',
				'name' => language('menu.app.server.module_name'),
				'referrer' => language('menu.app.server.module_referrer'),
				'href' => '/manage/?u=app,server&m=server&a=index&l=app',
	        ),
			'wb_links' => array(
				'ma' => 'links/index',
				'name' => language('menu.app.links.module_name'),
				'referrer' => language('menu.app.links.module_referrer'),
				'href' => '/manage/?u=app,links,index&m=links&a=index&l=app',
	        ),
			'wb_site_nav' => array(
				'ma' => 'site/nav',
				'name' => language('menu.web.nav.module_name'),
				'referrer' => language('menu.web.nav.module_referrer'),
				'href' => '/manage/?u=web,nav&m=site&a=nav&L=list',
	        ),
			'wb_site_footer_nav' => array(
				'ma' => 'site/footer_nav',
				'name' => language('menu.web.footer_nav.module_name'),
				'referrer' => language('menu.web.footer_nav.module_referrer'),
				'href' => '/manage/?u=web,footer_nav&m=site&a=footer_nav&l=category',
	        ),
			'wb_site_config' => array(
				'ma' => 'site/config',
				'name' => language('menu.set.set.module_name'),
				'referrer' => language('menu.set.set.module_referrer'),
				'href' => '/manage/?u=set,set&m=site&a=config&E=self',
	        ),
			'wb_site_page' => array(
				'ma' => 'site/page',
				'name' => language('menu.web.page.module_name'),
				'referrer' => language('menu.web.page.module_referrer'),
				'href' => '/manage/?u=web,nav&m=site&a=nav&L=list',
	        ),
	    );
	}

	// 网站状态
	public static function web(){
		$web = db::result("select * from wb_site_web where Used=1 limit 1");
		if ($web['Release']) {
			if (g('website.update_time')==$web['EditTime']) {
				$use_status = 'used'; //使用中
			} else {
				$use_status = 'update'; //更新中
			}
		} else {
			$use_status = 'un_used'; //未使用
		}
		self::$c['web'] = array(
			'id' => $web['Id'],
			'status' => $use_status,
		);
	}

	// 页面配置
	public static function page(){
		$id = (int)$_POST['id'];
		if ($id) {
			$config = saas::config(array(
				'id' => $id,
			));
		} else {
			$type = $_POST['type']?:($_POST['id']?:'index');
			$config = saas::config(array(
				'check_local' => 1,
				'type' => $type,
			));
		}
		self::$c['page'] = $config;
		// exit(str::json($config));
	}

	// 模板类型
	public static function module(){
		self::$c['module'] = array(
			'type' => array(),
			'search' => array(),
		);
		$module_type_res = lydb::query("select * from ss_module_type");
		while ($v = lydb::result($module_type_res)) {
			self::$c['module']['type'][$v['Name']] = array(
				'name' => $v['Title']
			);
		}
	}
	// 
}

webGlobal::init();
// 
webGlobal::language();
webGlobal::current();
webGlobal::allUrl();
webGlobal::web();
webGlobal::page();
webGlobal::module();




exit(str::json(webGlobal::$c));
?>