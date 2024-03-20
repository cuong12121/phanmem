//tinyMCE.init({
//		// General options
//		mode : "exact",
//		elements : "message",
//		theme : "advanced",
//		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
//
//		// Theme options
//		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
//		theme_advanced_buttons2 : "link,unlink,|,forecolor,backcolor,|,sub,sup,|,charmap,emotions,iespell,sub,sup,|,charmap,emotions,iespell",
//		theme_advanced_buttons3 : "",
//		theme_advanced_toolbar_location : "top",
//		theme_advanced_toolbar_align : "left",
//		theme_advanced_resizing : true
//
//	
//	});
function sendMail()
{
	count_error = 0;
	$('#msg_error').html('');
	if(!notEmpty("recipients_username","Nhập username người nhận"))
		return false;
			if(!notEmpty("subject","Nhập tiêu đề bài viết"))
		return false;
//	if(!notEmpty("message","Nhập nội dung"))
//		return false;
//     
//     if ( (tinyMCE.get('message').getContent()=="") || (tinyMCE.get('message').getContent()==null) ) {
//     	$("#msg_error").html($("#msg_error").html() + "<li>Nhập nội dung</li>");
//     	return false;
// 	}
	//document.fontForm.submit();
    document.getElementById("fontForm").submit();
}