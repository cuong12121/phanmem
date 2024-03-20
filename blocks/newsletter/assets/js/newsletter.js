function check_newletter_form(){

//	if(jQuery.trim($('#nl_name').val()) == '' || jQuery.trim($('#nl_name').val()) == 'Enter your name'){
//
//		alert('Please entered your name');
//
//		$('#nl_name').focus();
//
//		return false;
//
//	}

	if(jQuery.trim($('#nl_email').val()) == '' || jQuery.trim($('#nl_email').val()) == 'Enter your email'){

		alert('Hãy nhập email của bạn');

		$('#nl_email').focus();

		return false;

	}

	

	var filterEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

	if(!$('#nl_email').val().match(filterEmail)){

		alert('Email chưa đúng định dạng');

		$('#nl_email').focus();

		return false;

	}

	return true;

}