
<form class="flex-right wangzhanshousuoform" action="?" lydbs-search-form>
	<?=$this->search['hidden'];?>
	<script type="text" lydbs-search-json><?=str_replace('</script>', '<\/script>', str::json($this->search['layout']));?></script>
	<div class="hide" lydbs-search-input></div>
	<div class="ly_btn mr_15px pointer2" bg="light" lydbs-search-btn><?=language('global.sifting')?><i class="ml_5px lyicon-arrow-right-bold fz12"></i></div>
	<div class='ly_input_suffix width300'>
		<input type='text' name='keyword' value='<?=str::code($_GET['keyword'])?>' autocomplete='off' />
		<i class='lyicon-search pointer' bg="main" onclick="$(this).parents('form').submit()"></i>
	</div>
</form>