function check_discount_form(){

	if(jQuery.trim($('#dc_email').val()) == '' || jQuery.trim($('#dc_email').val()) == 'Enter your email'){

		alert('Hãy nhập email của bạn');

		$('#dc_email').focus();

		return false;

	}


	var filterEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(!$('#dc_email').val().match(filterEmail)){

		alert('Email chưa đúng định dạng');

		$('#dc_email').focus();

		return false;

	}

	return true;

}
hover_button();
function hover_button(){
	$('#bt-male').mouseover(function() {
		$(this).addClass('bt-select');
		$('#bt-female').removeClass('bt-select');
		})
		.mouseout(function() {
			$(this).removeClass('bt-select');
			$('#bt-female').addClass('bt-select');
	});
}