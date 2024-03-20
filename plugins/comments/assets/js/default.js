// submit_comment();


$(document).ready( function(){
	/* FORM CONTACT */

	// var id = $('#record_id').val();
	var id =  $('#record_id').val();
	var cmt_module = $('#_cmt_module').val();
	var cmt_view = $('#_cmt_view').val();
	var cmt_return = $('#_cmt_return').val();
	
	// $("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
		// $("#1-page").addClass('active');
	// });  //initial page number to load
	change_rating55();

	$('.btn-comment-mb-rep').click(function(){
		var id_cmt = $(this).parents().attr('id');
		id_cmt = id_cmt.replace('comment_reply_form','cmt_content')
		// console.log(id_cmt);

		if(!notEmpty(id_cmt,"Bạn phải nhập nội dung"))
		return false;

		// if(!notEmpty("cmt_content","Bạn phải nhập nội dung"))
		// return false;

		$(this).parent().find('.full-screen-mobile').toggleClass('display-open');
		$(this).parent().find('.wrap_r').toggleClass('display-open');

		
	});
	$('.button_reply').click(function(){
		$(this).parent().next().removeClass('hide');
		// $(this).addClass('hide');
	});
	$('.button_reply_close').click(function(){
		$(this).parent().parent().parent().addClass('hide');
		// $(this).parent().parent().parent().prev().removeClass('hide');
	});

	$('.btn-comment-mb').click(function(){
		if(!notEmpty("cmt_content","Bạn phải nhập nội dung"))
		return false;
		$('.full-screen-mobile').toggleClass('display-open');
		$('.wrap_r').toggleClass('display-open');
	});

	$('.close-md-comment').click(function(){
		$('.full-screen-mobile').removeClass('display-open');
		$('.wrap_r').removeClass('display-open');
	});

	$('.full-screen-mobile').click(function(){
		$('.full-screen-mobile').removeClass('display-open');
		$('.wrap_r').removeClass('display-open');
	});

});

function search_comment(){

	var comment_keyword = $('#comment_keyword').val();
	if(!comment_keyword || comment_keyword == '')
		return false;
	var id = $('#record_id').val();
	var cmt_module = $('#_cmt_module').val();
	var cmt_view = $('#_cmt_view').val();
	var link = '/index.php?module=comments&view=comments&raw=1&cmt_module='+cmt_module+'&cmt_view='+cmt_view+'&id='+id+'&keyword='+comment_keyword;
	$.get(link,{}, function(html){ 
		$('#_info_comment').html(html);
	    $('html, body').animate({scrollTop:$('#_info_comment').position().top}, 'slow');
	});
	return false;


}



var width = $(window).width();
$(window).resize(function() {
	width = $(window).width();
	
});
function submit_comment()
{


	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	//if(!notEmpty("cmt_content","Bạn phải nhập nội dung"))
		//return false;

	//var id_cmt = $(this).parents('.form_comment').attr('id')
		// alert('#' + id_cmt);
		//if(!notEmpty('#' + id_cmt + "cmt_content","Bạn phải nhập nội dung"))
		//return false;

	if(!notEmpty("cmt_name","Bạn phải nhập họ tên"))
	{
		return false;
	}
	if(!notEmpty("cmt_email","Bạn phải email"))
		return false;
	if(!emailValidator("cmt_email","Email nhập không hợp lệ")){
		return false;
	}
	//if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
	//	return false;
    /* stop form from submitting normally */
	// event.preventDefault();

	/* get some values from elements on the page: */
 	url = $('#link_reply_form').val();
	/* Send the data using post */
	var posting = $.post( url, { 
		name: $('#cmt_name').val(), 
		email: $('#cmt_email').val(), 
		rate: $('#rating_value').val(), 
		content: $('#cmt_content').val(), 
		record_id: $('#_cmt_record_id').val(), 
		parent_id: $('#parent_id').val(), 
		linkurlall: $('#linkurlall').val(), 
		// module: $('#_cmt_module').val(), 
		// view: $('#_cmt_view').val(), 
		"return": $('#_cmt_return').val()

	} );
	var id = $('#record_id').val();
	var cmt_module = $('#_cmt_module').val();
	var cmt_view = $('#_cmt_view').val();
	var cmt_return = $('#_cmt_return').val();
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
	// 				// alert('Cảm ơn bạn đã gửi comment');
	// 				$('#cmt_name').val('');
	// 				$('#cmt_email').val('');
	// 				$('#cmt_content').val('');
	// 				$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
	// 					// $("#1-page").addClass('active');
	// 				});  //initial page number to load
	// 			});
	// 		}
	// 	}
		
	// });
	posting.done(function( data ) {
		alert('Cảm ơn bạn đã gửi comment, chúng tôi sẽ phê duyệt comment của bạn nhanh nhất !');
		$('#cmt_name').val('');
		$('#cmt_email').val('');
		$('#cmt_content').val('');
		$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
	
		$('.full-screen-mobile').removeClass('display-open');
		$('.wrap_r').removeClass('display-open');
		

		});  //initial page number to load
	});



	
}



function submit_reply(comment_id){


	if(!notEmpty2('cmt_content_'+comment_id,'Nội dung','Bạn phải nhập nội dung')){
		return false;
	}
	// if(!notEmpty2("cmt_name_"+comment_id,'Họ tên',"Bạn phải nhập họ tên")){
	// 	return false;
	// }
	// if(!notEmpty2('cmt_email_'+comment_id,'Email',"Bạn phải nhập số email"))
	// 	return false;
	// if(!emailValidator('cmt_email_'+comment_id,'Email nhập không hợp lệ')){
	// 	return false;
	// }
	
	// $('#comment_reply_form_'+comment_id).submit();
	 /* stop form from submitting normally */
	// event.preventDefault();

	/* get some values from elements on the page: */
	  url = $('#cmt_link_reply_form_'+comment_id).val();
	


	// /* Send the data using post */
	var posting = $.post( url, { 
		name: $('#cmt_name_'+comment_id).val(), 
		email: $('#cmt_email_'+comment_id).val(), 
		content: $('#cmt_content_'+comment_id).val(), 
		record_id: $('#_cmt_record_id_'+comment_id).val(), 
		parent_id: $('#cmt_parent_id_'+comment_id).val(), 
		cmt_module: $('#_cmt_module_'+comment_id).val(), 
		cmt_view: $('#_cmt_view_'.comment_id).val(),
		linkurlall: $('#linkurlall').val(), 
		"return": $('#_cmt_return_'+comment_id).val()

	} );
	var id = $('#record_id').val();
	var cmt_module = $('#_cmt_module_'+comment_id).val();
	var cmt_view = $('#_cmt_view_'+comment_id).val();
	var cmt_type = $('#_cmt_type_'+comment_id).val();
	var cmt_return = $('#_cmt_return_'+comment_id).val();
	// console.log(id);
	// console.log(cmt_module);
	// console.log(cmt_view);
	// console.log(cmt_type);
	// console.log(cmt_return);
	// return false;
	/* Alerts the results */
	posting.done(function( data ) {
		
		$('#cmt_content_'+comment_id).val('');
		$("#_info_comment").load("/index.php?module=comments&view=comments&raw=1&id="+id+"&type="+cmt_type+"&cmt_module="+cmt_module+"&cmt_view="+cmt_view+"&cmt_return="+cmt_return, {'page':0}, function() {
			// $("#1-page").addClass('active');
			alert('Cảm ơn bạn đã gửi comment, chúng tôi sẽ phê duyệt comment của bạn nhanh nhất !');
		});  //initial page number to load


	});

	
}

function change_rating55(){
	var rating_disable = $('#rating_disable1').val();
	
		$('#ratings1 i').hover(function(){
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
	
	$('#ratings1 i').click(function(){
		if(rating_disable == '0'){
			value = $(this).attr('value');
			$('#rating_value').val(value);
			rating_disable = 1;	
			
		}
	});	
}