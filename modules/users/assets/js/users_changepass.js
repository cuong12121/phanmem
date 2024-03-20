$(document).ready( function(){
	$('#submitbt').click(function(){
		// alert(checkFormsubmit_changpass());
		if(checkFormsubmit_changpass()){
			document.frm_repassword_gh.submit();
		} else {
			return false;
		}
	})
})

function checkFormsubmit_changpass()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("password","Yêu cầu nhập mật khẩu mới!"))
	{
		return false;	
	}

	var pass = $('#password').val();
	if(pass != '') {
		if(!lengthMin("password",6,"Mật khẩu mới cần có ít nhất 6 ký tự!")) {
			return false;
		}
		if(!checkMatchPass("Nhập lại mật khẩu mới chưa khớp!"))
		{
			return false;	
		}
		if(!notEmpty("verify_old_password","Yêu cầu nhập mật khẩu cũ!"))
		{
			return false;	
		}
	}

	return true;
}