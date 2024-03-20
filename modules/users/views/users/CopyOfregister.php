<?php 
    global $tmpl;
    $tmpl->setTitle("Đăng ký");
    $tmpl -> addStylesheet("users_register","modules/users/assets/css");
    $tmpl -> addScript('form');
    $tmpl -> addScript('users_register','modules/users/assets/js');
    $Itemid = FSInput::get('Itemid',1);
?>  
<div id="register-form" class ="frame_large" >
    <div class="frame_auto_head">
		<div class="frame_auto_head_l">
			<h1>Đăng ký</h1>
		</div>
		<div class="frame_auto_head_inner"></div>
		<div class="frame_auto_head_r"></div>
	</div>
    <div class="frame_auto_body">
           <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="register_form" class="register_form" method="post">
            
            <!--   FRAME COLOR        -->
            <div class='frame_color user_register' >
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                    
                    <!--  CONTENT IN FRAME      -->
                    <table width="100%" cellpadding="5">
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Tên truy cập")?></td>
                            <td class='value'>
                                <input type="text" name="username" id="username" value="<?php echo FSInput::get('username');?>" class='txtinput'/>
                                <span><?php echo FSText::_("Chỉ gồm kí tự: chữ và số, '_','-'"); ?></span>                      
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("M&#7853;t kh&#7849;u")?></td>
                            <td class='value'>
                                <input type="password" name="password" id="password"  class='txtinput'/>
                                <span><?php echo FSText::_("&Iacute;t nh&#7845;t 6 k&yacute; t&#7921; tr&#7903; l&ecirc;n"); ?></span>                      
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("X&aacute;c nh&#7853;n m&#7853;t kh&#7849;u")?></td>
                            <td class='value'>
                                <input type="password" name="re-password" id="re-password" class='txtinput' />
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Họ và tên đệm")?></td>
                            <td class='value'>
                                <input type="text" name="fname" id="fname"  value="<?php echo FSInput::get('fname');?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Tên")?></td>
                            <td class='value'>
                                <input type="text" name="lname" id="lname"  value="<?php echo FSInput::get('lname');?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Ng&agrave;y sinh")?></td>
                            <td class='value'>
                                <span><?php echo FSText::_("Ng&agrave;y"); ?></span>
                                <select name="birth_day">
									<?php for($i = 1 ; $i < 32 ; $i ++ ) {?>
											<?php $check = ($i == FSInput::get('birth_day')) ? "selected='selected'": ""; ?>
										<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
									<?php }?>
								</select>	
                                
                                <span><?php echo FSText::_("Th&aacute;ng"); ?></span>       
                                <select name="birth_month">
									<?php for($i = 1 ; $i < 13 ; $i ++ ) {?>
										<?php $check = ($i == FSInput::get('birth_month')) ? "selected='selected'": ""; ?>
										<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
									<?php }?>
								</select>	
                                
                                <span><?php echo FSText::_("N&#259;m"); ?></span>     
                                <select name="birth_year">
									<?php $current_year = date("Y");?>
										<?php for($i = $current_year ; $i > 1900 ; $i -- ) {?>
										<?php $check = ($i == FSInput::get('birth_year')) ? "selected='selected'": ""; ?>
										<option value="<?php echo $i; ?>" <?php echo $check; ?> ><?php echo $i; ?></option>
									<?php }?>
								</select>	
                            </td>
                        </tr>
                        
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Gi&#7899;i t&iacute;nh")?></td>
                            <td class='value'>
                                <?php 
									if(FSInput::get('sex') == 'female'){
										$checkF = "checked='checked'";
										$checkM = "";
									}else{
										$checkM = "checked='checked'";
										$checkF = "";
									}
								?>
								<span>N&#7919;</span>
								<input type="radio" name="sex" id="sex_female" value = "female"  <?php echo $checkF; ?>  />
										
								<span><?php echo FSText::_("Nam");?></span> 
								<input type="radio" name="sex" id="sex_male" value = "male" <?php echo $checkM; ?>/>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Email")?></td>
                            <td class='value'>
                                <input type="text" name="email" id="email"  class='txtinput' value="<?php echo FSInput::get('email'); ?>"/>
                                <br/>
                                <span><?php echo FSText::_("E-mail c&#7911;a b&#7841;n ph&#7843;i t&#7891;n t&#7841;i &#273;&#7875; c&#243; th&#7875; s&#7917; d&#7909;ng t&#237;nh n&#259;ng \"Qu&#234;n m&#7853;t kh&#7849;u\", ch&#250;ng t&#244;i s&#7869; g&#7917;i m&#7853;t kh&#7849;u m&#7899;i v&#224;o e-mail n&#224;y!"); ?></span>                      
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("X&aacute;c nh&#7853;n Email")?></td>
                            <td class='value'>
                                <input type="text" name="re-email" id="re-email"  class='txtinput' />
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Điện thoại di động")?></td>
                            <td class='value'>
                                <input type="text" name="mobilephone" id="mobilephone" value="<?php echo FSInput::get('mobilephone'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><?php echo FSText::_("Điện thoại cố định")?></td>
                            <td class='value'>
                                <input type="text" name="telephone" id="telephone" value="<?php echo FSInput::get('telephone'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("T&#7881;nh")."/".FSText::_("Th&agrave;nh ph&#7889;")?></td>
                            <td class='value'>
                                <select name="province" id = "province">
                                    <?php foreach($cities as $city){?>
                                    	<?php $check = ($city->id == $city_current) ? "selected='selected'": ""; ?>
                                        <option value="<?php echo $city->id; ?>" <?php echo $check; ?> ><?php echo $city->name ; ?></option>
                                    <?php } ?>
                                </select>
                                
                                <strong><?php echo FSText::_("Qu&#7853;n/Huy&#7879;n"); ?></strong>
                                
                                <select name="district" id = "district">
                                    <?php foreach($districts as $district){?>
                                    	<?php $check = ($district->id == $district_current) ? "selected='selected'": ""; ?>
                                        <option value="<?php echo $district->id; ?>" <?php echo $check; ?> ><?php echo $district->name ; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Nh&#7853;p m&atilde; hi&#7875;n th&#7883;"); ?></td>
                            <td class='value'>
                                <input type="text"  id="txtCaptcha" value="" name="txtCaptcha"  maxlength="10" size="23" />
		                        <a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" />
		                            <img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
		                        </a>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "Itemid" value = "<?php echo $Itemid; ?>" />
                    <input type="hidden" name = "task" value = "register_save" />
                
                   <!--  end CONTENT IN FRAME      -->
           
                    </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
            <!--   end FRAME COLOR        -->
            
            <!--   ESTORE REGISTER        -->
            <h3>
            	<?php $check_register_estore = FSInput::get('use_estore',0,'int'); ?>
				<input type="checkbox" value="1" name="use_estore" id="use_estore" <?php echo $check_register_estore?'checked="checked"':''?> >
				<label for="use_estore">Click để Đăng ký gian hàng</label>&nbsp;
			</h3>
            <div class='frame_color' id='estore_register'  <?php echo $check_register_estore?'':'style="display: none"'?>  >
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                    
                    <!--  CONTENT IN FRAME      -->
                    <div class='register_rule'><?php echo ($config_register_info); ?></div>
                   <table width="100%" cellpadding="5">
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Tên gian hàng")?></td>
                            <td class='value'>
                                <input type="text" name="cpn_name" id="cpn_name" class='txtinput'  value="<?php echo FSInput::get('cpn_name'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Điện thoại cố định")?></td>
                            <td class='value'>
                                <input type="text" name="cpn_telephone" id="cpn_telephone"  class='txtinput' value="<?php echo FSInput::get('cpn_telephone'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Điện thoại di động của công ty")?></td>
                            <td class='value'>
                                <input type="text" name="cpn_mobilephone" id="cpn_mobilephone"  class='txtinput' value="<?php echo FSInput::get('cpn_mobilephone'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'>Fax</td>
                            <td class='value'>
                                <input type="text" name="cpn_fax" id="fax" class='txtinput'  value="<?php echo FSInput::get('cpn_fax'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><?php echo FSText::_("Website") ?></td>
                            <td class='value'>
                                <input type="text" name="cpn_website" id="cpn_website" value="<?php echo FSInput::get('cpn_website'); ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><font>*</font><?php echo FSText::_("Địa chỉ") ?></td>
                            <td class='value'>
                                <input type="text" name="cpn_address" id="cpn_address" value="<?php echo isset($_POST['cpn_address'])?$_POST['cpn_address']:''; ?>" size="83"/>
                            </td>
                        </tr>
                        <tr>
                            <td class='label'><?php echo FSText::_("Thông tin chung") ?></td>
                            <td class='value'>
                            	<textarea rows="5" cols="80" name='cpn_intro' id='cpn_intro' onkeyup="return ismaxlength(this,500)" ><?php echo FSInput::get('cpn_intro');?></textarea>
                            	<ul>
                            		<li>Tối đa 500 kí tự</li>
                            		<li>Không chứa link, thẻ HTML</li>
                            	</ul>
                            </td>
                        </tr>
                    </table>
                    <input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "Itemid" value = "<?php echo $Itemid; ?>" />
                    <input type="hidden" name = "task" value = "register_save" />
                
                   <!--  end CONTENT IN FRAME      -->
           
                    </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
           <!--   end ESTORE REGISTER        -->
           
           
            <!--   SUBMIT REGISTER        -->
            <div class='frame_color user_submit' >
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                    
                    <!--  CONTENT IN FRAME      -->
                   <div class='register_rule'><?php echo ($config_register_rules); ?></div>
                   <!--  end CONTENT IN FRAME      -->
                          <input type="checkbox" name="read_term" id="read_term"  />
                          <span class="alert"><?php echo FSText::_("T&ocirc;i &#273;&#7891;ng &yacute; v&#7899;i c&aacute;c &#273;i&#7873;u kho&#7843;n tr&ecirc;n"); ?> </span>
                    </div>
                        <input type="button" value="<?php echo FSText::_("&#272;&#259;ng k&yacute;"); ?>" name="submitbt" id="submitbt" />
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
           <!--   end SUBMIT REGISTER        -->
            </form>
        
    </div>
    <div class="frame_auto_footer">
		<div class="frame_footer_left">&nbsp;</div>
		<div class="frame_footer_right">&nbsp;</div>
	</div>
</div>    
