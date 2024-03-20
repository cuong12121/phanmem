click_pay(1);
function click_pay(){
	$("#sub-pro-liquidate").click(function () {
		$(".button-step").trigger('click');
	});
}
$('#copy_send_to_receive').click(function(){
		$('#recipients_name').val($('#sender_name').val());
		$('#recipients_email').val($('#sender_email').val());
		$('#recipients_address').val($('#sender_address').val());
		$('#recipients_telephone').val($('#sender_telephone').val());
		$('#recipients_comments').val($('#sender_comments').val());

});


function submitForm()
{
	if(checkFormsubmit())
	{
		$('#eshopcart_info').submit();
	}
	
}

function checkFormsubmit()
{
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	// sender
	if(!notEmpty("sender_name","B&#7841;n ch&#432;a nh&#7853;p t&#234;n ng&#432;&#7901;i g&#7917;i"))
		return false;
	if(!notEmpty("sender_telephone","B&#7841;n ch&#432;a nh&#7853;p s&#7889; phone ng&#432;&#7901;i nh&#7853;p"))
		return false;
	if(!isPhone("sender_telephone","B&#7841;n nh&#7853;p kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng c&#7911;a tr&#432;&#7901;ng &#273;i&#7879;n tho&#7841;i"))
		return false;
	if(!notEmpty("sender_email","B&#7841;n ch&#432;a nh&#7853;p email ng&#432;&#7901;i g&#7917;i"))
		return false;
	if(!emailValidator("sender_email","Email ng&#432;&#7901;i &#273;&#7863;t h&#224;ng kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng"))
		return false;
	if(!notEmpty("sender_address","B&#7841;n ch&#432;a nh&#7853;p &#273;&#7883;a ch&#7881; ng&#432;&#7901;i g&#7917;i"))
		return false;
	return true;
}
