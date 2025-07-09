<?php if ($this->edit_head && $this->is_mod) { ?>
	<div class="flex-middle2 <?=$lyCssConf['class']?>" <?=r($lyCssConf,'class')?>>
		<?php 
			foreach ($this->edit_head as $k => $v) {
				if ($k=='IsLoginLock') { // 登录屏蔽 
					if ($this->row['IsLoginLock']) {
						echo "
							<div class='flex-middle2 mr_20px pointer' color='main' dbs-edit-head-is-login-lock='?ma={$_GET['ma']}&d=post' data-id='{$_GET['Id']}' data-lock='0'>
								<i class='lyicon-success mr_3px'></i><span>".language('{/member.allow_login/}')."</span>
							</div>
						";
					} else {
						echo "
							<div class='flex-middle2 mr_20px pointer' color='main' dbs-edit-head-is-login-lock='?ma={$_GET['ma']}&d=post' data-id='{$_GET['Id']}' data-lock='1'>
								<i class='lyicon-stop mr_3px'></i><span>".language('{/member.is_login_lock/}')."</span>
							</div>
						";
					}
				} else if ($k=='Password') {
					?>
						<div class="flex-middle2 mr_20px pointer" color="main" lydbs-password="?ma=<?=$_GET['ma']?>&d=post" data-id="<?=$_GET['Id']?>">
							<i class="lyicon-lock mr_3px"></i><span><?=language('{/member.mod_password/}')?></span>
						</div>
					<?php
				} else if ($k=='Preview') {
					?>
						<div class="flex-middle2 mr_20px pointer" color="main" lydbs-preview="" data-url="<?=$this->edit_head['Preview']?>">
							<i class="lyicon-browse mr_3px"></i><span><?=language('{/global.preview/}')?></span>
						</div>
					<?php
				} else if ($k=='Delete') {
					continue;
					?>
						<div class="flex-middle2 mr_20px pointer" color="main">
							<i class="lyicon-browse mr_3px"></i><span><?=language('{/global.preview/}')?></span>
						</div>
					<?php
				} else {
					?>
						<div class="flex-middle2 mr_20px pointer" color="main" hr-ef="<?=$v['url']?>">
							<?=$v['ico']?'<i class="'.$v['ico'].' mr_3px"></i>':''?>
							<span><?=$v['name']?></span>
						</div>
					<?php
				}
			} 
		?>
	</div>
<?php } ?>