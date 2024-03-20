$(document).ready( function(){
	$( "#password" ).keyup(function() {
		var password = $(this).val();
		if(password) {
			$('.change_pass').removeClass('hide');
		}else {
			$('.change_pass').addClass('hide');
			$('#re-password').val('');
			// $('#verify_old_password').val('');
		}
	});
	/* REGISTER FORM */
	$('#submitbt').click(function(){
		if(checkFormsubmit_user_edit()){
			document.form_user_edit.submit();
		} else {
			return false;
		}
	})
//	
//	// Famous in right column 
//	$(".famous_item_head").click(function () {
//		famous_body = $(this).next();
//		famous_body.slideToggle(600);
//		
//		tag_parent = $(this).parent();
//		if(tag_parent.hasClass('famous_openned'))
//			tag_parent.removeClass('famous_openned').addClass('famous_closed');
//		else 
//			tag_parent.removeClass('famous_closed').addClass('famous_openned');
//	})

});

function checkFormsubmit_user_edit()
{
	
	$('label.label_error').prev().remove();
	$('label.label_error').remove();

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


	if(!notEmpty("full_name","Không được để tên trống!"))
	{
		return false;	
	}
	// if(!notEmpty("email","Nhập email"))
	// {
	// 	return false;	
	// }

	// if(!emailValidator("email","Email không đúng định dạng"))
	// {
	// 	return false;	
	// }
	if(!notEmpty("telephone","Không được để số điện thoại trống!"))
	{
		return false;
	}
	if(!isPhone("telephone","Số điện thoại nhập không đúng định dạng!"))
	{
		return false;	
	}


	return true;
//	if(!notEmpty("telephone","Nhập số điện thoại cố định"))
//		return false;
//	if(!isPhone("telephone","Nhập số điện thoại cố định"))
//		return false;	
//	if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
// return false;

//	if($('#use_estore').is(':checked') == true){
//		if(!notEmpty("cpn_name","Nhập tên công ty"))
//			return false;
//		if(!notEmpty("cpn_telephone","Nhập điện thoại cố định của công ty"))
//			return false;
//		if(!isPhone("cpn_telephone","Số cố định không đúng định dạng"))
//			return false;
//	}
//	if(!madeCheckbox("read_term","Bạn chưa đồng ý với các điều kiện đăng kí thành viên"))
//		return false;


}
// click_edit_user_info(1);
function click_edit_user_info(){
	$('.edit-user-info').click(function(){
		var id=$(this).attr('lang');
		$('.button-submit-tr').css({'display':'block'});
		if(id == 'birthday'){
			birth_day = $('#birth_day').val();
			birth_month = $('#birth_month').val();
			birth_year = $('#birth_year').val();
			$.get('index.php?module=users&task=views_select_birthday&raw=1&birth_day='+birth_day+'&birth_month='+birth_month+'&birth_year='+birth_year,function(response){
				$('#td-wapper-birthday').html(response);
//				alert(response);
});
			
		}else{
			$('#'+id).removeAttr('disabled').css({'border':'1px solid #7f9db9','background-color':'#fff'});
		}
		
	});
	$('.button-reset-edit').click(function(){
		location.reload();
	});
}