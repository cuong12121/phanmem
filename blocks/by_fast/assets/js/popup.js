
function submit_form_buy_fast_popup()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("name_buy_fast_popup","Bạn phải nhập họ tên"))
		return false;
	if(!notEmpty("telephone_buy_fast_popup","Bạn phải nhập số phone"))
		return false;
	if(!isPhone("telephone_buy_fast_popup","Bạn nhập số điện thoại không hợp lệ"))
		return false;
	if(!notEmpty("email_buy_fast_popup","Bạn phải nhập email"))
		return false;
	if(!emailValidator("email_buy_fast_popup","Email nhập không hợp lệ")){
		return false;
	}

	$( ".close-pro" ).trigger( "click" );
	$("#buy_fast_form_popup").submit();
		  
}