<link href="modules/users/assets/css/logged.css" media="screen" type="text/css" rel="stylesheet">
<?php 
	$total_member_7level_normal = 0;
	$count_member_normal = array(); // total 3 type: normal+gold+silver
	for($i = 0 ; $i < 7; $i ++)
	{
		$count_member_normal[$i] = isset($count_chidren[$i][0])? $count_chidren[$i][0]:0;
		$total_member_7level_normal += $count_member_normal[$i];
	}
?>
<div class="frame_display  upgrade">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>	
		<?php $Itemid = FSInput::get('Itemid'); ?>
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class='title'><span><?php echo "N&#226;ng c&#7845;p th&#224;nh vi&#234;n"; ?></span></p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
					<div id = "msg_error"></div>
						<div class="form_user_head">
							<div class="form_user_head_l">
								<div class="form_user_head_r">
									<div class="form_user_head_c">
										<span>Th&#244;ng tin c&#225; nh&#226;n c&#7911;a b&#7841;n</span>
									</div>					
								</div>					
							</div>					
						</div>	
						
						<div class="form_user_footer_body">
							<div class="form_user_footer_body_inner">
							
								<form action="<?php echo Route::_("index.php?module=users") ?>" name="form_user_upgrade" class="form_user_edit" method="post" >
									<!-- TABLE 							-->
									<table cellpadding="6" cellspacing="0">
										<tr>
											<td class="td-left"><span>H&#7885; v&#224; t&#234;n</span>:
											<span><?php echo $data->fname." ". $data -> mname ." ". $data ->lname; ?></span>
											</td>
											<td class="td-right"><span>C&#7845;p &#273;&#7897; th&#224;nh vi&#234;n:</span>
											<span class='red'>
											<?php
												echo showLevel($data->level);
												?>
											</span></td>
										</tr>
										<tr>
											<td class="td-left"><span>S&#7889; CMND: </span>
											<span><?php echo $data->identity_card; ?></span>
											</td>
											<td class="td-right"><span>T&#7893;ng th&#224;nh vi&#234;n 7 c&#7845;p: </span>
											<span><strong><?php echo $total_member_7level_normal; ?></strong></span>
											</td>
										</tr>
										<tr>
											<td class="td-left"><span>S&#7889; SIM EPS: </span>
											<span><?php echo $data ->sim_number; ?></span>
											</td>
											<td class="td-right"><span>T&#7893;ng th&#224;nh vi&#234;n c&#7845;p 1: </span>
											<span><strong><?php echo $count_member_normal[0]; ?></strong></span>
											
											</td>
										</tr>
										<tr>
											<td class="td-left"><span>S&#7889; serial: </span>
											<span><?php echo $sim_serial; ?></span>
											</td>
											<td class="td-right"><span>Doanh s&#7889; M_Load th&#225;ng <?php echo date('m/Y'); ?>:</span>
											<span><?php echo number_format(@$cm_total -> totalsale ? $cm_total -> totalsale : 0, 0, ',', '.'); ?></span>
											<span> VND </span>
											</td>
										</tr>
										<tr>
											<td class="td-left"><span>M&#227; s&#7889; ng&#432;&#7901;i gi&#7899;i thi&#7879;u: </span>
											<span><?php echo $data ->referrer_sim; ?></span></td>
											<td class="td-right"><span>Doanh s&#7889; gian h&#224;ng/N&#259;m: </span>
											<span><?php echo $cm_total -> estore_online; ?></span>
											</td>
										</tr>
										<tr>
											<td class="td-left"><span>T&#234;n Ng&#432;&#7901;i gi&#7899;i thi&#7879;u: </span>
											<span><?php echo @$referrer->fname. " ".@$referrer -> mname." ". @$referrer -> lname; ?></span></td>
											<td class="td-right"><span>Doanh s&#7889; EP th&#225;ng <?php echo date('m/Y'); ?>: </span>
											<span>Ch&#432;a c&#7853;p nh&#7853;t</span></td>
										</tr>
									</table>	
									<table>
										<tr>
											<td class="td-left1 underline" >
												<span>&#272;&#259;ng k&#237; n&#226;ng c&#7845;p l&#234;n th&#224;nh vi&#234;n</span>
											</td>
											<td class="td-right1" >
												<?php if(!$data->level) {?>
													<p><input type="radio" name="level" value ="1" checked="checked" /> <strong>Silver</strong></p>
													<p><input type="radio" name="level" value ="2" disabled="disabled"/> Golder <span>( Ch&#7881; th&#224;nh vi&#234;n Silver m&#7899;i &#273;&#432;&#7907;c n&#226;ng c&#7845;p l&#234;n Gold)</span></p>
												<?php } else if($data->level == 1) { ?>
													<p><input type="radio" name="level" value ="1" disabled="disabled" /> Silver </p>
													<p><input type="radio" name="level" value ="2" checked="checked"  /><strong>Golder</strong> </p>
												<?php  } else  {  ?>
													<p><input type="radio" name="level" value ="1" disabled="disabled" /> Silver</p>
													<p><input type="radio" name="level" value ="2"  disabled="disabled" /> Golder</p>
												<?php } ?>
											</td>
										</tr>
										<tr>
											<td class="td-left1">
												<span>&#272;i&#7873;u kho&#7843;n &#272;&#259;ng k&#237; n&#226;ng c&#7845;p th&#224;nh vi&#234;n</span>
											</td>
											<td class="td-right1">
												<textarea rows="8" cols="43" disabled="disabled"><?php echo strip_tags($config_upgrade_rules); ?></textarea>
											</td>
											
										</tr>
										<tr>
											<td class="td-left1">
											</td>
											<td class="td-right1 ">
												<p><input type="checkbox" name="read_term" id="read_term"  />
												<span class="alert orange">T&#244;i &#273;&#7891;ng &#253; v&#7899;i c&#225;c &#273;i&#7873;u kho&#7843;n tr&#234;n!</span>
												</p>
											</td>
											
										</tr>
										<tr>
											<td class="td-left1">
											</td>
											<td class="td-right1">
												<br/>
												<div><a href="javascript:void(0);" onclick="javascript:submitForm();" class="button3"><span>G&#7917;i &#273;&#259;ng k&#253;</span></a></div>
												<br/>
											</td>
										</tr>
										
									</table>
									<!-- ENd TABLE 							-->
									
									
									<input type="hidden" name = "module" value = "users" />
									<input type="hidden" name = "task" value = "upgrade_save" />
									<input type="hidden" name = "Itemid" value = "<?php echo $Itemid;?>" />
								</form>
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



<script type="text/javascript">
//<![CDATA[

function submitForm()
{
	document.getElementById('msg_error').innerHTML="";
	if(!madeCheckbox("read_term","B&#7841;n ph&#7843;i &#273;&#7891;ng &#253; v&#7899;i c&#225;c &#273;i&#7873;u kho&#7843;n n&#226;ng c&#7845;p"))
	{
		return false;
	}
	document.form_user_upgrade.submit();
}

//]]>
</script>
