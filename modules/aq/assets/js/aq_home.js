$(document).ready( function(){
	/* FORM CONTACT */
	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.aks.submit();
	})
	$('#resetbt').click(function(){
		document.aks.reset();
	})
	display_hiden_reply();
});

function display_hiden_reply(){
	$('.aq_title').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
		}
		$(this).next('.item-content').toggle();
	});
}

function checkFormsubmit()
{
	if(!notEmpty("name","Bạn phải nhập tên")){
		return false;
	}
	if(!notEmpty("email","Hãy nhập email")){
		return false;
	}
	if(!emailValidator("email","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("title","Bạn phải nhập chủ đề")){
		return false;
	}
	
	if(!notEmpty("message","Bạn phải nhập câu hỏi")){
		return false;
	}
		
	if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
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
//				alert('Bạn nhập sai mã hiển thị');
				console.log('--------');
				return false;
			} else {
				valid('txtCaptcha');
//				$('<br/><div class=\'label_success username_check\'>'+'Bạn đã nhập đúng mã hiển thị'+'</div>').insertAfter($('#username').parent().children(':last'));
				$('.button_area').html('<span> </span><a class="button " href="javascript: void(0)"><span>&nbsp;Gửi&nbsp;</span></a><a id="resetbt" class="button" href="javascript: void(0)"><span>Làm lại</span></a>');
				console.log('+++');
					document.aks.submit();
				return true;
			}
		}
	});
}
//$('.send_requirement').click(function(){
//	$('#smart-green-demo #name').focus();
//});  
$('.ask').click(function(e){
	
	var id = $(this).attr('data-id');
		$('#'+id).show();
    e.preventDefault();
});  
$('.button-close').click(function(e){
	$( this ).parent().parent().hide();
    e.preventDefault();
});