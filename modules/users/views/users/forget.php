<?php 
    global $tmpl;
    $tmpl->addTitle("Quên mật khẩu");
    $tmpl -> addStylesheet("users_forget","modules/users/assets/css");
    $Itemid = FSInput::get('Itemid',1);
    $redirect = FSInput::get('redirect');
?> 
<div class="transverse_s"></div> 
<div id="login-form" class ="frame_large fp-form" >
    <div class="frame_auto_head_1">
		
			<h1>Quên mật khẩu</h1>
	</div>
	<div class="frame_auto_body">
           
            <!--   FRAME COLOR        -->
                    
                    <!--  CONTENT IN FRAME      -->
                   <form action="<?php echo FSRoute::_("index.php?module=users") ?>" name="forget_form" class="forget_form fff-form fff-form-i forgot-password-form " method="post">
                       <div class="foget fff-form-group fff-form-small">
		                	<label for="user_email">Vui l&#242;ng nh&#7853;p e-mail c&#7911;a b&#7841;n khi &#273;&#259;ng k&#237; th&#224;nh vi&#234;n.</label>
		                    <input id="user_email" class=" txtinput email-field" type="text" size="30" name="email">
			            </div>
			            <div class="fff-form-group fff-form-small">
							<button class="btn green submit2 small" type="submit" name="button">Đồng ý</button>
						</div>
                       <input type="hidden" name = "module" value = "users" />
                       <input type="hidden" name = "view" value = "users" />
                       <input type="hidden" name = "task" value = "forget_save" />
                    </form> 
                    
                    <!--    RIGHT       -->
                    <div class='person_info'>
                         <?php echo $config_person_forget; ?>
                    </div>
                    
                   <!--  end CONTENT IN FRAME      -->
           
            </div>
</div>    
