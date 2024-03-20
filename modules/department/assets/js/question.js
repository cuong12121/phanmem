$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.question.submit();
	})
	$('#resetbt').click(function(){
		document.question.reset();
	})

});
   
function checkFormsubmit()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("txt_name","Bạn phải nhập họ tên"))
	{
		return false;
	}
    if(!notEmpty("txt_email","Hãy nhập email")){
		return false;
	}
    if(!emailValidator("txt_email","Email nhập không hợp lệ")){
		return false;
	}	
    if(!notEmpty("txt_address","Bạn phải nhập địa chỉ")){
		return false;
	}
    if(!notEmpty("txt_subject","Bạn phải nhập tiêu đề"))	{
		return false;
	}
    if(!notEmpty("txt_question","Bạn phải nhập câu hỏi"))
		return false;
	if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
		return false;
	return true;
}
