// submit_rate();
display_hidden_rate_form1();

$(document).ready( function(){
	/* FORM CONTACT */

	// var id = $('#record_id').val();
	var id =  $('#record_id').val();
	var rate_module = $('#_rate_module').val();
	var rate_view = $('#_rate_view').val();
	var rate_return = $('#_rate_return').val();
	$("#ratings i").click(function(){
		$('.wraper_form_rate').removeClass('hide');
		$(this).attr("id")=="rate_1"?$(".rsStar").html("Không thích"):$(this).attr("id")=="rate_2"?$(".rsStar").html("Tạm được"):$(this).attr("id")=="rate_3"?$(".rsStar").html("Bình thường"):$(this).attr("id")=="rate_4"?$(".rsStar").html("Rất tốt"):$(this).attr("id")=="rate_5"&&$(".rsStar").html("Tuyệt vời quá");
	});
	let gl_prevScore;

	let sum_r = $('#_info_rate ._level_0').length;

	if(sum_r>3){

		$('#_info_rate .rtpLnk').removeClass('hide');
	}

	$("#ratings").hover(function(){},function(){gl_prevScore==0?($(".lStar i").removeClass("star_on").addClass("star_off"),$(".rsStar").addClass("hide")):gl_prevScore>0&&$("#rate_"+gl_prevScore).click()});
	$("#ratings i").hover(function(){var n,t;for($(".lStar i").removeClass("star_on").addClass("star_off"),$(this).attr("id")=="rate_1"?$(".rsStar").html("Không thích"):$(this).attr("id")=="rate_2"?$(".rsStar").html("Tạm được"):$(this).attr("id")=="rate_3"?$(".rsStar").html("Bình thường"):$(this).attr("id")=="rate_4"?$(".rsStar").html("Rất tốt"):$(this).attr("id")=="rate_5"&&$(".rsStar").html("Tuyệt vời quá"),$(".rsStar").removeClass("hide"),n=$(this).attr("id"),n=parseInt(n.replace("rate_","")),t=1;t<=n;t++)$("#rate_"+t).removeClass("star_off").addClass("star_on");n>0&&$("#rating_value").val(n)},function(){});
	// $("#ratings #rate_1").html("Không thích");
	$("._buttom_rate").addClass('ssssss');

	// $("#_info_rate").load("/index.php?module=rates&view=rates&raw=1&id="+id+"&rate_module="+rate_module+"&rate_view="+rate_view+"&rate_return="+rate_return, {'page':0}, function() {
		// $("#1-page").addClass('active');
	// });  //initial page number to load
	change_rating();

	$('.btn-rate-mb-rep').click(function(){
		var id_cmt = $(this).parents().attr('id');
		id_cmt = id_cmt.replace('rate_reply_form','rate_content')
		// console.log(id_cmt);
		if(!notEmpty(id_cmt,"Bạn phải nhập nội dung"))
		return false;
		// if(!notEmpty("rate_content","Bạn phải nhập nội dung"))
		// return false;
		$(this).parent().find('.full-screen-mobile').toggleClass('display-open');
		$(this).parent().find('.wrap_rate').toggleClass('display-open');

		
	});

	$('._btn_rate').click(function(){
		if(!notEmpty("rate_content","Bạn phải nhập nội dung"))
		return false;
		var n=$("#rates_rate ._textarea textarea").val().length;
		if(n<30){
			$("#rates_rate .MsgRt").html('Nội dung đánh giá quá ngắn. Vui lòng nhập thêm nội dung đánh giá về sản phẩm.');
			return false;
		}
	});
	// $('._buttom_rate_rep').click(function(){
	// 	if(!notEmpty("rate_content_rep","Bạn phải nhập nội dung"))
	// 	return false;
	// });

	$('.close-md-rate').click(function(){
		$('.full-screen-mobile').removeClass('display-open');
		$('.wrap_rate').removeClass('display-open');
	});

	$('.full-screen-mobile').click(function(){
		$('.full-screen-mobile').removeClass('display-open');
		$('.wrap_rate').removeClass('display-open');
	});

});
function countTxtRating(){
		var n=$("#rates_rate ._textarea textarea").val().length,t;n>0&&n<30?(t=n+" ký tự (tối thiểu 30)",$("._textarea .ckt").html(t)):$("._textarea .ckt").html("")
		$("#rates_rate .extCt").removeClass('hide');
		if(n==0){
			$("#rates_rate .extCt").addClass('hide');
		}

	}
function search_rate(){

	var rate_keyword = $('#rate_keyword').val();
	if(!rate_keyword || rate_keyword == '')
		return false;
	var id = $('#record_id').val();
	var rate_module = $('#_rate_module').val();
	var rate_view = $('#_rate_view').val();
	var link = '/index.php?module=rates&view=rates&raw=1&rate_module='+rate_module+'&rate_view='+rate_view+'&id='+id+'&keyword='+rate_keyword;
	$.get(link,{}, function(html){ 
		$('#_info_rate').html(html);
	    $('html, body').animate({scrollTop:$('#_info_rate').position().top}, 'slow');
	});
	return false;


}



var width = $(window).width();
$(window).resize(function() {
	width = $(window).width();
	
});
function submit_rate()
{
	
	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	//if(!notEmpty("rate_content","Bạn phải nhập nội dung"))
		//return false;

	//var id_cmt = $(this).parents('.form_rate').attr('id')
		// alert('#' + id_cmt);
		//if(!notEmpty('#' + id_cmt + "rate_content","Bạn phải nhập nội dung"))
		//return false;

	if(!notEmpty("rate_name","Bạn phải nhập họ tên"))
	{
		return false;
	}
	if(!notEmpty("rate_email","Bạn phải email"))
		return false;
	if(!emailValidator("rate_email","Email nhập không hợp lệ")){
		return false;
	}
	//if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
	//	return false;
    /* stop form from submitting normally */
	// event.preventDefault();

	/* get some values from elements on the page: */
 	url = $('#link_reply_rate').val();
	/* Send the data using post */
	var posting = $.post( url, { 
		name: $('#rate_name').val(), 
		email: $('#rate_email').val(), 
		rate: $('#rating_value').val(), 
		content: $('#rate_content').val(), 
		record_id: $('#_rate_record_id').val(), 
		parent_id: $('#parent_id').val(), 
		linkurlall: $('#linkurlall').val(), 
		// module: $('#_rate_module').val(), 
		// view: $('#_rate_view').val(), 
		"return": $('#_rate_return').val()

	} );
	var id = $('#record_id').val();
	var rate_module = $('#_rate_module').val();
	var rate_view = $('#_rate_view').val();
	var rate_return = $('#_rate_return').val();
	/* Alerts the results */

	// $.ajax({url: "/index.php?module=users&task=ajax_check_captcha&raw=1",
	// 	data: {
	// 		txtCaptcha: $('#txtCaptcha').val()
	// 		},
	// 	dataType: "text",
	// 	async: false,

	// 	success: function(result) {
	// 		$('label.username_check').prev().remove();
	// 		$('label.username_check').remove();
	// 		if(result == 0){
	// 			invalid('txtCaptcha','Bạn nhập sai mã hiển thị');
	// 			return false;
	// 		} else {
	// 			posting.done(function( data ) {
	// 				// alert('Cảm ơn bạn đã gửi rate');
	// 				$('#rate_name').val('');
	// 				$('#rate_email').val('');
	// 				$('#rate_content').val('');
	// 				$("#_info_rate").load("/index.php?module=rates&view=rates&raw=1&id="+id+"&rate_module="+rate_module+"&rate_view="+rate_view+"&rate_return="+rate_return, {'page':0}, function() {
	// 					// $("#1-page").addClass('active');
	// 				});  //initial page number to load
	// 			});
	// 		}
	// 	}
		
	// });
	posting.done(function( data ) {
		alert('Cảm ơn bạn đã gửi đánh giá, chúng tôi sẽ phê duyệt đánh giá của bạn nhanh nhất !');
		$('#rate_name').val('');
		$('#rate_email').val('');
		$('#rate_content').val('');
		$("#_info_rate").load("/index.php?module=rates&view=rates&raw=1&id="+id+"&rate_module="+rate_module+"&rate_view="+rate_view+"&rate_return="+rate_return, {'page':0}, function() {
	
		$('.full-screen-mobile').removeClass('display-open');
		$('.wrap_rate').removeClass('display-open');
		

		});  //initial page number to load
	});



	
}



function submit_reply1(rate_id){
	
	if(!notEmpty2('rate_content_'+rate_id,'Nội dung','Bạn phải nhập nội dung')){
		return false;
	}
	// if(!notEmpty2("rate_name_"+rate_id,'Họ tên',"Bạn phải nhập họ tên")){
	// 	return false;
	// }
	// if(!notEmpty2('rate_email_'+rate_id,'Email',"Bạn phải nhập số email"))
	// 	return false;
	// if(!emailValidator('rate_email_'+rate_id,'Email nhập không hợp lệ')){
	// 	return false;
	// }
	
	// $('#rate_reply_form_'+rate_id).submit();
	 /* stop form from submitting normally */
	// event.preventDefault();

	/* get some values from elements on the page: */
	  url = $('#link_reply_form_'+rate_id).val();
	// /* Send the data using post */
	var posting = $.post( url, { 
		name: $('#rate_name_'+rate_id).val(), 
		email: $('#rate_email_'+rate_id).val(), 
		content: $('#rate_content_'+rate_id).val(), 
		record_id: $('#_rate_record_id_'+rate_id).val(), 
		parent_id: $('#parent_id_'+rate_id).val(), 
		rate_module: $('#_rate_module_'+rate_id).val(), 
		rate_view: $('#_rate_view_'.rate_id).val(),
		linkurlall: $('#linkurlall').val(), 
		"return": $('#_rate_return_'+rate_id).val()

	} );
	var id = $('#record_id').val();
	var rate_module = $('#_rate_module_'+rate_id).val();
	var rate_view = $('#_rate_view_'+rate_id).val();
	var rate_type = $('#_rate_type_'+rate_id).val();
	var rate_return = $('#_rate_return_'+rate_id).val();

	/* Alerts the results */
	posting.done(function( data ) {
		
		$('#rate_content_'+rate_id).val('');
		$("#_info_rate").load("/index.php?module=rates&view=rates&raw=1&id="+id+"&type="+rate_type+"&rate_module="+rate_module+"&rate_view="+rate_view+"&rate_return="+rate_return, {'page':0}, function() {
			// $("#1-page").addClass('active');
			alert('Cảm ơn bạn đã gửi đánh giá, chúng tôi sẽ phê duyệt đánh giá của bạn nhanh nhất !');
			// alert('Cảm ơn bạn đã gửi rate');
		});  //initial page number to load


	});

	console.log(id);
	console.log(rate_module);
	console.log(rate_view);
	console.log(rate_type);
	console.log(rate_return);
}
function display_hidden_rate_form1(){


	$('.button_reply_close').click(function(){
		$(this).parent().parent().parent().addClass('hide');
		// $(this).parent().parent().parent().prev().removeClass('hide');
	});
}
function button_reply(id){
	// alert(id)
	
		$('#button_reply_'+id).parent().next().removeClass('hide');
		// $('.rep_19').removeClass('hide');
		$('.rep_'+id).children().next('._level_1').removeClass('hide');
		 
		// $('.rep_'+id).removeClass('hide');


}
function showInputRating(){

	$("#rate_add_form").slideToggle('hide_form');
	$('.bcrt a').attr({'href': 'javascript:hideInputRating()'});
	$('.bcrt a').attr({'class':'close_rate'});
	$('.bcrt a').html('Đóng lại');

}
function hideInputRating(){
	$("#rate_add_form").slideToggle('hide_form');
	$('.bcrt a').attr({'href': 'javascript:showInputRating()'});
	$('.bcrt a').removeClass('close_rate');
	$('.bcrt a').html('Gửi đánh giá của bạn');

}
function change_rating(){
	var rating_disable = $('#rating_disable').val();
	
		$('#ratings i').hover(function(){
			if(rating_disable == '0'){
				value = $(this).attr('value');
				for(var i = 1; i <= 5; i ++){
					if(i <= value){
						$('#rate_'+i).removeClass('star_off').addClass('star_on');
					}else{
						$('#rate_'+i).removeClass('star_on').addClass('star_off');
					}
				}
			}
		});	
	
	// $('#ratings i').click(function(){
	// 	if(rating_disable == '0'){
	// 		value = $(this).attr('value');
	// 		$('#rating_value').val(value);
	// 		rating_disable = 1;	
			
	// 	}
	// });	
}