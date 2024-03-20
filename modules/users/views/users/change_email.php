<?php 
global $tmpl;
$tmpl->setTitle(FSText::_("Thay đổi password"));
$tmpl -> addStylesheet("users_changepass","modules/users/assets/js");
?>

<div id="register-form" class ="frame_large" >
    <div class="frame_large_head">
        <div class="frame_large_head_l">
            <h1>Sửa thông tin cá nhân</h1>
        </div>
        <div class="frame_large_head_r">&nbsp;
        </div>
    </div>
    <div class="frame_large_body">
            <!--   FRAME COLOR        -->
            <div class='frame_color user_register' >
                <div class='frame_color_t'>
                    <div class='frame_color_t_r'>&nbsp; </div>
                </div>
                <div class='frame_color_m'>
                    <div class='frame_color_m_c'>
                    
                     <!--  CONTENT IN FRAME      -->
                     
					<form action="<?php echo FSRoute::_("index.php?module=users&task=edit_save_changepass");?>" name="frm_repassword_gh" method="post" id="frm_repassword_gh">
						<table width="100%" cellspacing="2">
									<tr><td colspan="2"> Nh&#7919;ng tr&#432;&#7901;ng c&#243; d&#7845;u (<font color="red">*</font>) l&#224; b&#7855;t bu&#7897;c ph&#7843;i nh&#7853;p</td></tr>
									<tr>
										<td class="label"><label>Email qu&#7843;n tr&#7883; gian h&agrave;ng :</label></td>
										<td><input class="input-wid" type="text" class="" name="text_email" readonly="readonly" value="<?php echo $_SESSION['e-email'];?>"/></td>
									</tr>
									<tr>
										<td class="label"><label>Email m&#7899;i :</label></td>
										<td><input class="input-wid" type="text" class="" name="email_new" id='email_new' value="" /></td>
									</tr>
									<tr>
										<td class="label"><label>Nh&#7853;p l&#7841;i Email m&#7899;i :</label></td>
										<td><input class="input-wid" type="text" class="" name="re_email_new" id="re_email_new" value="" /></td>
									</tr>
									<tr>
										<td class="label"><label>Nh&#7853;p m&#7853;t kh&#7849;u c&#361; (<font color="red">*</font>) :</label></td>
										<td><input type="password" name="text_pass_old" id="text_pass_old" value=""/></td>
									</tr>
									<tr>
										<td class="label"><label>Nh&#7853;p  m&#7853;t kh&#7849;u m&#7899;i (<font color="red">*</font>):</label></td>
										<td><input type="password" name="text_pass_new" id="text_pass_new"  value=""/> <font color="gray"> ( M&#7853;t kh&#7849;u ph&#7843;i &#237;t nh&#7845;t 6 k&#253; t&#7921; )</font></td>
									</tr>
									<tr>
										<td class="label">Nh&#7853;p l&#7841;i m&#7853;t kh&#7849;u m&#7899;i (<font color="red">*</font>):</td>
										<td><input type="password" name="text_re_pass_new" id="text_re_pass_new" value="" /></td>
									</tr>
									 <tr>
										<td align="right"><a href="javascript:void(0);" onclick="javascript:submitForm();" class="button7"><span>L&#432;u thay &#273;&#7893;i</span></a></td>
										<td><a href="javascript:void(0);" onclick="javascript:window.location.reload(true)" class="button7"><span>L&#224;m l&#7841;i</span></a></td>
									</tr>
								</table>
						<input type="hidden" name = "module" value = "estores" />
						<input type="hidden" name = "task" value = "edit_save_changepass" />
						<input type="hidden" name = "Itemid" value = "<?php echo FSInput::get('Itemid');?>" />
				</form>
			<!--	FORM			-->
			  </div>
                </div>
                <div class='frame_color_b'>
                    <div class='frame_color_b_r'>&nbsp; </div>
                </div>
            </div>
            <!--   end FRAME COLOR        -->
                   
           <!--   end SUBMIT REGISTER        -->
        
    </div>
    <div class="frame_large_footer">
        <div class="frame_large_footer_l">&nbsp;</div>
        <div class="frame_large_footer_r">&nbsp;</div>
    </div>
</div>    

