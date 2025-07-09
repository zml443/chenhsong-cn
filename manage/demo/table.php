<?php
isset($c) || exit;

?>
<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include "__/inc/style_script.php"; ?>
</head>
<body class="pt_30px pb_30px pl_30px pr_30px">

	<div class="mt_30px">ly_table</div>
	<table class="ly_table">
		<thead>
			<tr>
				<td class="w_1"><label class="ly_checkbox lyicon-select-bold"><input type="checkbox" all="[name=Id]" /></label></td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td class="w_1">操作</td>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i<5; $i++) { ?>
				<tr>
					<td class="w_1"><label class="ly_checkbox lyicon-select-bold"><input type="checkbox" name="Id" /></label></td>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td class="w_1">
						<div class="ly_gap_10px">
							<a color="main">发布</a>
							<a color="main">回收</a>
							<a color="main">删除</a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="mt_30px">ly_table_line</div>
	<table class="ly_table_line">
		<thead>
			<tr>
				<td class="w_1"><label class="ly_checkbox lyicon-select-bold"><input type="checkbox" all="[name=Id]" /></label></td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td class="w_1">操作</td>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i<5; $i++) { ?>
				<tr>
					<td class="w_1"><label class="ly_checkbox lyicon-select-bold"><input type="checkbox" name="Id" /></label></td>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td class="w_1">
						<div class="ly_gap_10px">
							<a color="main">发布</a>
							<a color="main">回收</a>
							<a color="main">删除</a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	
	<div class="mt_30px">ly_table_small</div>
	<table class="ly_table_small width450">
		<thead>
			<tr>
				<td class="w_1"><label class="ly_checkbox lyicon-select-bold"><input type="checkbox" all="[name=Id]" /></label></td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td class="w_1">操作</td>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i<5; $i++) { ?>
				<tr>
					<td class="w_1"><label class="ly_checkbox lyicon-select-bold"><input type="checkbox" name="Id" /></label></td>
					<td>1</td>
					<td>2</td>
					<td>3</td>
					<td class="w_1">
						<div class="ly_gap_10px">
							<a color="main">发布</a>
							<a color="main">回收</a>
							<a color="main">删除</a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	
	<div class="mt_30px">ly_table_list</div>
	<table class="ly_table_list maxw">
		<thead>
			<tr>
				<td class="w_1"><label class="ly_checkbox lyicon-select-bold" size="big"><input type="checkbox" all="[name=Id]" /></label></td>
				<td class="w_1">1</td>
				<td>2</td>
				<td>3</td>
				<td class="w_1">操作</td>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i<5; $i++) { ?>
				<tr>
					<td class="w_1"><label class="ly_checkbox lyicon-select-bold" size="big"><input type="checkbox" name="Id" /></label></td>
					<td class="w_1">
						<div class="ly_img"><img src="" /></div>
					</td>
					<td>
						<div>2asdasd</div>
						<div>2asdasdasdsadasdsadsad</div>
					</td>
					<td>3</td>
					<td class="w_1">
						<div class="ly_gap_10px">
							<a class="ly_btn_round lyicon-fabu" bg="light" tip-bubble="{}" data-tip-contents="发布"></a>
							<a class="ly_btn_round lyicon-ashbin" bg="light" tip-bubble="{}" data-tip-contents="回收"></a>
							<a class="ly_btn_round lyicon-close" bg="light" tip-bubble="{}" data-tip-contents="删除"></a>
						</div>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>


	<div class="mt_30px">ly_table_box + ly_table_list</div>
	<div class="ly_table_box">
		<table class="ly_table_list maxw">
			<thead>
				<tr>
					<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type="checkbox" all="[name=Id]" /></label></td>
					<td class="w_1">图片</td>
					<td>1sssssssssss</td>
					<td>3sssssssssssssssss</td>
					<td>2sssssssssssssssss</td>
					<td>2sssssssssssssssssssssssssssssss</td>
					<td>1sssssssssss</td>
					<td>3sssssssssssssssss</td>
					<td>2sssssssssssssssss</td>
					<td>2sssssssssssssssssssssssssssssss</td>
					<td>1sssssssssss</td>
					<td>3sssssssssssssssss</td>
					<td>2sssssssssssssssss</td>
					<td class="w_1 sticky">操作</td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0; $i<5; $i++) { ?>
					<tr>
						<td class="w_1 sticky"><label class="ly_checkbox lyicon-select-bold" size="big"><input type="checkbox" name="Id" /></label></td>
						<td class="w_1">
							<div class="ly_img"><img src="" /></div>
						</td>
						<td>1sssssssssss</td>
						<td>3sssssssssssssssss</td>
						<td>2sssssssssssssssss</td>
						<td>2sssssssssssssssssssssssssssssss</td>
						<td>1sssssssssss</td>
						<td>3sssssssssssssssss</td>
						<td>2sssssssssssssssss</td>
						<td>2sssssssssssssssssssssssssssssss</td>
						<td>1sssssssssss</td>
						<td>3sssssssssssssssss</td>
						<td>2sssssssssssssssss</td>
						<td class="w_1 sticky">
							<div class="ly_gap_10px">
								<a class="ly_btn_round lyicon-fabu" bg="light" tip-bubble="{}" data-tip-contents="发布"></a>
								<a class="ly_btn_round lyicon-ashbin" bg="light" tip-bubble="{}" data-tip-contents="回收"></a>
								<a class="ly_btn_round lyicon-close" bg="light" tip-bubble="{}" data-tip-contents="删除"></a>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>



</body>
</html>