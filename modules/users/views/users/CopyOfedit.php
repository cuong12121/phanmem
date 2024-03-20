<link href="modules/users/assets/css/logged.css" media="screen" type="text/css" rel="stylesheet">
<div class="frame_display  edit">
	<div class="frame_head">
		<?php global $tmpl;?>
		<?php $tmpl->loadDirectModule('newest_news');?>	
	</div>
	<div class="frame_body">
		<div class="form_head">
			<p class='title'><span><?php echo "Thay &#273;&#7893;i th&#244;ng tin c&#225; nh&#226;n"; ?></span></p>		
		</div>	
		<div class="form_body">
			<div class="form_body_inner">
				<div class="form_left">
					<div class="form_user">
						<div class="form_user_head">
							<div class="form_user_head_l">
								<div class="form_user_head_r">
									<div class="form_user_head_c">
										<span> S&#7917;a th&#244;ng tin c&#225; nh&#226;n</span>
									</div>					
								</div>					
							</div>					
						</div>	
						<div class="form_user_footer_body">
							<div class="form_user_footer_body_inner">
								<form action="<?php echo Route::_("index.php?module=users") ?>" name="form_user_edit" class="form_user_edit" method="post" enctype="multipart/form-data">
									<div id = "msg_error"></div>
									<!-- TABLE 							-->
									<table cellpadding="6" cellspacing="0">
										<tr>
											<td class="label1"><span>H&#7885; v&#224; t&#234;n</span></td>
											<td class="value1">
													<span><?php echo FSText::_("H&#7885;"); ?></span>			
													<input type="text" name="fname" id="fname" value="<?php echo $data->fname; ?>" />
													<span><?php echo FSText::_("&#272;&#7879;m"); ?></span>	
													<input type="text" name="mname" id="mname" value="<?php echo $data->mname; ?>" />
													<span><?php echo FSText::_("T&#234;n"); ?></span>	
													<input type="text" name="lname" id="lname" value="<?php echo $data->lname; ?>" />
													<span>(<?php echo FSText::_("Nh&#7853;p ch&#7919; kh&#244;ng d&#7845;u"); ?>)</span>		
											</td>
										</tr>
										<tr>
											<td class="label1"><span>Ng&#224;y sinh</span></td>
											<td class="value1">
												<span><?php echo FSText::_("Ng&#224;y"); ?></span>		
												<select name="birth_day">
													<?php 
														$day = date('d',strtotime($data->birthday));
														$month = date('m',strtotime($data->birthday));
														$year = date('Y',strtotime($data->birthday));
													?>
													<?php for($i = 1 ; $i < 32 ; $i ++ ) {?>
														<?php $check = ($i == $day) ? "selected='selected'": ""; ?>
													<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
													<?php }?>
												</select>	
												
												<span><?php echo FSText::_("Th&#225;ng"); ?></span>		
												<select name="birth_month">
													<?php for($i = 1 ; $i < 13 ; $i ++ ) {?>
													<?php $check = ($i == $month) ? "selected='selected'": ""; ?>
													<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
													<?php }?>
												</select>	
												
												<span><?php echo FSText::_("N&#259;m"); ?></span>		
												<select name="birth_year">
													<?php $current_year = date("Y");?>
													<?php for($i = $current_year ; $i > 1900 ; $i -- ) {?>
													<?php $check = ($i == $year) ? "selected='selected'": ""; ?>
													<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
													<?php }?>
												</select>	
											
											</td>
										</tr>
										<tr>
											<td class="label1"><span>Gi&#7899;i t&#237;nh</span></td>
											<td class="value1">
													<span><?php echo FSText::_("N&#7919;");?></span>
														<?php 
														if($data->sex == 'female')
														{
															$checkF = "checked='checked'";
															$checkM = "";
														}
														else
														{
															$checkM = "checked='checked'";
															$checkF = "";
														}
	
														?>
													<input type="radio" name="sex" id="sex" value = "female"  <?php echo $checkF; ?>  />
													
													<span><?php echo FSText::_("Nam");?></span> 
													<input type="radio" name="sex" id="sex" value = "male" <?php echo $checkM; ?>/>
											</td>
											
										</tr>
										<tr>
											<td class="label1"><span>S&#7889; CMND</span></td>
											<td class="value1"><span><?php echo $data->identity_card; ?></span></td>
										</tr>
										<tr>
											<td class="label1"><span>Scan CMND</span></td>
											<td class="value1">
												<input type="file" name="identity_img" title="<?php echo FSText::_("Identity"); ?>" />
												<span><?php echo "M&#7863;t tr&#432;&#7899;c, y&#234;u c&#7847;u r&#245; s&#7889; "; ?></span> 
											</td>
										</tr>
										
										<tr>
											<td class="label1"><span>&#7842;nh &#273;&#7841;i di&#7879;n</span></td>
											<td class="value1">
												<input type="file" name="avatar" title="<?php echo FSText::_("Avatar"); ?>" />
											</td>
										</tr>
										<tr>
											<td class="label1"><span>&#272;&#7883;a ch&#7881; th&#432;&#7901;ng ch&#250;</span></td>
											<td class="value1">
												<input type="text" name="origin_address" id="origin_address" value="<?php echo $data->origin_address; ?>" size="40" />
												<span><?php echo FSText::_("Theo s&#7889; CMND"); ?></span>
											</td>
										</tr>
										<tr>
											<td class="label1"><span>T&#7881;nh/th&#224;nh ph&#7889;</span></td>
											<td class="value1">
												<select name="province" id = "province">
													<?php foreach($cities as $city){?>
														<?php $checked =  ($data->province == $city->id)? " selected = 'selected'": ""; ?>
														<option value="<?php echo $city->id; ?>" <?php echo $checked; ?>><?php echo $city->name ; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										<tr>
											<td class="label1"><span>Qu&#7853;n/huy&#7879;n</span></td>
											<td class="value1">
												<select name="district" id = "district">
													<?php foreach($districts as $district){?>
														<?php $checked =  ($data->district == $district->id)?  " selected = 'selected'": ""; ?>
														<option value="<?php echo $district->id; ?>" <?php echo $checked; ?> ><?php echo $district->name ; ?></option>
													<?php } ?>
												</select>
										</tr>
										<tr>
											<td class="label1"><span>&#272;i&#7879;n tho&#7841;i</span></td>
											<td class="value1">
												<input type="text" name="phone" id="phone"  value="<?php echo $data-> phone; ?>" />
												<span><?php echo FSText::_("L&#224; s&#7889; &#273;i&#7879;n tho&#7841;i kh&#225;c(C&#243; th&#7875; l&#224; s&#7889; &#273;&#7875; b&#224;n)"); ?></span>
										</tr>
										<tr>
											<td class="label1"><span>Email</span></td>
											<td class="value1">
												<input type="text" name="email" id="email" value="<?php echo $data-> email; ?>" />
												<span><?php echo FSText::_("E-mail b&#7841;n nh&#7853;p ph&#7843;i t&#7891;n t&#7841;i, ch&#250;ng t&#244;i s&#7869; g&#7917;i m&#227; k&#237;ch ho&#7841;t v&#224;o E-mail &#273;&#243;."); ?></span>		
											</td>
										</tr>
										<tr>
											<td class="label1"><span>X&#225;c nh&#7853;n email</span></td>
											<td class="value1">
												<input type="text" name="re-email" id="re-email" value="<?php echo $data-> email; ?>" />
											</td>
										</tr>
										<tr>
											<td class="label1"><span>S&#7889; Sim EPS</span></td>
											<td class="value1"><span><?php echo $data -> sim_number; ?></span></td>
										</tr>
										<tr>
											<td class="label1"><span>C&#7845;p &#273;&#7897; th&#224;nh vi&#234;n</span></td>
											<?php $Itemid = FSInput::get('Itemid');
												$link_upgrade = Route::_("index.php?module=users&task=upgrade&Itemid=$Itemid"); 
											?>
											<td class="value1">
											<span class='red'>
												<?php
													echo showLevel($data->level);
												?>
											</span>
											<a href="<?php echo $link_upgrade; ?>" >N&#226;ng c&#7845;p th&#224;nh vi&#234;n</a></td>
										</tr>
										<tr>
											<td class="label1"><span>M&#227; s&#7889; ng&#432;&#7901;i gi&#7899;i thi&#7879;u</span></td>
											<td class="value1"><span><?php echo $data -> referrer_sim; ?></span></td>
										</tr>
										<tr>
											<td class="label1"><span>T&#234;n ng&#432;&#7901;i gi&#7899;i thi&#7879;u</span></td>
											<td class="value1"><span><?php echo @$referrer->fname. " ".@$referrer -> mname." ". @$referrer -> lname; ?></span></td>
										</tr>
										<tr>
											<td class='label1'><font>*</font><?php echo FSText::_("M&#7853;t kh&#7849;u c&#361;")?></td>
											<td class='value1'>
												<input type="password" name="old_password" id="old_password" />
											</td>
										</tr>
										<tr>
											<td class='label1'><font>*</font><?php echo FSText::_("M&#7853;t kh&#7849;u m&#7899;i")?></td>
											<td class='value1'>
												<input type="password" name="password" id="password" />
												<span><?php echo FSText::_("&#205;t nh&#7845;t 6 k&#253; t&#7921; tr&#7903; l&#234;n"); ?></span>						
											</td>
										</tr>
										<tr>
											<td class='label1'><font>*</font><?php echo FSText::_("X&#225;c nh&#7853;n m&#7853;t kh&#7849;u")?></td>
											<td class='value1'>
												<input type="password" name="re-password" id="re-password" />
											</td>
										</tr>
									</table>	
									<!-- ENd TABLE 							-->
									
									<!-- BUTTON				-->
									<div class="form_button">
									
									<?php 
									$Itemid = FSInput::get('Itemid');
									$link_edit = Route::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
									$link_refresh = Route::_("index.php?module=users&task=edit&Itemid=$Itemid"); 
									?>
										<a href="javascript:void(0);" onclick="javascript:submitForm();" class="button3"><span>L&#432;u thay &#273;&#7893;i</span></a>
										<a href="javascript:window.location.reload( false );" class="button3"><span> L&#224;m l&#7841;i </span></a>
										
									</div>
									<!-- end BUTTON				-->
									
									<input type="hidden" name = "module" value = "users" />
									<input type="hidden" name = "task" value = "edit_save" />
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
$(function(){
	$("select#province").change(function(){
		$.getJSON("index.php?module=users&task=district&raw=1",{cid: $(this).val()}, function(j){
			
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
				
			}
			$("#district").html(options);
			$('#district option:first').attr('selected', 'selected');
		})
	})			
})

function submitForm()
{
	if(checkFormsubmit())
		document.form_user_edit.submit();
}

function checkFormsubmit()
{
	document.getElementById('msg_error').innerHTML="";
	count_error = 0;
	if(!notEmpty("fname","<?php echo FSText::_("Firt name is not empty"); ?>"))
	{
		count_error++;
	}
	if(!notEmpty("lname","<?php echo FSText::_("Last name is not empty"); ?>"))
	{
		count_error++;
	}
	if(!notEmpty("origin_address","<?php echo FSText::_("Address is not empty"); ?>"))
	{
		count_error++;
	}
	
	if(!emailValidator("email","<?php echo FSText::_("Invalid email"); ?>"))
	{
		count_error++;
	}
	if(!checkMatchEmail("<?php echo FSText::_("Re-email is not math the Email"); ?>"))
	{
		count_error++;
	}
	if(!notEmpty("phone","<?php echo FSText::_("Phone is not empty"); ?>"))
	{
		count_error++;
	}
	
	if(!checkMatchPass("<?php echo FSText::_("Re-password is not math the Password"); ?>"))
	{
		count_error++;
	}
	
	if(count_error > 0)
	{
		return false;
	}

	return true;
}


//]]>
</script>