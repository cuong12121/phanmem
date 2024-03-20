//tinyMCE.init({
//	// General options
//	mode : "exact",
//	elements : "message",
//	theme : "advanced",
//	plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
//	
//	// Theme options
//	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//	theme_advanced_buttons2 : "link,unlink,|,forecolor,backcolor,|,sub,sup,|,charmap,emotions,iespell,sub,sup,|,charmap,emotions,iespell",
//	theme_advanced_buttons3 : "",
//	theme_advanced_toolbar_location : "top",
//	theme_advanced_toolbar_align : "left",
//	theme_advanced_resizing : true
//});
//tinyMCE.init({
//	// General options
//	mode : "exact",
//	elements : "message_f",
//	theme : "advanced",
//	plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
//
//	// Theme options
//	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//	theme_advanced_buttons2 : "link,unlink,|,forecolor,backcolor,|,sub,sup,|,charmap,emotions,iespell,sub,sup,|,charmap,emotions,iespell",
//	theme_advanced_buttons3 : "",
//	theme_advanced_toolbar_location : "top",
//	theme_advanced_toolbar_align : "left",
//	theme_advanced_resizing : true
//});
function checkSubmitForwardForm()
{
	$('#msg_error_f').html('');
	count_error =0;
	if($('#recipients_f').val().length == 0 )
	{
		$("#msg_error_f").html($("#msg_error_f").html() + "<li>Bạn hãy điền danh sách người nhận </li>");
		count_error++;
	}

//	var numericExpression = /^[0-9; ]+$/;
//	if(!$('#recipients_f').val().match(numericExpression) ){
//		$("#msg_error_f").html($("#msg_error_f").html() + "<li>Danh s&#225;ch kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng</li>");
//		count_error++;
//	}
//	
	if($('#subject_f').val().length == 0 )
	{
		$("#msg_error_f").html($("#msg_error_f").html() + "<li>Nhập tiêu đề bài viết </li>");
		count_error++;
	}
	if ( (tinyMCE.get('message_f').getContent()=="") || (tinyMCE.get('message_f').getContent()==null) ) {
     	$("#msg_error_f").html($("#msg_error_f").html() + "<li>Nhập nội dung</li>");
     	count_error++;
	}
	 
	if(count_error)
	{
		return false;
	}
	return true;
}
function _checkSubmitForm()
{
	$('#msg_error').html('');
	count_error =0;
	if(!notEmpty("recipients","Bạn hãy điền danh sách người nhận"))
	{
		count_error ++;
	}
	if(!isNumericList("recipients","Danh sách không đúng định dạng"))
	{
		count_error ++;
	}
	 if ( (tinyMCE.get('message').getContent()=="") || (tinyMCE.get('message').getContent()==null) ) {
	     	$("#msg_error").html($("#msg_error").html() + "<li>Nh&#7853;p n&#7897;i dung</li>");
	     	count_error++;
	 }
	if(count_error)
	{
		return false;
	}
	return true;
}
$(document).ready(function() {
	$(".reply_bt").click(function(){
		$('#reply').show();
		$('#reply #recipients').focus();
		$('#forward').hide();
	});
	$(".forward_bt").click(function(){
		$('#reply').hide();
		$('#forward').show();
		$('#forward #recipients_f').focus();
	});
    
    
});


function sendMail()
{
    
	count_error = 0;
	$('#msg_error').html('');
	if(!notEmpty("recipients","Bạn hãy điền danh sách người nhận"))
		return false;
	if(!notEmpty("subject","Nhập tiêu đề bài viết"))
		return false;
     
     if ( (tinyMCE.get('message').getContent()=="") || (tinyMCE.get('message').getContent()==null) ) {
     	$("#msg_error").html($("#msg_error").html() + "<li>Nh&#7853;p n&#7897;i dung</li>");
     	return false;
 	}
     document.fontForm.submit();
}

