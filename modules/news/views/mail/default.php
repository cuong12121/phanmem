<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	<title>Send mail</title>
</head>
<body>
	<form method="post" enctype="multipart/form-data" name="frmSubmit" action="<?php echo FSRoute::_('index.php?module=news&view=mail&task=send'); ?>">
		<input type="hidden" value="<?php echo FSInput::get('url');?>" name="url" />
		<input type="hidden" value="news" name="module" />
		<input type="hidden" value="mail" name="view" />
		<input type="hidden" value="send" name="task" />
		<input type="hidden" value="1" name="raw" />
		<table cellspacing="0" cellpadding="0" border="0" align="center" width="468">
			<tbody>
				<tr><td colspan="2">
					<img border="0" src="<?php echo URL_ROOT.'images/logos/logo_pmi.jpg'?>"/></td></tr>
				<tr><td height="10" colspan="2"></td></tr>
				<tr><td height="16" bgcolor="#C2E218" valign="top" class="Time" colspan="2">Gửi cho bạn bè bài báo này</td></tr>
				<tr><td height="1" bgcolor="#C2E218" colspan="2"></td></tr>
				<tr><td height="8" colspan="2"></td></tr>
				<tr>
					<td class="SForm" colspan="2">
						<div id='msg_error'></div>
				</td></tr>
				<tr>
					<td class="SForm">Tên của bạn:</td>
					<td align="left" class="SForm">
						<input type="text" style="width: 300" size="30" value="" class="SForm" name="name" id='name' tabindex="1">
				</td></tr>
			
				<tr>
					<td class="SForm">Email của bạn:</td>
					<td align="left" class="SForm"><input type="text" style="width: 300" size="30" value="" class="SForm" name="email" id='email'  tabindex="2">
				</td></tr>
				<tr>
					<td class="SForm">Gửi đến (To):</td>
					<td align="left" class="SForm"><input type="text" style="width: 300" size="30" value="" class="SForm" name="to" id='to' tabindex="3" />
				</td></tr>
				<tr>
					<td class="SForm">Đồng gửi đến (CC):</td>
					<td align="left" class="SForm"><input type="text" style="width: 300" size="30" value="" class="SForm" name="cc" id='cc' tabindex="4" />
				</td></tr>
				<tr>
					<td class="SForm">Tiêu đề (Subject):</td>
					<td align="left" class="SForm">
						<input type="text" style="width: 300" size="30" value="" class="SForm" name="subject" id='subject' tabindex="5" />
				</td></tr>
				<tr>
					<td class='SForm'><?php echo "Nh&#7853;p m&atilde; hi&#7875;n th&#7883;"; ?></td>
					<td class='SForm' >
						<a onclick="reloadCaptcha();" title="<?php echo "&#7844;n v&#224;o &#7843;nh &#273;&#7875; &#273;&#7893;i m&#227; kh&#225;c";?>" >
							<img id="keystring_img" src="<?php echo URL_ROOT; ?>libraries/kcaptcha/index.php?<?php echo session_name()?>=<?php echo session_id()?>" /></a>
							<br/>
						<input type="text" name="keystring" id="keystring" class='SForm' />
					</td>
				</tr>
				<tr>
					<td valign="top" class="SForm" >
						<table  cellspacing="0" cellpadding="0" border="0" width="100%">
						<tbody><tr><td height="20" class="SForm">Thông điệp (Message):</td></tr>
						<tr><td valign="bottom">
							<input type="submit" onclick="return check_submit()" value="Gửi" tabindex="7" />
							&nbsp;
							<input type="button"  onclick="window.parent.close()" value = "Hủy" />
						</td></tr>
						</tbody></table>
					</td>
					<td align="left" class="SForm">
						<textarea style="width: 300; height: 100" rows="5" cols="30" class="SForm" tabindex="6" name="message" id='message'></textarea>
					</td>
				</tr>
				<tr><td height="5" colspan="2"></td></tr>
				<tr><td height="1" bgcolor="#C2E218" colspan="2"></td></tr>
				<tr><td height="5" colspan="2"></td></tr>
				<tr><td colspan="2"><script language="JavaScript">//DisplayBanner()</script></td></tr>
			</tbody>
		</table>
	</form>
	<script type="text/javascript" language="JavaScript" src="<?php echo URL_ROOT;?>libraries/jquery/jquery.min.js"></script>
	<script type="text/javascript" language="JavaScript" src="<?php echo URL_ROOT;?>templates/default/js/functions.js"></script>
	<script type="text/javascript">
		function check_submit(){
			$('#msg_error').html('');
			if(!notEmpty("name","<?php echo FSText::_("Bạn chưa nhập tên"); ?>"))
				return false;
			if(!notEmpty("email","<?php echo FSText::_("Bạn chưa nhập email"); ?>"))
				return false;
			if(!notEmpty("to","<?php echo FSText::_("Bạn chưa nhập email đến"); ?>"))
				return false;
			if(!notEmpty("subject","<?php echo FSText::_("Bạn chưa nhập tiêu đề"); ?>"))
				return false;
			if(!notEmpty("keystring","<?php echo FSText::_("Bạn chưa nhập mã hiển thị"); ?>"))
				return false;
			return true;
		}
		function reloadCaptcha()
		{
			<?php unset($_SESSION['captcha_keystring']);?>
			$("#keystring_img").attr({ 
		        src: "<?php echo URL_ROOT; ?>libraries/kcaptcha/index.php?<?php echo session_name();?>=<?php echo session_id();?>&n=" + Math.random() });
		}
	</script>
	<style >
		#msg_error li{
			color: red;
			text-align: center;	
		}
		.redborder {
		    border: 1px solid red;
		}
		.message-content {
		     color: red;
		    font-size: 19px;
		    text-align: center;
		}
		
	</style>
</body>
</html>