function check_discount_form_popup(){

	if(jQuery.trim($('#dc_email_popup').val()) == '' || jQuery.trim($('#dc_email_popup').val()) == 'Enter your email'){

		alert('Hãy nhập email của bạn');

		$('#dc_email_popup').focus();

		return false;
	}
	var filterEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(!$('#dc_email_popup').val().match(filterEmail)){
		alert('Email chưa đúng định dạng');
		$('#dc_email_popup').focus();
		return false;
	}
	return true;
}
hover_button_popup();
function hover_button_popup(){
	$('#bt-male_popup').mouseover(function() {
		$(this).addClass('bt-select');
		$('#bt-female_popup').removeClass('bt-select');
		})
		.mouseout(function() {
			$(this).removeClass('bt-select');
			$('#bt-female_popup').addClass('bt-select');
	});
}
$('#discount_popup_content_label').click(function(){
	if($('#discount_popup_content_inner').hasClass('discount_popup_open') == true){
		$('#discount_popup_content_inner').removeClass('discount_popup_open').addClass('discount_popup_close');
//		 $(".discount_popup_content_inner").css('z-index',-1);
		$(".discount_popup_content_inner").animate({height:'toggle'});
	}else{
		$('#discount_popup_content_inner').removeClass('discount_popup_close').addClass('discount_popup_open');
//		 $(".discount_popup_content_inner").css('z-index',50);
		$(".discount_popup_content_inner").animate({height:'toggle'});
	}
});
$('.discount_description_label').click(function(){
	$('#discount_popup_content_label').trigger('click');
});
