<link href="modules/users/assets/css/logged.css" media="screen" type="text/css" rel="stylesheet">
<div class="frame_display  members">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>	
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class='title'><span><?php echo "C&acirc;y th&agrave;nh vi&ecirc;n t&#7847;ng d&#432;&#7899;i"; ?></span></p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="member_tree_body">
					<div class="member_tree_left">
						<?php include_once 'modules/users/views/members/members_tree.php';?>
					</div>
					<div class="member_tree_right">
						
						<!--	MEMBER STATISTICS					-->
						<div class="members_statistics"><?php include("modules/users/views/members/members_statistics.php"); ?></div>
						<!--	END MEMBER STATISTICS					-->
						
						
						<!--	Infor of lower-level member					-->
						<div class="lower_member" id="lower_member">
							
						</div>
						<!--	End Infor of lower-level member					-->
					</div>
					
				</div>
				<div class="member_tree_bottom">
					<span>C&aacute;ch copy d&#7919; li&#7879;u tr&ecirc;n c&acirc;y th&agrave;nh vi&ecirc;n v&agrave; c&aacute;c b&#7843;ng: Click ph&iacute;m chu&#7897;t tr&aacute;i v&agrave;o ph&#7847;n &#273;&#7847;u, sau &#273;&oacute; gi&#7919; ph&iacute;m Shift v&agrave; nh&#7845;n chu&#7897;t tr&aacute;i v&agrave;o ph&#7847;n sau, r&#7891;i nh&#7845;n chu&#7897;t ph&#7843;i &#273;&#7875; hi&#7875;n th&#7883; menu con. Trong menu con ch&#7885;n &quot;Copy data&quot;, sau &#273;&oacute; sang Word ho&#7863;c Excel &#273;&#7875; paste d&#7919; li&#7879;u.</span> 					
				</div>
				
			</div>	
		</div>	
	</div>
</div>
