<!DOCTYPE HTML>
<html class="scrollbar">
<head>
	<meta loading>
	<?php include c('root').'manage/__/inc/style_script.php'; ?>
</head>

<body>
<style>
	[body]{padding:20px; font-size:14px; line-height:1.8;}
	dd{padding-left:40px;}
	.name{margin-right:5px;}
	.dd1{}
	.dd2{padding-left:30px;}
	label{color:#666; margin:0 3px;}
</style>
<div body>
	

	<?php
	if (manage('Level')==1) {
		$permit_ary = p('manage.permit.reset');
	} else {
		$permit_ary = p('manage.permit.reset_cur');
	}
	foreach ((array)$permit_ary as $k => $v) {
	?>
		<dl class='managePermit'>
			<dt><?=language('menu.'.$k.'.module_name')?></dt>
			<dd>
			<?php
			foreach ($v as $k1 => $v1) {
				$na0 = language('{/menu.'.$k.'.'.$k1.'.module_name/}');
				if (is_array($v1) && language($na0)) {
					echo '<div class="dd1">';
					echo "<label class='name'>".language($na0)." <input type='checkbox' all=\"[name^='p__name[{$k}][{$k1}]']\" /></label>";
					$i2=0;
					$c2=count($v1);
					foreach ($v1 as $k2 => $v2) {
						if (strstr('^'.$k2, '^_')) continue;
		    			$i2++;
						if (is_array($v2)) {
							echo '<div class="dd2">';
							echo language('{/menu.'.$k.'.'.$k1.'.'.$k2.'.module_name/}')." (";
		    				foreach ($v2 as $k3=>$v3) {
		    					if (in_array($k3, array('hide', 'seo', 'orderby'))) {
		    						continue;
		    					}
		        				echo "<label><input type='checkbox' name='p__name[{$k}][{$k1}][{$k2}][{$k3}]' value='1' " . (c("manage.permit.tmpl.$k.$k1.$k2.$k3")?'checked':'') . ">".language("{/global.$k3/}")."</label>";
		    				}
		    				echo ")</div>";
		    			} else {
	    					if (in_array($k2, array('hide', 'seo', 'orderby'))) {
	    						continue;
	    					}
		    				if ($i2==1) echo "(";
		    				echo "<label><input type='checkbox' name='p__name[{$k}][{$k1}][{$k2}]' value='1' " . (c("manage.permit.tmpl.$k.$k1.$k2")?'checked':'') . ">".language("{/global.$k2/}")."</label>";
		    				if ($i2==$c2) echo ")";
		    			}
					}
		    		echo "</div>";
				}
			}
			?>
			</dd>
		</dl>
	<?php } ?>

	<script>
	!function(){
		var obj = WP.dbsPermit.obj;
		var name = obj.attr('data-name');
		$(document).on('click', 'input', function () {
			setTimeout(()=>{
				var inp = '';
				$('input:checked').each(function () {
					var a = $(this);
					var n = a.attr('name')||'';
						n = n.replace(/p__name/, name);
					var v = a.val();
					if (n) inp += '<textarea name="'+n+'">'+v+'</textarea>';
				});
				obj.find('[data-input]').html(inp);
			}, 300);
		});
		obj.find('[data-input] [name]').each(function(){
			var a = $(this);
			var n = a.attr('name').replace(new RegExp(name), '');
			var v = a.val();
			if (v=='1') {
				$('[name$="'+n+'"]').attr('checked', true);
			}
		});
		$(document).on('click', '', function () {
			// 
		});
	}();
	</script>

	
</div>
</body>
</html>