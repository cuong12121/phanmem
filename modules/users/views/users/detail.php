<link href="modules/users/assets/css/logged.css" media="screen" type="text/css" rel="stylesheet" />
<div class="frame_display  logged">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>	
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class='title'><span><?php echo "Th&#244;ng tin c&#225; nh&#226;n"; ?></span></p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
						<div class="form_user_head">
							<div class="form_user_head_l">
								<div class="form_user_head_r">
									<div class="form_user_head_c">
										<span> Th&#244;ng tin c&#225; nh&#226;n c&#7911;a b&#7841;n</span>
									</div>					
								</div>					
							</div>					
						</div>	
						<div class="form_user_footer_body">
							<div class="form_user_footer_body_inner">
								<!-- TABLE 							-->
								<table cellpadding="6" cellspacing="0">
									<tr>
										<td class="label1"><span>H&#7885; v&#224; t&#234;n</span></td>
										<td class="value1"><span><?php echo $data->fname." ". $data -> mname ." ". $data ->lname; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>Ng&#224;y sinh</span></td>
										<td class="value1"><span><?php echo date("d-m-Y",strtotime($data->birthday)); ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>Gi&#7899;i t&#237;nh</span></td>
										<td class="value1"><span><?php echo $data->sex == "male"?'nam':'n&#7919;'; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>Scan CMND</span></td>
										<td class="value1">
											<?php 
												if(!@$data->identity_img)
													 echo "Ch&#432;a c&#7853;p nh&#7853;t";
												else {
													$link_identity_img = URL_IMG_MEMBER_IDENTITY."/". $data->identity_img;
													echo "<a href='$link_identity_img' > "."&#7842;nh"."</a>"; 
												}
												?>
											
										</td>
									</tr>
									<tr>
										<td class="label1"><span>S&#7889; CMND</span></td>
										<td class="value1"><span><?php echo $data->identity_card ? $data->identity_card: "Ch&#432;a c&#7853;p nh&#7853;t"; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>&#7842;nh &#273;&#7841;i di&#7879;n</span></td>
										<td class="value1">
											<?php 
												if(!@$data->avatar)
													 echo "Ch&#432;a c&#7853;p nh&#7853;t";
												else {
													$link_avatar = URL_IMG_MEMBER_AVATAR."/". $data->avatar;
													echo "<a href='$link_avatar' > "."&#7842;nh"."</a>"; 
												}
												?>
										</td>
									</tr>
									<tr>
										<td class="label1"><span>&#272;&#7883;a ch&#7881; th&#432;&#7901;ng ch&#250;</span></td>
										<td class="value1"><span><?php echo $data->origin_address?$data->origin_address:"Ch&#432;a c&#7853;p nh&#7853;t"; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>T&#7881;nh/th&#224;nh ph&#7889;</span></td>
										<td class="value1"><span><?php echo $province?$province:"&nbsp"; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>Qu&#7853;n/huy&#7879;n</span></td>
										<td class="value1"><span><?php echo $district?$district:"&nbsp"; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>&#272;i&#7879;n tho&#7841;i</span></td>
										<td class="value1"><span><?php echo $data -> phone?$data -> phone:"&nbsp"; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>Email</span></td>
										<td class="value1"><span><?php echo $data -> email?$data -> email:"&nbsp"; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>S&#7889; sim</span></td>
										<td class="value1"><span><?php echo $data -> sim_number; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>C&#7845;p &#273;&#7897; th&#224;nh vi&#234;n</span></td>
										<td class="value1"><span class='red'>
										<?php
											echo showLevel($data->level);
										?>
										</span></td>
									</tr>
									<tr>
										<td class="label1"><span>S&#272;T ng&#432;&#7901;i gi&#7899;i thi&#7879;u</span></td>
										<td class="value1"><span><?php echo $data -> referrer_sim; ?></span></td>
									</tr>
									<tr>
										<td class="label1"><span>T&#234;n ng&#432;&#7901;i gi&#7899;i thi&#7879;u</span></td>
										<td class="value1"><span>
											<?php 
											if(@$referrer->fname)
											{
												echo @$referrer->fname. " ".@$referrer -> mname." ". @$referrer -> lname; 	
											} 
											else
												echo "&nbsp";
											?>
											</span></td>
									</tr>
								</table>	
								<!-- ENd TABLE 							-->
								
								<!-- BUTTON				-->
								<div class="form_button">
								<?php 
								$Itemid = FSInput::get('Itemid');
								$link_edit = Route::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
								$link_upgrade = Route::_("index.php?module=users&task=upgrade&Itemid=$Itemid"); 
								?>
									<a href="<?php echo $link_edit; ?>" class="button3"><span>Thay &#273;&#7893;i th&#244;ng tin c&#225; nh&#226;n &#187;</span></a>
									<a href="<?php echo $link_upgrade; ?>" class="button3"><span>N&#226;ng c&#7845;p th&#224;nh vi&#234;n &#187;</span></a>
								</div>
								<!-- end BUTTON				-->
							</div>
						</div>
						<div class="form_user_footer">
							<div class="form_user_footer_l">
								<div class="form_user_footer_r">
									<div class="form_user_footer_c">
									</div>					
								</div>					
							</div>					
						</div>					
					</div>
				</div>
				<div class="form_right">
					<?php $tmpl -> loadModules('right-inner','Round'); ?>
				</div>
				
			</div>	
		</div>	
	</div>
</div>
