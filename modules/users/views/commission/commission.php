<link href="modules/users/assets/css/logged.css" media="screen" type="text/css" rel="stylesheet">
<link href="libraries/jquery/tooltip/ezpz_tooltip.css" media="screen" type="text/css" rel="stylesheet">
<script src="libraries/jquery/tooltip/jquery.ezpz_tooltip.js"  type="text/javascript"></script>
<div class="frame_display  upgrade commission">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>	
		<?php $Itemid = FSInput::get('Itemid'); ?>
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class='title'><span>Doanh thu hoa h&#7891;ng - hoa h&#7891;ng c&#225; nh&#226;n </span></p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form-user">
						<p class="commission"><span>T&#7893;ng hoa h&#7891;ng nh&#7853;n &#273;&#432;&#7907;c t&#237;nh t&#7899;i th&#7901;i &#273;i&#7875;m hi&#7879;n t&#7841;i </span><?php echo number_format($total_cm_current, 0, ',', '.');  ?> VND</p>
						<div class="commission_person">
							<?php include 'commission_person.php';?>
						</div>
						<div class="commission_base">
							<?php include 'commission_base.php';?>
						</div>
						<?php  if($user->level >=1) {?>
							<div class="commission_manage">
								<?php include 'commission_manage.php';?>
							</div>
						<?php  }?>
						<?php  if($user->level >=3) {?>
							<div class="commission_leadership">
								<?php include 'commission_leadership.php';?>
							</div>
						<?php  }?>
					</div>
				</div>
			</div>	
		</div>	
	</div>
</div>

