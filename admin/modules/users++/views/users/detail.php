
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->

<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');  
	?>
<!-- END HEAD-->


<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
    <div class="form-contents">
	<form action="index.php?module=users&view=users" name="adminForm" method="post">
		<fieldset>
			<legend><?php echo FSText :: _("user info");?></legend>
		
			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Username'); ?>
					</td>
					<td>
						<input type="text" name='username' value="<?php echo isset($_SESSION['users']['users']['username']) ? $_SESSION['users']['users']['username'] : @$data->username; ?>"  id="username">
						<label class="error_username"></label>
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Email'); ?>
					</td>
					<td>
						<input type="text" name='email' value="<?php echo isset($_SESSION['users']['users']['email']) ? $_SESSION['users']['users']['email'] :  @$data->email; ?>" id="email" >
						<label class="error_email"></label>
					</td>
				</tr>

				<?php if(isset($data) AND @$data -> id != 9 AND $data -> id != $_SESSION['ad_userid']){ ?>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Published'); ?>
					</td>
					<td>
						<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Ordering'); ?>
					</td>
					<td>
						<input type="text" name='ordering' value="<?php echo isset($_SESSION['users']['users']['ordering']) ? $_SESSION['users']['users']['ordering'] : @$data->ordering; ?>">
					</td>
				</tr>
			</table>
			</fieldset>

			
			<fieldset>
				<legend><?php echo FSText :: _("Password");?></legend>
				<table cellspacing="1" class="admintable">
					<?php if(@$data){?>
					<tr>
						<td class="label1"><span><?php echo FSText::_('Sửa password')?></span></td>
						<td class="value1">
							<input type="radio" name="edit_pass" id="edit_pass1" class='edit_pass' value="1" /> Có
							<input type="radio" name="edit_pass" id="edit_pass0" class='edit_pass'  value="0" checked="checked"/> Không
						</td>
					</tr>
					<?php }?>

					<tr class='password_area <?php echo @$data -> id?"hide":""?>'>
						<td class='label1'><font>*</font><?php echo FSText::_("Password")?></td>
						<td class='value1'>
							<input type="password" name="password1" id="password" />
						</td>
					</tr>
					<tr class='password_area <?php echo @$data -> id?"hide":""?>'>
						<td class='label1'><font>*</font><?php echo FSText::_("Re-Password")?></td>
						<td class='value1'>
							<input type="password" name="re-password1" id="re-password" />
						</td>
					</tr>
					<tr class='password_area <?php echo @$data -> id?"hide":""?>'>
						<td class='label1'></td>
						<td class='value1'>
							<label class="error_password"></label>
						</td>
					</tr>
					
				</table>
				
			</fieldset>
			



			<fieldset>
				<legend><?php echo FSText :: _("Other information");?></legend>
				<table cellspacing="1" class="admintable">
					
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('First name'); ?>
						</td>
						<td>
							<input type="text" name='fname' value="<?php echo isset($_SESSION['users']['users']['fname']) ? $_SESSION['users']['users']['fname'] :  @$data->fname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Middle-last name'); ?>
						</td>
						<td>
							<input type="text" name='lname' value="<?php echo isset($_SESSION['users']['users']['lname']) ? $_SESSION['users']['users']['lname'] :  @$data->lname; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Phone'); ?>
						</td>
						<td>
							<input type="text" name='phone' value="<?php echo isset($_SESSION['users']['users']['phone']) ? $_SESSION['users']['users']['phone'] :  @$data->phone; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Address'); ?>
						</td>
						<td>
							<input type="text" name='address' value="<?php echo isset($_SESSION['users']['users']['address']) ? $_SESSION['users']['users']['address'] :  @$data->address; ?>" >
							
						</td>
					</tr>
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Country'); ?>
						</td>
						<td>
							<input type="text" name='country' value="<?php echo isset($_SESSION['users']['users']['country']) ? $_SESSION['users']['users']['country'] : @$data->country; ?>" >
							
						</td>
					</tr>
				</table>
			</fieldset>

			<fieldset>
				<legend><?php echo FSText :: _("Phần nhóm quyền cho Tin Tức");?></legend>
				<table cellspacing="1" class="admintable">
					<tr>
						<td valign="top" class="key">
							<?php echo FSText :: _('Nhóm'); ?>
						</td>
						<td>
							<select name="group_id">
								<option value="0">Chọn nhóm</option>
								<option value="1" <?php echo  @$data->group_id == 1 ? 'selected' : ''  ?> >Biên tập viên</option>
								<option value="2" <?php echo  @$data->group_id == 2 ? 'selected' : ''  ?> >Trưởng ban biên tập</option>
							</select>
						</td>
					</tr>
				</table>
			</fieldset>
			
		
		<input id="id_user" name="id" type="hidden" value="<?php echo isset($data) ? $data->id : 0  ?>">
		<input type="hidden" value="users" name="view">
		<input type="hidden" value="users" name="module">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
    </div><!--end: .form-contents-->
</div>
<!-- END BODY-->

<script type="text/javascript">
	function formValidator()
	{
		
		if(!notEmpty('username','T&#234;n &#273;&#259;ng nh&#7853;p kh&#244;ng &#273;&#432;&#7907;c &#273;&#7875; tr&#7889;ng'))
			return false;
		if(!checkMatchPass('M&#7853;t kh&#7849;u nh&#7853;p l&#7841;i kh&#244;ng &#273;&#250;ng'))
			return false;
		if(!emailValidator('email','B&#7841;n ph&#7843;i nh&#7853;p &#273;&#7883;a ch&#7881; Email'))
			return false;
		if(!madeSelection('groups','B&#7841;n ph&#7843;i ch&#7885;n nh&#243;m cho th&#224;nh vi&#234;n n&#224;y'))
			return false;
		return true;
	}
	$('#edit_pass0').click(function(){
		$('.password_area').addClass('hide');
	});
	$('#edit_pass1').click(function(){
		$('.password_area').removeClass('hide');
	});
</script>


<script  type="text/javascript" language="javascript">

	function passwordStrength(password1,password2) {
		// alert(password1);
		// var password1 = $(".admintable #password1").val();
		// // var username = $(".admintable #re-password1");
		// var password1 = $(".admintable #re-password1").val();
		// console.log(password1);
		// console.log(password2);
		// alert(password1);
		// alert(password2);

        var shortPass = 1, badPass = 2, goodPass = 3, strongPass = 4, mismatch = 5, symbolSize = 0, natLog, score;

        // password 1 != password 2
        if ( (password1 != password2) && password2.length > 0)
            return mismatch;

        //password < 4
        if (password1.length < 4)
            return shortPass;

        //password1 == username
        // if ( password1.toLowerCase() == username.toLowerCase() )
        //     return badPass;

        if ( password1.match(/[0-9]/) )
            symbolSize +=10;
        if ( password1.match(/[a-z]/) )
            symbolSize +=26;
        if ( password1.match(/[A-Z]/) )
            symbolSize +=26;
        if ( password1.match(/.,[,!,@,#,$,%,^,&,*,?,_,~,-,(,),]/) )
            symbolSize +=26;
        if ( password1.match(/[^a-zA-Z0-9]/) )
            symbolSize +=31;

        natLog = Math.log( Math.pow(symbolSize, password1.length) );
        score = natLog / Math.LN2;

        if (score < 40 )
            return badPass;

        if (score < 56 )
            return goodPass;

        // console.log(strongPass);
        // console.log('----');

        return strongPass;
    }

	$(function(){
		
		$(".admintable #password").keyup(function(){
			pass1 = $(".admintable #password").val();
			pass2 = $(".admintable #re-password").val();
			// alert(pass1);
		    result = passwordStrength(pass1,pass2);

		    if(result == 1){
		    	msg = 'Password quá ngắn, không nên dùng';
		    }

		    if(result == 2){
		    	msg = 'Password ngắn, bảo mật thấp';
		    }

		    if(result == 3){
		    	msg = 'Password có thể sử dụng, bảo mật trung bình';
		    }

		    if(result == 4){
		    	msg = 'Password tốt mạnh, nên dùng';
		    }

		    if(result == 5){
		    	msg = 'Password 2 nhập lại không trùng với Password 1';
		    } 

		    $(".admintable .error_password").html(msg);
		    $(".admintable .error_password").css('color','blue');
			
		});

		$(".admintable #re-password").keyup(function(){
			pass1 = $(".admintable #password").val();
			pass2 = $(".admintable #re-password").val();
		    result = passwordStrength(pass1,pass2);

		    if(result == 1){
		    	msg = 'Password quá ngắn, không nên dùng';
		    }

		    if(result == 2){
		    	msg = 'Password ngắn, bảo mật thấp';
		    }

		    if(result == 3){
		    	msg = 'Password có thể sử dụng, bảo mật trung bình';
		    }

		    if(result == 4){
		    	msg = 'Password tốt mạnh, nên dùng';
		    }

		    if(result == 5){
		    	msg = 'Password 2 nhập lại không trùng với Password 1';
		    } 

		    $(".admintable .error_password").html(msg);
		    $(".admintable .error_password").css('color','blue');
			// alert(result);
		});


		
		

		$(".admintable #username").keyup(function(){
			var name = $(this).val();
			var id_user = $('#id_user').val()

			
			var illegalChars = /\W/; // allow letters, numbers, and underscores
		    if (illegalChars.test(name)) {
				$(".admintable .error_username").html('Viết liền không dấu');
				$(".admintable .error_username").css('color','red');
				return false;
		    } 

			

			// alert()
			// console.log(data_id);
			$.ajax({url: "index.php?module=users&view=users&task=ajax_check_name&raw=1",
				data: {name:name,id_user:id_user},
				dataType: "text",
				success: function(data) {
					// console.log(data);
					if(data == 1){
						// $(".admintable #name").css('border','red 1px solid');
						$(".admintable .error_username").html('Tên này đã tồn tại !');
						$(".admintable .error_username").css('color','red');
					}else{
						// $("#fragment-1 #name").css('border','#ccc 1px solid');
						$(".admintable .error_username").html('Tên này được chấp nhận');
						$(".admintable .error_username").css('color','#a0a0a0');
						if(!name){
							$(".admintable .error_username").html('Không được để trống');
							$(".admintable .error_username").css('color','red');
						}
					}
				}
			});
		});

		$(".admintable #email").keyup(function(){
			var email = $(this).val();
			var id_user = $('#id_user').val()
			// alert()
			// console.log(data_id);
			$.ajax({url: "index.php?module=users&view=users&task=ajax_check_email&raw=1",
				data: {email:email,id_user:id_user},
				dataType: "text",
				success: function(data) {
					// console.log(data);
					if(data == 1){
						// $(".admintable #name").css('border','red 1px solid');
						$(".admintable .error_email").html('Email này đã tồn tại !');
						$(".admintable .error_email").css('color','red');
					}else{
						// $("#fragment-1 #name").css('border','#ccc 1px solid');
						$(".admintable .error_email").html('Email này được chấp nhận');
						$(".admintable .error_email").css('color','#a0a0a0');
					}
				}
			});
		});	


						
		
	});
</script>



<!-- function validateUsername(fld) {
    var error = "";
    var illegalChars = /\W/; // allow letters, numbers, and underscores
 
    if (fld.value == "") {
        fld.style.background = 'Yellow';
        error = "You didn't enter a username.\n";
        alert(error);
        return false;
 
    } else if ((fld.value.length < 5) || (fld.value.length > 15)) {
        fld.style.background = 'Yellow';
        error = "The username is the wrong length.\n";
		alert(error);
		return false;
 
    } else if (illegalChars.test(fld.value)) {
        fld.style.background = 'Yellow';
        error = "The username contains illegal characters.\n";
		alert(error);
		return false;
 
    } else {
        fld.style.background = 'White';
    }
    return true;
} -->