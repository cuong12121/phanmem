$(document).ready( function(){

	$('#resetbt').click(function(){
		document.comment_add_form.reset();
	});
	submit_comment();
	display_hidden_comment_form();

});
	     
function submit_comment()
{
	$('#submitbt').click(function(){
		if(!notEmpty2("name",'Họ tên',"Bạn phải nhập họ tên"))
		{
			return false;
		}
		if(!notEmpty2("email",'Email',"Bạn phải nhập số email"))
			return false;
		if(!emailValidator("email","Email nhập không hợp lệ")){
			return false;
		}
		if(!notEmpty2("text",'Nội dung',"Bạn phải nhập nội dung"))
			return false;
		if(!notEmpty2("txtCaptcha","Mã kiểm tra","Bạn phải nhập mã hiển thị"))
			return false;
		$.ajax({url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
			data: {txtCaptcha: $('#txtCaptcha').val()},
			dataType: "text",
			async: false,
			success: function(result) {
				console.log(result);
				$('label.username_check').prev().remove();
				$('label.username_check').remove();
				if(result == 0){
					invalid('txtCaptcha','Bạn nhập sai mã hiển thị');
					console.log('--------');
					return false;
				} else {
					valid('txtCaptcha');
					$('<br/><div class=\'label_success username_check\'>'+'Bạn đã nhập đúng mã hiển thị'+'</div>').insertAfter($('#username').parent().children(':last'));
					console.log('+++');
						$('.button_area').html('<a class="button " href="javascript: void(0)"><span>Gửi</span></a><a id="resetbt" class="button" href="javascript: void(0)"><span>Làm lại</span></a>');
						document.comment_add_form.submit();
					return true;
				}
			}
		});
	});
}

/****** TREE COMMENTS ******/
function submit_reply(comment_id){
	if(!notEmpty2("name_"+comment_id,'Họ tên',"Bạn phải nhập họ tên")){
		return false;
	}
	if(!notEmpty2('email_'+comment_id,'Email',"Bạn phải nhập số email"))
		return false;
	if(!emailValidator('email_'+comment_id,'Email nhập không hợp lệ')){
		return false;
	}
	if(!notEmpty2('text_'+comment_id,'Nội dung','Bạn phải nhập nội dung')){
		return false;
	}
	$('#comment_reply_form_'+comment_id).submit();
}
function display_hidden_comment_form(){
	$('.button_reply').click(function(){
		$(this).next().removeClass('hide');
		$(this).addClass('hide');
	});
	$('.button_reply_close').click(function(){
		$(this).parent().parent().parent().addClass('hide');
		$(this).parent().parent().parent().prev().removeClass('hide');
	});
}
/****** end .TREE COMMENTS ******/