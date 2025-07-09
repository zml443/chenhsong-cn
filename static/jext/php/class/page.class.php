<?php

class page {

	// H5版的分页样式
	public static function html ($dbt, $pg=array(), $array=array()) {
		if ($dbt['limit']) unset($pg['limit']);
		$pg = array_merge((array)$dbt, (array)$pg, $array);
		$pg['type'] = $pg['type']?$pg['type']:'default';

		isset($pg['prev']) || $pg['prev'] = '<';
		isset($pg['next']) || $pg['next'] = '>';

		$pg['base'] || $pg['base'] = 1;
		$pg['limit'] || $pg['limit'] = 6;

		$pg['page'] || $pg['page'] = $_GET['pg'];
		$pg['page'] = $pg['page'] < 1 ? 1 : $pg['page'];
		$page = (int)$pg['page'];
		$pg['total_page'] = $total_pages = ceil($pg['total']/$pg['limit']);
		$pg['start'] = ($page-1)*$pg['limit'];
		
		$pg['html'] = '';
		
		if (!$pg['total']) return $pg;

		$query_string = str_replace(array('"', "'"), array('%22', '%27'), $_SERVER['REQUEST_URI']);
		$pm = preg_replace('#([\/\?\&])pg([=\-])([0-9]+)#', '$1pg$2{#pm#}', $query_string);

		if (strpos($pm, '{#pm#}')===false) {
			if ($pg['static']) {
				$qs = explode('?', $query_string);
				$pm = rtrim($qs[0], '/').'/pg-{#pm#}'.($qs[1]?'?'.$qs[1]:'');
			} else {
				$qs = explode('?', $query_string);
				$pm = $qs[0].($qs[1]?'?'.$qs[1].'&':'?').'pg={#pm#}';
			}
		}

		$i_start=$page-$pg['base']>0?$page-$pg['base']:1;
		$i_end=$page+$pg['base']>=$total_pages?$total_pages:$page+$pg['base'];
		($total_pages-$page)<$pg['base'] && $i_start=$i_start-($pg['base']-($total_pages-$page));
		$page<=$pg['base'] && $i_end=$i_end+($pg['base']-$page+1);
		$i_start<1 && $i_start=1;
		$i_end>=$total_pages && $i_end=$total_pages;
		
		$pre=$page-1>0?$page-1:1;
		if ($page <= 1) {
			$pg['html'] .= "<font class='lyui_paging_prev flex-max2'>{$pg['prev']}</font>";
		} else {
			$pg['html'] .= "<a href='".str_replace('{#pm#}',$pre,$pm)."' class='lyui_paging_prev flex-max2'>{$pg['prev']}</a>";
		}
		$pg['html'] .= "<span class='lyui_paging_number flex'>";
		for ($i=$i_start; $i<=$i_end; $i++) {
			if ($page!=$i) {
				$pg['html'] .= "<a href='".str_replace('{#pm#}',$i,$pm)."' class='lyui_paging_btn flex-max2'>$i</a>";
			} else {
				$pg['html'] .= "<font class='lyui_paging_btn flex-max2 cur'>$i</font>";
			}
		}
		if ($i_end<$total_pages) {
			$pg['html'] .= "<font class='lyui_paging_point flex-max2'>...</font><a href='".str_replace('{#pm#}',$total_pages,$pm)."' class='lyui_paging_btn flex-max2'>$total_pages</a>";
		}
		$pg['html'] .= "</span>";

		$next=$page+1>$total_pages?$total_pages:$page+1;
		if ($page+1 > $total_pages) {
			$pg['html'] .= "<font class='lyui_paging_next flex-max2'>{$pg['next']}</font>";
		} else {
			$page>=$total_pages && $page--;
			$pg['html'] .= "<a href='".str_replace('{#pm#}',$next,$pm)."' class='lyui_paging_next flex-max2'>{$pg['next']}</a>";
		}
		$ajax_json = array(
			'page' => $pg['page']+1,
			'total_page' => $pg['total_page']
		);
		switch ($pg['type']) {
			case 'scroll':
				$pg['html'] = "
					<div class='lyui_paging text-center' type='{$pg['type']}' ajax-append='".str::json($ajax_json)."' to='{$pg['to']}' visible='_visible_ajax_page'>
						<div class='pg-more'>更多</div>
						<div class='pg-load'>加载中</div>
						<div class='pg-over'>已经到底了</div>
					</div>
				";
				break;
			case 'search':
			case 'search2':
				$pg['html'] = "
					<div class='lyui_paging flex-wrap flex-middle2' type='{$pg['type']}'>
						{$pg['html']}
						<label class='lyui_paging_label flex-max2' data-pm='{$pm}'><input type='text' /></label>
						<label class='lyui_paging_go flex-max2'>GO</label>
						".($pg['type']=='search2'?"<div class='lyui_paging_total'>".str_replace('{{qty}}', $pg['total'], language('global.page_total'))."</div>":'')."
					</div>
				";
				break;
			default:
				$pg['html'] = "<div class='lyui_paging flex-wrap flex-middle2' type='{$pg['type']}' size='{$pg['size']}'>{$pg['html']}</div>";
				break;
		}
		return $pg;
	}
}