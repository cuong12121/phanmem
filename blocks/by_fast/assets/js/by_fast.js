$(document).ready( function(){
	/* FORM CONTACT */
	$('#smform').click(function(){
		if(check_Formsubmit())
			//document.buy_fast_form.submit();
		$('#buy_fast_form').submit();
	})
	$('#button_open_main').click(function(){
		//$('.buy_fast_main').css('display','block');
	})


});
function close_f(){
	$('#form').addClass('hide');
};

function open_f(){
	$tele= $('#telephone_buy_fast_1').val();
	$('#telephone_buy_fast').val($tele);
	$('#form').removeClass('hide');
	
};


function check_Formsubmit()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();


	if(!notEmpty("name_buy_fast","Bạn phải nhập họ tên"))
	{
		return false;
	}
	if(!notEmpty("email_buy_fast","Hãy nhập email")){
		return false;
	}
	if(!emailValidator("email_buy_fast","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("telephone_buy_fast","Bạn phải nhập số phone"))
		return false;
	
	if(!isPhone("telephone_buy_fast","Bạn nhập số điện thoại không hợp lệ"))
		return false;
	// if(!notEmpty("message","Hãy nhập nội dung")){
	// 	return false;
	

	return true;
}
