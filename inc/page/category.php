<?php
switch ($_ARG['m']) {
	case 'products':
	case 'products-detail':
		$row = wb_products_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_products.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	case 'blog':
	case 'blog-detail':
		$row = wb_blog_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_blog.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	case 'download':
	case 'download-detail':
		$row = wb_download_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_download.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	case 'solution':
	case 'solution-detail':
		$row = wb_solution_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_solution.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	case 'team':
	case 'team-detail':
		$row = wb_team_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_team.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	case 'video':
	case 'video-detail':
		$row = wb_video_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_video.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	case 'case':
	case 'case-detail':
		$all = array(
			array(
				'Name' => lang('{/global.all/}'),
				'Href' => url::set('', 'wb_case.list'),
				'_cur_' => $_ARG['cid']?'':'cur',
			)
		);
		$row = array_merge($all, wb_case_category::all($_ARG));
		break;
	case 'faq':
		$row = wb_faq_category::all($_ARG);
		if ($row) {
			$all = array(
				array(
					'Name' => lang('{/global.all/}'),
					'Href' => url::set('', 'wb_faq.list'),
					'_cur_' => $_ARG['cid']?'':'cur',
				)
			);
			$row = array_merge($all, $row);
		}
		break;
	default:
		$row = array();
		break;
}