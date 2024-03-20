<?php 
global $tmpl;
$tmpl -> addScript('form');
$Itemid = CInput::get('Itemid',0);
$link_back = Route::_("index.php?module=messages&Itemid=$Itemid");
?>
						<!-- FORM							-->
							<?php $url = $_SERVER["REQUEST_URI"]; ?>
						<form action="<?php echo $url; ?>" name="fontForm" method="post" onsubmit="javascript: return checkSubmitForm();">
							<div class="form_user_body">
								
								<div class="form_user_body_inner">
									<div id = "msg_error"></div>
									<!--		FORM MAIN - MESSAGE						-->
									<table width="100%" cellpadding="5" >
										<tr>
											<td></td>
											<td>
												<span class='red'>M&#7895;i member c&#225;ch nhau b&#7903;i d&#7845;u ";". V&#237;  917453234;917736483
												</span>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>Danh s&#225;ch ng&#432;&#7901;i nh&#7853;n</td>
											<td>
												<input type="text" name='recipients' id='recipients'/>
											</td>
										</tr>
										
										<tr>
											<td> <span class='red'>*</span>N&#7897;i dung</td>
											<td>
												<textarea rows="8" cols="30" name='message' id='message'></textarea>
											</td>
										</tr>
										<tr>
											<td ></td>
											<td >
												<input type="submit" value="Send" name = 'submit_bt' />
												<br/>
												<br/>
											</td>
										</tr>
									</table>
									<!--		end FORM MAIN - MESSAGE						-->
									
								</div>
							</div>
							<input type="hidden" name="module" value="messages">
							<input type="hidden" name="view" value="messages">
							<input type="hidden" name="task" value="save_reply">
							<input type="hidden" name="message_id" value="<?php echo CInput::get('id'); ?>">
							<input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
						</form>			
<script type="text/javascript" >
function checkSubmitForm()
{
	$('msg_error').innerHTML = '';
	count_error =0;
	if(!notEmpty("recipients","<?php echo "B&#7841;n h&#227;y &#273;i&#7873;n danh s&#225;ch ng&#432;&#7901;i nh&#7853;n "; ?>"))
	{
		return false;
	}
	if(!isNumericList("recipients","<?php echo "Danh s&#225;ch kh&#244;ng &#273;&#250;ng &#273;&#7883;nh d&#7841;ng"; ?>"))
	{
		return false;
	}
	if(!notEmptyTextarea("message","<?php echo "Nh&#7853;p n&#7897;i dung"; ?>"))
	{
		return false;
	}
	if(!notEmpty("keystring","<?php echo "B&#7841;n h&#227;y nh&#7853;p m&#227; hi&#7875;n th&#7883;"; ?>"))
	{
		return false;
	}
	if(!count_error)
	{
		return true;
	}
}
</script>
