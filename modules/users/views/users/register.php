<?php
    global $tmpl;
    $tmpl -> addStylesheet("users_register","modules/users/assets/css");
    $tmpl -> addScript('form');
    $tmpl -> addScript('users_register','modules/users/assets/js');
    $Itemid = FSInput::get('Itemid',1);
   	$username ='Nhập username';
   	$password ='password';
   	$re_password ='password';
//    $nameass =(FSInput::get('nameass'))?FSInput::get('nameass'):'Tên hiệp hội';
    $namebuss ='Tên doanh nghiệp';
//    $address =(FSInput::get('address'))?FSInput::get('address'):'Địa chỉ';
 	$address ='Địa chỉ';
    $mobilephone ='Số điện thoại';
//    $fax =(FSInput::get('fax'))?FSInput::get('fax'):'Fax';
    $email ='Email của bạn';
    $re_email ='Xác nhận email';
    $captcha ='Nhập mã hiển thị';
?>  
<div class="wapper-content-page">
<div id="register-form" class ="frame_large" >
	    <div class="frame_large_head">
		<h1>Đăng ký thành viên</h1>
	</div>
      <div class="frame_large_body">
				<form method="post" action="#" name="register_form" class="form" >
					<div class="fieldset_item_row" >
	                  	<div class=" value">
	                  		<input type="text" name="username" id="username"  onblur="if(this.value=='') this.value='<?php echo $username; ?>'" onfocus="if(this.value=='<?php echo $username; ?>') this.value=''" value="<?php echo  $username;?>"class='txtinput'/>
	                  	</div>
	                </div>
	                <div class="fieldset_item_row" >
	                  	<div class=" float-l value">
	                  		<input type="password"" name="password" id="password"  onblur="if(this.value=='') this.value='<?php echo $password; ?>'" onfocus="if(this.value=='<?php echo $password; ?>') this.value=''" value="<?php echo  $password;?>"class='txtinput'/>
	                  	</div>
	                  	<div class="value float-r">
	                  		<input type="password" name="re_password" id="re_password" onblur="if(this.value=='') this.value='<?php echo $re_password; ?>'" onfocus="if(this.value=='<?php echo $re_password; ?>') this.value=''" value="<?php echo  $re_password;?>" class='txtinput'/>
	                  	</div>
	                  	<div class="clear"></div>
	                </div>
	                <div class="fieldset_item_row">
	                  	<div class="value float-l ">
	                  		<input type="text" name="address" id="address" onblur="if(this.value=='') this.value='<?php echo $address; ?>'" onfocus="if(this.value=='<?php echo $address; ?>') this.value=''" value="<?php echo  $address;?>" class='txtinput'/>
	                  	</div>
						<div class="value float-r" >
	                  		<input type="text" name="mobilephone" class='txtinput' id="mobilephone" onblur="if(this.value=='') this.value='<?php echo $mobilephone; ?>'" onfocus="if(this.value=='<?php echo $mobilephone; ?>') this.value=''" value="<?php echo  $mobilephone;?>" />
	                  	</div>	                  
	                  <div class="clear"></div>
	                </div>
	                <div class="fieldset_item_row">
	                  	<div class="value float-l">
	                  		<input type="text" name="email" id="email"  class='txtinput' onblur="if(this.value=='') this.value='<?php echo $email; ?>'" onfocus="if(this.value=='<?php echo $email; ?>') this.value=''" value="<?php echo  $email;?>" />
	                  	</div>
	                  	<div class="value float-r">
	                  		<input type="text" name="re-email" id="re-email"  class='txtinput' onblur="if(this.value=='') this.value='<?php echo $re_email; ?>'" onfocus="if(this.value=='<?php echo $re_email; ?>') this.value=''" value="<?php echo  $re_email;?>" />
	                  	</div>
	                  	<div class="clear"></div>
	                </div>
	                <div class="fieldset_item_row">
	                  	<div class="value">
		                	<input type="text"  id="txtCaptcha" name="txtCaptcha" class='txtinput'/>
		                    <a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
		                        <img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
		                    </a>
		                </div> 
	                  	<div class="clear"></div>
	                </div>
	                <div class="submit_form">
						<div class='button_area'>
			              	<a class="submitbt btn small submit signin-submit" href="javascript: void(0)" id='submitbt'>
								<span>&nbsp;Gửi&nbsp;</span>
							</a>
							<a class="submitbt btn small submit signin-submit" href="javascript: void(0)" id='resetbt'>
								<span>Làm lại</span>
							</a>
						</div>
					</div>
					<input type="hidden" name = "module" value = "users" />
                    <input type="hidden" name = "view" value = "users" />
                    <input type="hidden" name = "Itemid" value = "<?php echo $Itemid; ?>" />
                    <input type="hidden" name = "task" value = "register_save" />
	            </form>
	        
	    </div>
	    <div class="frame_large_footer">
	        <div class="frame_large_footer_l">&nbsp;</div>
	        <div class="frame_large_footer_r">&nbsp;</div>
	    </div>
	</div>    
</div>

