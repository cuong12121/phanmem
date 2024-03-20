<?php
	global $tmpl;
	$tmpl -> addStylesheet('question','modules/faq/assets/css');
	$tmpl -> addScript('question','modules/faq/assets/js');
	
	$txt_name = FSInput::get('txt_name');
	$txt_email = FSInput::get('txt_email');
	$txt_address = FSInput::get('txt_address');
	$txt_subject = FSInput::get('txt_subject');
	$txt_question = htmlspecialchars_decode(FSInput::get('txt_question'));
?>	
<h1><span>Những câu hỏi thường gặp</span></h1>
<div class="faq-question mt20 row">

    <div class="col-lg-2">
    	<?php echo $tmpl -> load_direct_blocks('faq_menu',array('style'=>'default')); ?>
    </div>
    <div class="col-left col-lg-10">
	    <form method="post" action="#" name="question" class="form" >
			<table  cellpadding="5"  class="question_table">
				<tbody>
					<tr>
						<td>&nbsp;</td>
						<th class="form_text">Gửi câu hỏi</th>
					</tr>
					<tr>
						<td class="form_name"><?php echo FSText::_('Họ tên:'); ?> <font color="red">*</font></td>
						<td class="form_text">
							<input type="text" maxlength="255"  value="<?php echo $txt_name; ?>" name="txt_name" id="txt_name" title="Họ và tên" class="form_control"/>
						</td>
					</tr>
					 <tr>
						<td class="form_name">Email: <font color="red">*</font></td>
						<td class="form_text">
							<input type="text" maxlength="255"  value="<?php echo $txt_email; ?>" name="txt_email" id="txt_email" title="Email" class="form_control"/>
						</td>
					</tr>
	                <tr>
						<td class="form_name">Địa chỉ: <font color="red">*</font></td>
						<td class="form_text">
							<input type="text" maxlength="255"  value="<?php echo $txt_address; ?>" name="txt_address" id="txt_address" title="Địa chỉ" class="form_control"/>
						</td>
					</tr>
					 <tr>
						<td class="form_name"><?php echo FSText::_('Tiêu đề'); ?>: <font color="red">*</font></td>
						<td class="form_text">
							<input type="text" maxlength="255"  value="<?php echo $txt_subject; ?>" name="txt_subject" id="txt_subject" title="Tiêu đề" class="form_control"/>
						</td>
					</tr>
					<tr>
						<td class="form_name form_message"><?php echo FSText::_('Câu hỏi'); ?>: <font color="red">*</font></td>
						<td class="form_text">
							<textarea rows="5" name='txt_question' id='txt_question' ><?php echo $txt_question; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="form_name"><?php echo FSText::_('Mã xác nhận:'); ?> </td>
						<td class="form_text">
							<img id="imgCaptcha" src="<?php echo URL_ROOT?>libraries/jquery/ajax_captcha/create_image.php" />
							<a href="javascript:changeCaptcha();"  title="Click here to change the captcha" class="code-view" >
							<img src="<?php echo URL_ROOT.'images/change_captcha.gif';?>">
							</a>
							<input type="text"  id="txtCaptcha" value="" name="txtCaptcha"  maxlength="10" size="23" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td class="form_name">&nbsp;</td>
						<td class="form_text">
							<a class="button" href="javascript: void(0)" id='submitbt'>
								<span><?php echo FSText::_('Gửi'); ?></span>
							</a>
							<a class="button" href="javascript: void(0)" id='resetbt'>
								<span><?php echo FSText::_('Nhập lại'); ?></span>
							</a>
						</td>
					</tr>
				</tbody>
			</table>
			
			<input type="hidden" name="module" value="faq"/>
			<input type="hidden" name="task" value="save"/>
			<input type="hidden" name="view" value="question"/>
		</form>
     </div>
</div>
