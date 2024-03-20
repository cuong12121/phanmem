$(document).ready( function(){
	
	$('#resetbt').click(function(){
		document.comment_add_form.reset();
	});
	click_tab_detail(1);
	
	display_hidden_comment_form();
	
	/****** CHECK CAPTCHA ****/
//	check_captcha();
});

/*
 * Các tab "thông số kĩ thuât, video,...
 */
function click_tab_detail(){
	$('.product_tabs li').click(function(){
		var id=$(this).attr('id');
		$('.product_tabs').find('.activated').removeClass('activated');
		$('#'+id).addClass('activated');
		$('.product_tab_content').find('.selected').removeClass('selected').addClass('hiden');
		$('#'+id+'_content').removeClass('hiden').addClass('selected');
	});
}
/*
 * Tab sản phẩm tương tự, liên quan
 */
//function click_open_tab(){
//	$('.product_tabs .open_close').click(function(){
//		var status=$('.product_tab_content').css('display');
//		if(status=="block"){
//			$('.product_tab_content').css({'display':'none'});
//			$('.open_close').css({'background':'url("'+root+'modules/products/assets/images/icon-open.png") no-repeat scroll 0 14px transparent'});
//		}else{
//			$('.product_tab_content').css({'display':'block'});
//			$('.open_close').css({'background':'url("modules/products/assets/images/icon-close.png") no-repeat scroll 0 14px transparent'});
//		}
//		
//	});
//}
//function click_open_block(){
//	$('.block-product-list .open_close').click(function(){
//		var id=$(this).attr('id');
//		var status=$('#'+id+'_content').css('display');
//		if(status=="block"){
//			$('#'+id+'_content').css({'display':'none'});
//			$('#'+id).css({'background':'url("'+root+'modules/products/assets/images/icon-open.png") no-repeat scroll 0 14px transparent'});
//		}else{
//			$('#'+id+'_content').css({'display':'block'});
//			$('#'+id).css({'background':'url("modules/products/assets/images/icon-close.png") no-repeat scroll 0 14px transparent'});
//		}
//	});
//}
//function favourite(id){
//  		$.ajax({
//	  url: root+"index.php?module=products&view=favourites&task=add&raw=1&data="+id,
//	  cache: false,
//	  
//	  success: function(json){
//	  		json = jQuery.trim(json);
//	    	if(json == '1')
//	    	{
//	    		alert("Bạn đã lưu thành công vào danh mục yêu thích");
//	    		return 0;
//	    	}
//	    	else if(json == '2')
//	    	{
//	    		alert("Sản phẩm này đã tồn tại trong danh mục yêu thích của bạn");
//	    		return true;
//	    	}
//	    	else 
//	    	{
//	    		alert("Không lưu vào danh mục yêu thích");
//				return true;
//	    	}
//	  },
//	  error: function()
//	  {
//		 console.log('error');
//		 return false;
//	  }
//});
//}
//function submit_comment(){
//	$('#submitbt').click(function(){
//		if(check_submit_comment())
//			document.comment_add_form.submit();
//	});
//}
	
function submit_comment()
{
	$('#submitbt').click(function(){
		if(!notEmpty2("name",'Họ tên',"Bạn phải nhập họ tên"))
		{
			return false;
		}
		if(!notEmpty2("email",'Email',"Bạn phải nhập số email"))
			return false;
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
					document.comment_add_form.submit();
					return true;
				}
			}
		});
	}
//	console.log('uuu');
//	return false;
//	return true;
}
function ajax_check_captcha(){
	
}

function buy_add(product_id){
	link = root + 'index.php?module=products&view=cart&task=buy_multi&id='+product_id+'&Itemid=94';
	id_add  = '';
	i = 0;
	if($('.product_incentives')){
		$('.product_incentives').each(function(index) {
			if($(this).is(':checked')){
				if(i > 0)
					id_add += ',';	
				id_add += $(this).val();	
				i ++;
			}
		});
	}
	if(id_add){
		link += '&add='+id_add
	}
	window.location = link;
}
//function recal_sum_product_incentives(){
//	$('.product_incentives').click(function(){
//		total = parseInt($('#product_price').val());
//		total_old = total;
//		$('.product_incentives').each(function(index, value){
//			if($(this).is(':checked')){
////				console.log($(this));
//				total += parseInt($(this).attr('rel'));	
//				total_old += parseInt($(this).attr('rel1'));	
//			}	
//		});
//		
//		$('#total_money_incentives').html(formatCurrency(total)+' VNĐ');
//		$('.total_money_incentives_old').html(total_old+' VNĐ');
//	})
//}
//function formatCurrency(num) {
//	num = num.toString().replace(/\$|\,/g,'');
//	if(isNaN(num))
//	num = "0";
//	sign = (num == (num = Math.abs(num)));
//	num = Math.floor(num*100+0.50000000001);
//	cents = num%100;
//	num = Math.floor(num/100).toString();
//	if(cents<10)
//	cents = "0" + cents;
//	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
//	num = num.substring(0,num.length-(4*i+3))+','+
//	num.substring(num.length-(4*i+3));
//	return (((sign)?'':'-')  + num );
//}


function submit_reply(comment_id){
	if(!notEmpty2("name_"+comment_id,'Họ tên',"Bạn phải nhập họ tên")){
		return false;
	}
	if(!notEmpty2('email_'+comment_id,'Email',"Bạn phải nhập số email"))
		return false;
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