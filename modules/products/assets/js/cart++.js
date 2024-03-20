function check_submit_form(){
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("username","Bạn phải nhập tên truy nhập"))
		return false;
	if(!notEmpty("password","Bạn phải nhập mật khẩu"))
		return false;
	return true;
}
function step_continue(){
	is_continue = $('#is_continue').val();
	if(is_continue == 1){
		$('#eshopcart_member_frm').submit();
	} else {
		alert('Không thể chuyển sang bước tiếp theo. Hãy đăng nhập để hoàn tất giỏ hàng');
	}
}
function order_save(link,total){
	if(confirm('Chúng tôi sẽ trừ '+total+' trong tài khoản của quý vị (nếu đủ tiền). Bạn có chắc chắn đặt hàng?')){
		window.location=link;
	}
}
function payment_for_order(order_id,money){
	if(confirm('Chúng tôi sẽ trừ '+money+' trong tài khoản của quý vị (nếu đủ tiền) để thanh toán cho đơn hàng này. Bạn có chắc chắn đặt hàng?')){
		window.location='index.php?module=products&view=order&id='+order_id+'&task=payment_for_order';
	}
}
function recieved_order(order_id){
	if(confirm('Bạn chắc chắn đã nhận hàng đảm bảo đúng như đơn hàng bạn đã chọn?')){
		window.location='index.php?module=products&view=order&id='+order_id+'&task=recieved_order';
	}
}
function cancel_order(order_id,str_notice){
	if(str_notice){
		if(confirm(str_notice)){
			window.location='index.php?module=products&view=order&id='+order_id+'&task=cancel_order';
		}
	}else{
		window.location='index.php?module=products&view=order&id='+order_id+'&task=cancel_order';
	}
}