$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt').click(function(){
		if(checkContactFormsubmit())
			document.contact.submit();
	})

});
 
function checkContactFormsubmit()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("contact_name","Bạn phải nhập họ tên"))
	{
		return false;
	}
	if(!notEmpty("contact_email","Hãy nhập email")){
		return false;
	}
	if(!emailValidator("contact_email","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("contact_phone","Bạn phải nhập số phone"))
		return false;
	
	if(!isPhone("contact_phone","Bạn nhập số điện thoại không hợp lệ"))
		return false;
    if(!notEmpty("contact_address","Bạn phải nhập địa chỉ"))
	{
		return false;
	}
	if(!notEmpty("message","Hãy nhập nội dung")){
		return false;
	}

	return true;
}
