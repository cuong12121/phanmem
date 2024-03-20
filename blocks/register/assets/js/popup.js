
function OpenforgetPass(){
	$('.tab_reset_pass').show();
	$('.tab_login').hide();
	$('.regis_user').hide();
}

function OpenRegister(){
	$('.tab_reset_pass').hide();
	$('.tab_login').hide();
	$('.regis_user').show();
}

function OpenLogin(){
	$('.tab_reset_pass').hide();
	$('.tab_login').show();
	$('.regis_user').hide();
}

function OpenLoginPopup(){
	$('.popup-login-resgister').show();
	$('.modal-menu-full-screen').show();
	$('.modal-menu-full-screen').css("z-index","30");
	$('.tab_reset_pass').hide();
	$('.tab_login').show();
	$('.regis_user').hide();
}

function HideLoginPopup(){
	$('.popup-login-resgister').hide();
	$('.modal-menu-full-screen').hide();
}

function openPopupWindow(obj) { 
    var wID = $(obj).attr('data-id');
    var url = $(obj).attr('data-url')+'&display=popup';
    var width = $(obj).attr('data-width');
    var height = $(obj).attr('data-height');
    var w = window.open(url,wID, 'width='+width+',height='+height+',location=1,status=1,resizable=yes');
    var coords = getCenteredCoords(width,height);
    w.moveTo(coords[0],coords[1]);
}





$(document).ready( function(){
	check_exist_email();
	/****** Expert ******/
	$('.register-submit').click(function(){
		if(checkFormsubmit())
			document.register_form.submit();
	})

	$('.signin-submit').click(function(){
		if(checkFormsubmit_login())
			document.login_form.submit();
	})
});

function checkFormsubmit()
{


	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	// check_exist_email();
	if(!notEmpty("full_name","Bạn chưa nhập họ tên"))
	{
		return false;
	}

	if(!notEmpty("telephone","Bạn chưa nhập số điện thoại"))
	{
		return false;
	}

	if(!isPhone("telephone","Bạn nhập số điện thoại không hợp lệ")){
		return false;
	}

	if(!notEmpty("email","Hãy nhập email")){
		return false;
	}

	if(!emailValidator("email","Email nhập không hợp lệ")){
		return false;
	}

	if(!notEmpty("password","Bạn chưa nhập password"))
	{
		return false;
	}

	if(!lengthMin("password",6,"Bạn phải nhập từ 6 kí tự trở lên")) {
		return false;
	}
	

	if(!notEmpty("date","Bạn chưa nhập ngày sinh"))
	{
		return false;
	}

	if(!notEmpty("month","Bạn chưa nhập tháng sinh"))
	{
		return false;
	}

	if(!notEmpty("year","Bạn chưa nhập năm sinh"))
	{
		return false;
	}

	if(!notEmpty("gender","Bạn chưa nhập năm giới tính"))
	{
		return false;
	}
	// if(!checkMatchPass_2('r_password','re_password',"Retype password does not match"))
	// {
	// 	return false;	
	// }

	// if(!notEmpty("gender","Bạn chưa nhập giới tính"))
	// {
	// 	return false;
	// }
	

	return true;
}
function checkFormsubmit_login()
{

	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("email_login","Bạn chưa nhập email")){
		return false;
	}
	if(!emailValidator("email_login","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("password_login","Bạn chưa nhập mật khẩu"))
	{
		return false;
	}
	return true;
}

/* CHECK EXIST EMAIL  */
function check_exist_email(){
	$('#email').keyup(function(){
		if($(this).val() != ''){
			if(!emailValidator("email","Email không đúng định dạng"))
				return false;
			$.ajax({url: root+"index.php?module=users&task=ajax_check_exist_email&raw=1",
				data: {email: $(this).val()},
				dataType: "text",
				success: function(result) {
					console.log(result);
					$('label.email_check').prev().remove();
					$('label.email_check').remove();
					if(result == '0'){
						invalid('email','Email này đã tồn tại. Bạn hãy sử dụng email khác');
					} else {
						valid('email');
						$('<br/><div class=\'label_success username_check\'>'+'Email này được chấp nhận'+'</div>').insertAfter($('#email').parent().children(':last'));
					}
				}
			});
		}
	});
}


