<table cellspacing="1" class="admintable">
<?php
TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập'),'username',@$data -> username,'',40,1,0,FSText::_("Không được để trống"));
TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
TemplateHelper::dt_edit_selectbox(FSText::_('Nhóm quyền'),'group_id',@$data -> group_id,0,$groups,$field_value = 'id', $field_label='name',$size = 1,0,1);

TemplateHelper::dt_edit_selectbox(FSText::_('Tài khoản tổng'),'parent_id',@$data -> parent_id,0,$users,$field_value = 'id', $field_label='username',$size = 1,0,1);

TemplateHelper::dt_edit_selectbox('Kho','wrap_id_warehouses',@$data -> wrap_id_warehouses,0,$warehouses,'id', 'name',$size = 1,1,1,FSText::_("giữ Ctrl để chọn nhiều kho"));


?>


<?php if(!empty($data)){?>
	<div class="form-group">
	    <label class="col-md-2 col-xs-12 control-label">Sửa password</label>
	    <div class="col-md-10 col-xs-12">
	    	<input type="radio" name="edit_pass" id="edit_pass1" class='edit_pass' value="1" /> Có
			<input type="radio" name="edit_pass" id="edit_pass0" class='edit_pass'  value="0" checked="checked"/> Không
		</div>
	</div>
<?php }?>

	<div class='form-group password_area <?php echo @$data -> id?"hide":""?>'>
	    <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_("Password")?></label>
	    <div class="col-md-10 col-xs-12">
	    	<input class="form-control" type="password" name="password1" id="password" />
		</div>
	</div>

	<div class='form-group password_area <?php echo @$data -> id?"hide":""?>'>
	    <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_("Re-Password")?></label>
	    <div class="col-md-10 col-xs-12">
	    	<input class="form-control" type="password" name="re-password1" id="re-password" />
		</div>
	</div>

	<div class='form-group password_area <?php echo @$data -> id?"hide":""?>'>
	    <label class="col-md-2 col-xs-12 control-label"></label>
	    <div class="col-md-10 col-xs-12">
	    	<label class="error_password"></label>
		</div>
	</div>

</table>


<script type="text/javascript">
	$('#edit_pass0').click(function(){
		$('.password_area').addClass('hide');
	});
	$('#edit_pass1').click(function(){
		$('.password_area').removeClass('hide');
	});
</script>


<script  type="text/javascript" language="javascript">
	function passwordStrength(password1,password2) {
        var shortPass = 1, badPass = 2, goodPass = 3, strongPass = 4, mismatch = 5, symbolSize = 0, natLog, score;
        if ( (password1 != password2) && password2.length > 0)
            return mismatch;
        if (password1.length < 4)
            return shortPass;
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
        return strongPass;
    }

	$(function(){
		$("#password").keyup(function(){
			pass1 = $("#password").val();
			pass2 = $("#re-password").val();
		
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

		    $(" .error_password").html(msg);
		    $(" .error_password").css('color','blue');
			
		});

		$("#re-password").keyup(function(){
			pass1 = $(" #password").val();
			pass2 = $(" #re-password").val();
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

		    $(" .error_password").html(msg);
		    $(" .error_password").css('color','blue');
			// alert(result);
		});


	
		$("#username").keyup(function(){
			var name = $(this).val();
			var id_user = $('#id_user').val()
			var illegalChars = /\W/; // allow letters, numbers, and underscores
		    if (illegalChars.test(name)) {
				$("#help-block-username").html('Viết liền không dấu');
				$("#help-block-username").css('color','red');
				return false;
		    } 
			$.ajax({url: "/admin/index.php?module=users&view=profile&task=ajax_check_name&raw=1",
				data: {name:name,id_user:id_user},
				dataType: "text",
				success: function(data) {
					console.log(data);
					if(data == 1){
						// $(" #name").css('border','red 1px solid');
						$("#help-block-username").html('Tên này đã tồn tại !');
						$("#help-block-username").css('color','red');
					}else{
						// $("#fragment-1 #name").css('border','#ccc 1px solid');
						$("#help-block-username").html('Tên này được chấp nhận');
						$("#help-block-username").css('color','#a0a0a0');
						if(!name){
							$("#help-block-username").html('Không được để trống');
							$("#help-block-username").css('color','red');
						}
					}
				}
			});
		});
	});
</script>