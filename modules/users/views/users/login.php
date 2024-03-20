<?php 
	global $tmpl;
	$tmpl->setTitle("&#272;&#259;ng nh&#7853;p");
	$tmpl -> addStylesheet("users_login","modules/users/assets/css");
	$Itemid = FSInput::get('Itemid',1);
	$redirect = FSInput::get('redirect');
	$username = FSInput::get('username');
	if(!$username){
		$username="Username";
	}
	$password ="Password";
?>	
<div id="login-form" class ="frame_large" >
    <div class="frame_auto_head">
		<div class="frame_auto_head_l">
			<h1>Đăng nhập</h1>
		</div>
		<div class="frame_auto_head_inner"></div>
		<div class="frame_auto_head_r"></div>
	</div>
    <div class="frame_auto_body">
           
            <!--   FRAME COLOR        -->
            <div class='frame_color'>
               
                    <!--  CONTENT IN FRAME      -->
		           <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="login_form" class="login_form fff-form"  method="post">
		               <div class="fff-form-group fff-form-small">
		            	   <input id="user_email" type="text" size="30" name="username"  onblur="if(this.value=='') this.value='<?php echo $username; ?>'" onfocus="if(this.value=='<?php echo $username; ?>') this.value=''" value="<?php echo $username; ?>" />
		               </div>
		               <div class="fff-form-group fff-form-small">
							<input id="user_password" type="password" size="30"  name="password" onblur="if(this.value=='') this.value='<?php echo $password; ?>'" onfocus="if(this.value=='<?php echo $password; ?>') this.value=''" value="<?php echo $password; ?>" >
						</div>
						<div class="fff-form-group login-options fb-connect-wrapper">
							<input type="submit" class='submitbt btn small submit signin-submit' name="submitbt" value = "<?php echo FSText::_("&#272;&#259;ng nh&#7853;p");?>"   /> 
						</div>
						<div class="fff-form-group fff-form-small link float-l">
							<a class="ls-link" href="<?php echo FSRoute::_("index.php?module=users&task=forget&Itemid=156");?>" ><?php echo FSText::_("Qu&#234;n m&#7853;t kh&#7849;u")?></a>
						</div>
						<div class="fff-form-group fff-form-small link float-r person_info" >
							<a class="button2 ls-link" href="<?php echo FSRoute::_("index.php?module=users&task=register&Itemid=39"); ?>">
                               <span><?php echo FSText::_("&#272;&#259;ng k&#253; th&#224;nh vi&#234;n"); ?></span>
                            </a>
						</div>
		                <input type="hidden" name = "module" value = "users" />
		                <input type="hidden" name = "view" value = "users" />
		                <input type="hidden" name = "task" value = "login_save" />
		                <input type="hidden" name = "Itemid" value = "<?php echo $Itemid;?>" />
		                <?php if($redirect)
		                    echo "<input type='hidden' name = 'redirect' value = '$redirect' />";  
		                ?>
		            </form> 
		            
		            <!--    RIGHT       -->
		            
		           <!--  end CONTENT IN FRAME      -->
                              
            </div>
            <!--   end FRAME COLOR        -->
            
    </div>
   	<div class="frame_auto_footer">
		<div class="frame_footer_left">&nbsp;</div>
		<div class="frame_footer_right">&nbsp;</div>
	</div>
</div>    
		
		